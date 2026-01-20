<?php 
$data = [
    "user_id" => 1, 
    "title" => "Новость",
    "body" => "Вышло обновление",
    "url" => "/news/123"
];

$ch = curl_init("http://127.0.0.1:3001/send");
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_RETURNTRANSFER => true
]);

curl_exec($ch);
curl_close($ch);
