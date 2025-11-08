<?php
// Start the session
session_start();

if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == TRUE) {
    die(header('Location: me'));
}

if ($_SERVER['HTTP_HOST'] == 'dustore.ru') {
    define('BOT_USERNAME', 'dustore_auth_bot');
} else if ($_SERVER['HTTP_HOST'] == '127.0.0.1') {
    define('BOT_USERNAME', 'dustore_auth_local_bot');
}

// Обработка входа по ключевой фразе
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pp_login'])) {
    require_once('swad/controllers/user.php');
    require_once('swad/controllers/ppauth.php');

    $username = trim($_POST['username']);
    $passphrase = trim($_POST['passphrase']);

    $result = ppLogin($username, $passphrase);

    if ($result['success']) {
        die(header('Location: /me'));
    } else {
        $error_message = $result['message'];
        $active_form = 'passphrase';
    }
}

// Обработка входа через email
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email_login'])) {
    require_once('swad/controllers/user.php');
    require_once('swad/controllers/emailauth.php');

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $result = emailLogin($email, $password);

    if ($result['success']) {
        die(header('Location: /me'));
    } else {
        $error_message = $result['message'];
        $active_form = 'email';
        $email_mode = 'login';
    }
}

// Обработка регистрации через email
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email_register'])) {
    require_once('swad/controllers/user.php');
    require_once('swad/controllers/emailauth.php');

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;

    // Проверка совпадения паролей
    if ($password !== $confirm_password) {
        $error_message = "Пароли не совпадают";
        $active_form = 'email';
        $email_mode = 'register';
    } else {
        $result = emailRegister($email, $password, $first_name, $last_name, $username);

        if ($result['success']) {
            $success_message = "Регистрация успешна! Теперь вы можете войти.";
            $active_form = 'email';
            $email_mode = 'login';
        } else {
            $error_message = $result['message'];
            $active_form = 'email';
            $email_mode = 'register';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="swad/css/login.css">
    <?php require_once('swad/controllers/ymcounter.php'); ?>
</head>

<body>
    <div class="container">
        <div class="toggle-container">
            <button class="toggle-btn <?= !isset($active_form) || $active_form == 'telegram' ? 'active' : '' ?>" onclick="showForm('telegram')">Войти через Telegram</button>
            <!-- <button class="toggle-btn <?= isset($active_form) && $active_form == 'email' ? 'active' : '' ?>" onclick="showForm('email')">Войти через Email</button> -->
            <button class="toggle-btn <?= isset($active_form) && $active_form == 'passphrase' ? 'active' : '' ?>" onclick="showForm('passphrase')">Войти по ключевой фразе</button>
        </div>

        <!-- Telegram Login Form -->
        <form id="telegramForm" class="form-container <?= !isset($active_form) || $active_form == 'telegram' ? 'active' : '' ?>">
            Мы за современый и безопасный подход к созданию аккаунтов. Вы можете войти через Telegram и использовать этот аккаунт для всех сервисов в экосистеме DustEcoSystem (DES)
            <div class="form-group" style="text-align: center; margin-top: 35px;">
                <script async src="https://telegram.org/js/telegram-widget.js" data-telegram-login="<?= BOT_USERNAME ?>" data-size="large" data-auth-url="swad/controllers/auth.php"></script>
            </div>
        </form>

        <!-- Email Login/Register Form -->
        <form id="emailForm" class="form-container <?= isset($active_form) && $active_form == 'email' ? 'active' : '' ?>" method="POST" action="">
            <?php if (isset($error_message) && isset($active_form) && $active_form == 'email'): ?>
                <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
            <?php endif; ?>
            <?php if (isset($success_message)): ?>
                <div class="success-message"><?= htmlspecialchars($success_message) ?></div>
            <?php endif; ?>

            <!-- Переключатель Вход/Регистрация -->
            <div class="email-toggle" style="margin-bottom: 20px;">
                <button type="button" class="email-toggle-btn <?= !isset($email_mode) || $email_mode == 'login' ? 'active' : '' ?>" onclick="showEmailMode('login')">Вход</button>
                <button type="button" class="email-toggle-btn <?= isset($email_mode) && $email_mode == 'register' ? 'active' : '' ?>" onclick="showEmailMode('register')">Регистрация</button>
            </div>

            <!-- Форма входа -->
            <div id="emailLoginFields" class="email-mode-fields" style="<?= isset($email_mode) && $email_mode == 'register' ? 'display: none;' : '' ?>">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required value="<?= isset($_POST['email']) && isset($_POST['email_login']) ? htmlspecialchars($_POST['email']) : '' ?>">
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Пароль" required>
                </div>
                <button type="submit" name="email_login">Войти</button>
                <div class="form-footer">
                    <p><a href="/forgot-password">Забыли пароль?</a></p>
                </div>
            </div>

            <!-- Форма регистрации -->
            <div id="emailRegisterFields" class="email-mode-fields" style="<?= isset($email_mode) && $email_mode == 'register' ? '' : 'display: none;' ?>">
                <div class="form-group">
                    <input type="text" name="username" placeholder="Имя пользователя (опционально)" value="<?= isset($_POST['username']) && isset($_POST['email_register']) ? htmlspecialchars($_POST['username']) : '' ?>">
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required value="<?= isset($_POST['email']) && isset($_POST['email_register']) ? htmlspecialchars($_POST['email']) : '' ?>">
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Пароль (минимум 6 символов)" required>
                </div>
                <div class="form-group">
                    <input type="password" name="confirm_password" placeholder="Подтвердите пароль" required>
                </div>
                <button type="submit" name="email_register">Зарегистрироваться</button>
            </div>
        </form>

        <!-- Passphrase Form -->
        <form id="passphraseForm" class="form-container <?= isset($active_form) && $active_form == 'passphrase' ? 'active' : '' ?>" method="POST" action="">
            <?php if (isset($error_message) && isset($active_form) && $active_form == 'passphrase'): ?>
                <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
            <?php endif; ?>

            <div class="form-group">
                <input type="text" name="username" placeholder="Имя пользователя" required value="<?= isset($_POST['username']) && isset($_POST['pp_login']) ? htmlspecialchars($_POST['username']) : '' ?>">
            </div>
            <div class="form-group">
                <input type="password" name="passphrase" placeholder="Passphrase" required>
            </div>
            <button type="submit" name="pp_login">Войти</button>

            <div class="form-footer">
                <p>Нет аккаунта? <a href="javascript:void(0)" onclick="showForm('telegram')">Войдите через Telegram</a></p>
                <p>Забыли passphrase? Увы, в таком случае аккаунт восстановлению не подлежит :(</p>
            </div>
        </form>
    </div>

    <script>
        function showForm(formType) {
            // Убираем active со всех кнопок
            document.querySelectorAll('.toggle-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');

            // Скрываем все формы
            document.getElementById('telegramForm').classList.remove('active');
            document.getElementById('emailForm').classList.remove('active');
            document.getElementById('passphraseForm').classList.remove('active');

            // Показываем нужную форму
            document.getElementById(formType + 'Form').classList.add('active');
        }

        function showEmailMode(mode) {
            // Переключаем кнопки
            document.querySelectorAll('.email-toggle-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');

            // Переключаем поля форм
            if (mode === 'login') {
                document.getElementById('emailLoginFields').style.display = 'block';
                document.getElementById('emailRegisterFields').style.display = 'none';
            } else {
                document.getElementById('emailLoginFields').style.display = 'none';
                document.getElementById('emailRegisterFields').style.display = 'block';
            }
        }

        // Показать нужную форму при загрузке
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const method = urlParams.get('method');

            if (method === 'passphrase') {
                showForm('passphrase');
            } else if (method === 'email') {
                showForm('email');
            }
        });
    </script>
</body>

</html>