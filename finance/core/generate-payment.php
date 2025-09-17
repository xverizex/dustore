<?php
require_once('../../swad/controllers/payment.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['amount'])) {
    $amount = intval($_POST['amount']);
    if ($amount < 50) $amount = 50;
    
    renderPaymentButton(
        "dustore", 
        "U9D47ayD4y0luzFDgdrf", 
        rand(2 ** 1, 2 * 36),
        "Пополнение подписки для игроков Dust Vault", 
        [["Пополнение подписки для игроков Dust Vault", $amount]], 
        "", 
        0.00, 
        1, 
        "My_param=julia", 
        "Пополнить"
    );
} else {
    echo '<div style="color: red;">Ошибка: не указана сумма</div>';
}