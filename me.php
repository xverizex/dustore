<?php
// Start the session
session_start();

if (empty($_SESSION['logged-in'])) {
    die(header('Location: login'));
}


// Import database connection and class
require('swad/config.php');

$db = new Database();


// Get current logged in user data with session
$user_data = $db->Select(
    "SELECT *
        FROM `users`
            WHERE `telegram_id` = :id",
    [
        'id' => $_SESSION['telegram_id']
    ]
);


// Define clean variables with user data
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
# echo '<style>body { background-color: #000 !important; } .middle-center { display: none !important; }</style>';
# echo '<pre>', print_r($user_data, TRUE), '</pre>';
# echo '<pre>', print_r($_SESSION, TRUE), '</pre>';
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>Logged In User</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nanum+Gothic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="middle-center">
        <?= $HTML ?>
        <input type="button" value="Выйти" onclick="
        document.cookie = 'PHPSESSID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        window.location.href = '/login';
        " style="
        padding: 10px 20px;
        background: #ff4444;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        ">
    </div>
</body>

</html>