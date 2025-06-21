<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Control Panel</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <?php
  require_once('../swad/static/elements/sidebar.php');
  require_once('../swad/config.php');
  $db = new Database();

  // Проверка прав
  if ($curr_user->getUserRole($_SESSION['id'], "global") != -1 && $curr_user->getUserRole($_SESSION['id'], "global") < 3) {
    echo ("<script>alert('У вас нет прав на использование этой функции');</script>");
    exit();
  }

  // Обработка подтверждения студии
  if (isset($_GET['approve'])) {
    $org_id = (int)$_GET['approve'];

    // Обновляем статус студии
    $stmt = $db->connect()->prepare("UPDATE user_organization SET status = 'active' WHERE organization_id = ?");
    $stmt->execute([$org_id]);

    // Получаем owner_id студии
    $stmt = $db->connect()->prepare("SELECT user_id FROM user_organization WHERE organization_id = ?");
    $stmt->execute([$org_id]);
    $owner_id = $stmt->fetchColumn();

    // Обновляем глобальную роль владельца
    $stmt = $db->connect()->prepare("UPDATE users SET global_role = 2 WHERE id = ?");
    $stmt->execute([$owner_id]);

    echo ("<script>alert('Студия успешно подтверждена!'); window.location.href = 'recentorgs';</script>");
    exit();
  }

  // Обработка отклонения студии
  if (isset($_GET['reject'])) {
    $org_id = (int)$_GET['reject'];

    // Удаляем студию
    $stmt = $db->connect()->prepare("UPDATE user_organization SET status = 'suspended' WHERE organization_id = ?");
    $stmt->execute([$org_id]);

    echo ("<script>alert('Студия отклонена!'); window.location.href = 'recentorgs';</script>");
    exit();
  }
  ?>

  <main>
    <section class="content">
      <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out" class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a>
        <h1 class="page-announce-text valign">// Новые студии, требующие проверки</h1>
      </div>
      <div id="posttable" class="container">
        <table class="responsive-table striped hover centered" id="names-table">
          <thead>
            <tr>
              <th>Название:</th>
              <th>Дата регистрации:</th>
              <th>ID студии:</th>
              <th>Ссылка на VK-группу:</th>
              <th>ID владельца, @username:</th>
              <th>Действия:</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Получаем все студии со статусом pending
            $stmt = $db->connect()->prepare("
                SELECT uo.*, u.first_name 
                FROM user_organization uo
                JOIN users u ON uo.user_id = u.id
                WHERE uo.status = 'pending'
            ");
            $stmt->execute();
            $orgs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($orgs as $org): ?>
              <tr>
                <td><?= htmlspecialchars($curr_user->getOrgData($org['organization_id'])['name']) ?></td>
                <td><?= date('Y-m-d', strtotime($org['created_at'])) ?></td>
                <td><?= $org['organization_id'] ?></td>
                <td>
                  <?php if (!empty($org['vk_link'])): ?>
                    <a href="<?= htmlspecialchars($org['vk_link']) ?>" target="_blank">Ссылка</a>
                  <?php else: ?>
                    Не указана
                  <?php endif; ?>
                </td>
                <td>
                  <?= $org['user_id'] ?>, @<?= htmlspecialchars($curr_user->getUsername($org['user_id'])) ?>
                </td>
                <td>
                  <div class="btn-toolbar">
                    <a href="?approve=<?= $org['organization_id'] ?>">
                      <button class="btn green" type="button">
                        <i class="material-icons">done</i>
                      </button>
                    </a>
                    <a href="?reject=<?= $org['organization_id'] ?>">
                      <button class="btn red" type="button">
                        <i class="material-icons">remove</i>
                      </button>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>

            <?php if (empty($orgs)): ?>
              <tr>
                <td colspan="6">Нет студий, ожидающих подтверждения</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>
  <?php require_once('footer.php'); ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
  <script>
    // Инициализация компонентов
    $(document).ready(function() {
      $('.button-collapse').sideNav({
        menuWidth: 300,
        edge: 'left',
        closeOnClick: false,
        draggable: true
      });

      $('.tooltipped').tooltip({
        delay: 50
      });

      $('select').material_select();
      $('.collapsible').collapsible();

      // Подтверждение перед отклонением
      $('.btn.red').click(function(e) {
        if (!confirm('Вы уверены, что хотите отклонить эту студию?')) {
          e.preventDefault();
        }
      });
    });
  </script>
</body>

</html>