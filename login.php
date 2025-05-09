<?php
// Start the session
session_start();


// When the user is logged in, go to the user page
if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == TRUE) {
    die(header('Location: me'));
}


// Place username of your bot here
define('BOT_USERNAME', 'dustore_auth_bot');
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход/Регистрация</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 1rem;
        }

        .toggle-container {
            display: flex;
            margin-bottom: 2rem;
            border-bottom: 1px solid #ddd;
        }

        .toggle-btn {
            flex: 1;
            padding: 1rem;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 1.1rem;
            color: #666;
            transition: all 0.3s;
        }

        .toggle-btn.active {
            color: #1877f2;
            border-bottom: 2px solid #1877f2;
        }

        .form-container {
            display: none;
        }

        .form-container.active {
            display: block;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #1877f2;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s;
        }

        button[type="submit"]:hover {
            background: #166fe5;
        }

        @media (max-width: 480px) {
            .container {
                margin: 1rem;
                padding: 1.5rem;
            }

            .toggle-btn {
                font-size: 1rem;
                padding: 0.8rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="toggle-container">
            <button class="toggle-btn active" onclick="showForm('login')">Войти</button>
            <!-- <button class="toggle-btn" onclick="showForm('register')">Создать аккаунт</button> -->
        </div>

        <form id="loginForm" class="form-container active">
            Мы за современый и безопасный подход к созданию аккаунтов. Вы можете войти через Telegram и использовать этот аккаунт для всех сервисов в экосистеме DustEcoSystem (DES)
            <div class="form-group" style="text-align: center; margin-top: 35px;">
                <script async src="https://telegram.org/js/telegram-widget.js" data-telegram-login="<?= BOT_USERNAME ?>" data-size="large" data-auth-url="swad/controllers/auth.php"></script>
            </div>
        </form>

        <form id="registerForm" class="form-container">
            <div class="form-group">
                <input type="text" placeholder="Имя" required>
            </div>
            <div class="form-group">
                <input type="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Пароль" required>
            </div>
            <button type="submit">Зарегистрироваться</button>
        </form>
    </div>

    <script>
        function showForm(formType) {
            // Переключение кнопок
            document.querySelectorAll('.toggle-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');

            // Переключение форм
            document.getElementById('loginForm').classList.remove('active');
            document.getElementById('registerForm').classList.remove('active');
            document.getElementById(formType + 'Form').classList.add('active');
        }
    </script>
</body>

</html>