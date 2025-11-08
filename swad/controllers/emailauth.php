<?php
// swad/controllers/emailauth.php
// Email authentication controller

require_once('user.php');
require_once('jwt.php');

/**
 * Регистрация нового пользователя через email
 */
function emailRegister($email, $password, $firstName, $lastName = null, $username = null)
{
    $user = new User();

    // Валидация email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [
            'success' => false,
            'message' => 'Неверный формат email'
        ];
    }

    // Проверка длины пароля
    if (strlen($password) < 6) {
        return [
            'success' => false,
            'message' => 'Пароль должен содержать минимум 6 символов'
        ];
    }

    // Проверка существования email
    if ($user->checkEmailExists($email)) {
        return [
            'success' => false,
            'message' => 'Пользователь с таким email уже существует'
        ];
    }

    // Генерация уникального username если не указан
    if (empty($username)) {
        $username = generateUniqueUsername($email, $user);
    } else {
        // Проверка существования username
        if ($user->checkUsernameExists($username)) {
            return [
                'success' => false,
                'message' => 'Это имя пользователя уже занято'
            ];
        }
    }

    // Хеширование пароля
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Генерация токена верификации
    $verificationToken = bin2hex(random_bytes(32));

    // Генерация уникального telegram_id для email пользователей
    $emailTelegramId = 'email_' . uniqid() . '_' . time();

    try {
        // Создание пользователя
        $stmt = $user->db->prepare("
            INSERT INTO users 
            (first_name, last_name, telegram_id, username, email, password, 
             email_verified, verification_token, auth_date, passphrase, 
             telegram_token, country, city, vk, website, last_activity)
            VALUES 
            (:first_name, :last_name, :telegram_id, :username, :email, :password,
             0, :verification_token, :auth_date, '', '', '', '', '', '', NOW())
        ");

        $result = $stmt->execute([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'telegram_id' => $emailTelegramId,
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'verification_token' => $verificationToken,
            'auth_date' => time()
        ]);

        if ($result) {
            // Отправка письма верификации (опционально)
            // sendVerificationEmail($email, $verificationToken);

            return [
                'success' => true,
                'message' => 'Регистрация успешна',
                'telegram_id' => $emailTelegramId,
                'verification_required' => true
            ];
        }

        return [
            'success' => false,
            'message' => 'Ошибка при создании аккаунта'
        ];
    } catch (PDOException $e) {
        error_log("Email registration error: " . $e->getMessage());
        return [
            'success' => false,
            'message' => 'Ошибка базы данных'
        ];
    }
}

/**
 * Вход через email
 */
function emailLogin($email, $password)
{
    $user = new User();

    // Валидация email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [
            'success' => false,
            'message' => 'Неверный формат email'
        ];
    }

    try {
        // Поиск пользователя по email
        $stmt = $user->db->prepare("
            SELECT * FROM users 
            WHERE email = :email 
            LIMIT 1
        ");
        $stmt->execute(['email' => $email]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            return [
                'success' => false,
                'message' => 'Неверный email или пароль'
            ];
        }

        // Проверка пароля
        if (!password_verify($password, $userData['password'])) {
            return [
                'success' => false,
                'message' => 'Неверный email или пароль'
            ];
        }

        // Опционально: проверка верификации email
        // if (!$userData['email_verified']) {
        //     return [
        //         'success' => false,
        //         'message' => 'Пожалуйста, подтвердите ваш email'
        //     ];
        // }

        // Создание сессии
        session_start();
        $_SESSION['logged-in'] = TRUE;
        $_SESSION['USERDATA'] = $userData;

        // Создание JWT токена
        $token = authUser($userData['telegram_id']);
        $_SESSION['auth_token'] = $token;

        // Обновление last_activity
        $updateStmt = $user->db->prepare("
            UPDATE users 
            SET last_activity = NOW() 
            WHERE id = :id
        ");
        $updateStmt->execute(['id' => $userData['id']]);

        return [
            'success' => true,
            'message' => 'Вход выполнен успешно'
        ];
    } catch (PDOException $e) {
        error_log("Email login error: " . $e->getMessage());
        return [
            'success' => false,
            'message' => 'Ошибка при входе'
        ];
    }
}

/**
 * Генерация уникального username на основе email
 */
function generateUniqueUsername($email, $user)
{
    $baseUsername = explode('@', $email)[0];
    $baseUsername = preg_replace('/[^a-zA-Z0-9_]/', '', $baseUsername);

    $username = $baseUsername;
    $counter = 1;

    while ($user->checkUsernameExists($username)) {
        $username = $baseUsername . $counter;
        $counter++;
    }

    return $username;
}

/**
 * Верификация email (опционально)
 */
function verifyEmail($token)
{
    $user = new User();

    try {
        $stmt = $user->db->prepare("
            UPDATE users 
            SET email_verified = 1, verification_token = NULL 
            WHERE verification_token = :token
        ");
        $result = $stmt->execute(['token' => $token]);

        return $result && $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Email verification error: " . $e->getMessage());
        return false;
    }
}

/**
 * Отправка письма для сброса пароля
 */
function requestPasswordReset($email)
{
    $user = new User();

    try {
        $stmt = $user->db->prepare("
            SELECT id FROM users WHERE email = :email LIMIT 1
        ");
        $stmt->execute(['email' => $email]);

        if (!$stmt->fetch()) {
            // Не сообщаем, существует ли email (безопасность)
            return [
                'success' => true,
                'message' => 'Если email существует, письмо будет отправлено'
            ];
        }

        $resetToken = bin2hex(random_bytes(32));

        $updateStmt = $user->db->prepare("
            UPDATE users 
            SET verification_token = :token 
            WHERE email = :email
        ");
        $updateStmt->execute([
            'token' => $resetToken,
            'email' => $email
        ]);

        // TODO: Отправка email с ссылкой для сброса
        // sendPasswordResetEmail($email, $resetToken);

        return [
            'success' => true,
            'message' => 'Письмо для сброса пароля отправлено'
        ];
    } catch (PDOException $e) {
        error_log("Password reset error: " . $e->getMessage());
        return [
            'success' => false,
            'message' => 'Ошибка при сбросе пароля'
        ];
    }
}

/**
 * Сброс пароля по токену
 */
function resetPassword($token, $newPassword)
{
    $user = new User();

    if (strlen($newPassword) < 6) {
        return [
            'success' => false,
            'message' => 'Пароль должен содержать минимум 6 символов'
        ];
    }

    try {
        $stmt = $user->db->prepare("
            SELECT id FROM users 
            WHERE verification_token = :token 
            LIMIT 1
        ");
        $stmt->execute(['token' => $token]);

        if (!$stmt->fetch()) {
            return [
                'success' => false,
                'message' => 'Неверный или истекший токен'
            ];
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updateStmt = $user->db->prepare("
            UPDATE users 
            SET password = :password, verification_token = NULL 
            WHERE verification_token = :token
        ");

        $result = $updateStmt->execute([
            'password' => $hashedPassword,
            'token' => $token
        ]);

        return [
            'success' => $result,
            'message' => $result ? 'Пароль успешно изменен' : 'Ошибка при изменении пароля'
        ];
    } catch (PDOException $e) {
        error_log("Password reset error: " . $e->getMessage());
        return [
            'success' => false,
            'message' => 'Ошибка при изменении пароля'
        ];
    }
}
