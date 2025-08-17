<?php
function send_message($uid, $message){
    $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendMessage";

    $data = [
        'chat_id' => $uid,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);
    if ($responseData && $responseData['ok']) {
        $result = "Сообщение успешно отправлено!";
    } else {
        $result = "Ошибка отправки: " . ($responseData['description'] ?? 'неизвестная ошибка');
    }

    return $result;
}
?>