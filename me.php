<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <!-- Боковое меню -->
        <div class="sidebar">
            <button class="tab-button active" onclick="showTab('main')">Главная</button>
            <button class="tab-button" onclick="showTab('security')">Безопасность</button>
            <button class="tab-button" onclick="showTab('settings')">Настройки</button>
        </div>

        <!-- Основной контент -->
        <div class="content" id="mainTab">
            <div class="form-group">
                <label>Имя пользователя:</label>
                <input type="text" id="username" value="Иван Иванов" disabled>
                <button class="edit-btn" onclick="toggleEdit('username')">Редактировать</button>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" id="email" value="user@example.com" disabled>
                <button class="edit-btn" onclick="toggleEdit('email')">Редактировать</button>
            </div>
        </div>
    </div>

    <script>
        // Переключение вкладок
        function showTab(tabName) {
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        // Редактирование полей
        let currentEditField = null;

        function toggleEdit(fieldId) {
            const field = document.getElementById(fieldId);
            const btn = event.target;

            if (field.disabled) {
                field.disabled = false;
                btn.textContent = 'Сохранить';
                currentEditField = fieldId;
            } else {
                field.disabled = true;
                btn.textContent = 'Редактировать';
                saveChanges(fieldId, field.value);
            }
        }

        // Отправка изменений на сервер
        async function saveChanges(field, value) {
            try {
                const response = await fetch('/update_profile.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        field: field,
                        value: value
                    })
                });

                const result = await response.json();
                if (!result.success) {
                    alert('Ошибка сохранения: ' + result.error);
                }
            } catch (error) {
                console.error('Ошибка:', error);
                alert('Ошибка соединения с сервером');
            }
        }
    </script>



















    <?php
    require_once('swad/static/elements/header.php');

    if (empty($_SESSION['logged-in'])) {
        die(header('Location: login'));
    }

    $user_data = $db->Select(
        "SELECT *
            FROM `users`
                WHERE `telegram_id` = :id",
        [
            'id' => $_SESSION['telegram_id']
        ]
    );

    $firstName        = $user_data[0]['first_name'];
    $lastName         = $user_data[0]['last_name'];
    $profilePicture   = $user_data[0]['profile_picture'];
    $telegramID       = $user_data[0]['telegram_id'];
    $telegramUsername = $user_data[0]['telegram_username'];
    $userID           = $user_data[0]['id'];


    if (!is_null($lastName)) {
        // Display first name and last name
        $HTML = "<h1>Hello, {$firstName} {$lastName}!</h1>";
    } else {
        // Display first name
        $HTML = "<h1>Hello, {$firstName}!</h1>";
    }

    if (!is_null($profilePicture)) {
        // Display profile picture with no cache trick "image.jpg?v=time()"
        $HTML .= '
        <a href="' . $profilePicture . '" target="_blank">
            <img class="profile-picture" src="' . $profilePicture . '?v=' . time() . '">
        </a>
        ';
    }

    if (!is_null($lastName)) {
        // Display first name and last name
        $HTML .= '
        <h2 class="user-data">First Name: ' . $firstName . '</h2>
        <h2 class="user-data">Last Name: ' . $lastName . '</h2>
        ';
    } else {
        // Display first name
        $HTML .= '<h2 class="user-data">First Name: ' . $firstName . '</h2>';
    }

    if (!is_null($telegramUsername)) {
        // Display Telegram username
        $HTML .= '
        <h2 class="user-data">
            Username:
            <a href="https://t.me/' . $telegramUsername . '" target="_blank">
                @' . $telegramUsername . '
            </a>
        </h2>
        ';
    }

    // Display Telegram ID | User ID | Logout Button
    $HTML .= '
    <h2 class="user-data">Telegram ID: ' . $telegramID . '</h2>
    <h2 class="user-data">User ID: ' . $userID . '</h2>
    ';


    // Display all selected user data
    echo '<style>body { background-color: #fff !important; } .middle-center { display: none !important; }</style>';
    echo '<pre>', print_r($user_data, TRUE), '</pre>';
    echo '<pre>', print_r($_SESSION, TRUE), '</pre>';
    ?>
</body>

</html>