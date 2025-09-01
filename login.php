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

    // Пытаемся войти по ключевой фразе
    $result = ppLogin($username, $passphrase);

    if ($result['success']) {
        // Успешный вход, перенаправляем
        die(header('Location: /me'));
    } else {
        $error_message = $result['message'];
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
            <button class="toggle-btn active" onclick="showForm('login')">Войти через Telegram</button>
            <button class="toggle-btn" onclick="showForm('register')">Войти по ключевой фразе</button>
        </div>

        <form id="loginForm" class="form-container active">
            Мы за современый и безопасный подход к созданию аккаунтов. Вы можете войти через Telegram и использовать этот аккаунт для всех сервисов в экосистеме DustEcoSystem (DES)
            <div class="form-group" style="text-align: center; margin-top: 35px;">
                <script async src="https://telegram.org/js/telegram-widget.js" data-telegram-login="<?= BOT_USERNAME ?>" data-size="large" data-auth-url="swad/controllers/auth.php"></script>
            </div>
        </form>

        <form id="registerForm" class="form-container" method="POST" action="">
            <?php if (isset($error_message)): ?>
                <div class="error-message"><?= $error_message ?></div>
            <?php endif; ?>

            <div class="form-group">
                <input type="text" name="username" placeholder="Имя пользователя" required>
            </div>
            <div class="form-group">
                <input type="password" name="passphrase" placeholder="Passphrase" required>
            </div>
            <button type="submit" name="pp_login">Войти</button>

            <div class="form-footer">
                <p>Нет аккаунта? <a href="/login">Войдите через Telegram</a></p>
                <p>Забыли passphrase? Увы, в таком случае аккаунт восстановлению не подлежит :(</p>
            </div>
        </form>
    </div>

    <script>
        function showForm(formType) {
            document.querySelectorAll('.toggle-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');

            document.getElementById('loginForm').classList.remove('active');
            document.getElementById('registerForm').classList.remove('active');
            document.getElementById(formType + 'Form').classList.add('active');
        }

        // Показать нужную форму при загрузке
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('method') === 'passphrase') {
                showForm('register');
            }
        });
    </script>
</body>

</html>