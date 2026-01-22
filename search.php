<?php session_start(); ?>
<?php
require_once('swad/config.php');

$db = new Database();
$pdo = $db->connect();

// Получаем студии
$stmt = $pdo->prepare("SELECT id, name, description, avatar_link, website, created_at, tiker FROM studios ORDER BY id DESC");
$stmt->execute();
$studios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Получаем пользователей (ограничим 100)
$stmt = $pdo->prepare("SELECT id, first_name, last_name, telegram_username, username, profile_picture, added, country, city, website, email FROM users ORDER BY id DESC LIMIT 100");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dustore — Каталог</title>
    <link rel="stylesheet" href="swad/css/explore.css">
    <link rel="shortcut icon" href="swad/static/img/logo.svg" type="image/x-icon">
    <style>
        /* Общие стили сетки */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            padding-top: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 18px;
            cursor: pointer;
            transition: transform .25s ease, box-shadow .3s ease;
            border: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
        }

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 12px;
            background: #1d1d1d;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: inherit;
        }

        .card-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .card-desc {
            opacity: .7;
            font-size: 14px;
            margin-bottom: 10px;
            height: 40px;
            overflow: hidden;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            opacity: .8;
            font-size: 14px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card-date {
            font-size: 13px;
            opacity: 0.6;
        }

        /* Поиск и фильтры */
        .filters {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }

        .filters button {
            padding: 10px 20px;
            border-radius: 10px;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            cursor: pointer;
            transition: background 0.2s;
        }

        .filters button.active {
            background: #4cafef;
        }

        .search-bar {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 100%;
            max-width: 420px;
            padding: 12px 15px;
            border-radius: 10px;
            border: none;
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            outline: none;
            font-size: 15px;
        }

        .search-bar input::placeholder {
            color: #bbb;
        }
    </style>
</head>

<body>
    <?php require_once('swad/static/elements/header.php'); ?>

    <main>
        <section class="games-header">
            <div class="container">
                <h1>Каталог студий и пользователей</h1>
                <p>Ищите разработчиков и участников сообщества</p>
            </div>
        </section>

        <div class="container">
            <div class="filters">
                <button data-type="all" class="active">Все</button>
                <button data-type="studios">Студии</button>
                <button data-type="users">Пользователи</button>
            </div>

            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Начните вводить для поиска...">
            </div>

            <div class="grid-container" id="cardsGrid">
                <!-- Студии -->
                <?php foreach ($studios as $s): ?>
                    <div class="card studio-card" data-type="studios" onclick="window.location.href='/d/<?= $s['tiker'] ?>'">
                        <div class="avatar">
                            <img src="<?= !empty($s['avatar_link']) ? htmlspecialchars($s['avatar_link']) : '/swad/static/img/logo.svg' ?>" alt="<?= htmlspecialchars($s['name']) ?>">
                        </div>
                        <div class="card-title"><?= htmlspecialchars($s['name']) ?></div>
                        <div class="card-desc"><?= htmlspecialchars(mb_strimwidth($s['description'] ?: 'Описание отсутствует', 0, 120, '...')) ?></div>
                        <div class="card-footer">
                            <span><?= $s['website'] ? htmlspecialchars($s['website']) : '' ?></span>
                            <span class="card-date">Основана: <?= date('d.m.Y', strtotime($s['created_at'])) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- Пользователи -->
                <?php foreach ($users as $user): ?>
                    <?php
                    $fullName = trim($user['first_name'] . ' ' . $user['last_name']);
                    $displayName = !empty($fullName) ? $fullName : ($user['username'] ?? $user['telegram_username'] ?? 'Пользователь');
                    $username = $user['username'] ?? '';
                    $location = '';
                    if (!empty($user['city']) && !empty($user['country'])) $location = $user['city'] . ', ' . $user['country'];
                    elseif (!empty($user['city'])) $location = $user['city'];
                    elseif (!empty($user['country'])) $location = $user['country'];
                    $avatar = !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : '/swad/static/img/logo.svg';
                    ?>
                    <div class="card user-card" data-type="users" onclick="window.location.href='/player/<?= $user['username'] ?>'">
                        <div class="avatar">
                            <img src="<?= $avatar ?>" alt="<?= htmlspecialchars($displayName) ?>">
                        </div>
                        <div class="card-title"><?= htmlspecialchars($displayName) ?></div>
                        <?php if (!empty($username)): ?>
                            <div class="card-desc">@<?= htmlspecialchars($username) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($location)): ?>
                            <div class="card-desc">📍 <?= htmlspecialchars($location) ?></div>
                        <?php endif; ?>
                        <div class="card-footer">
                            <span><?= !empty($user['website']) ? htmlspecialchars(parse_url($user['website'], PHP_URL_HOST) ?? $user['website']) : '' ?></span>
                            <span class="card-date">С <?= date('d.m.Y', strtotime($user['added'])) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <?php require_once('swad/static/elements/footer.php'); ?>

    <script>
        const buttons = document.querySelectorAll('.filters button');
        const cards = document.querySelectorAll('.grid-container .card');
        const searchInput = document.getElementById('searchInput');

        // Фильтр по типу
        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                buttons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const type = btn.getAttribute('data-type');

                cards.forEach(card => {
                    if (type === 'all' || card.getAttribute('data-type') === type) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
                filterSearch(); // применяем поиск после фильтра
            });
        });

        // Поиск по всем карточкам
        searchInput.addEventListener('input', filterSearch);

        function filterSearch() {
            const term = searchInput.value.toLowerCase();
            const activeType = document.querySelector('.filters button.active').getAttribute('data-type');

            cards.forEach(card => {
                const title = card.querySelector('.card-title').textContent.toLowerCase();
                const desc = card.querySelector('.card-desc')?.textContent.toLowerCase() || '';
                const matchType = activeType === 'all' || card.getAttribute('data-type') === activeType;
                const matchSearch = title.includes(term) || desc.includes(term);

                card.style.display = (matchType && matchSearch) ? 'block' : 'none';
            });
        }

        // Анимация появления
        document.addEventListener('DOMContentLoaded', () => {
            cards.forEach((el, index) => {
                el.style.opacity = "0";
                el.style.transform = "translateY(20px)";
                setTimeout(() => {
                    el.style.transition = "0.4s ease";
                    el.style.opacity = "1";
                    el.style.transform = "translateY(0)";
                }, index * 50);
            });
        });
    </script>
</body>

</html>