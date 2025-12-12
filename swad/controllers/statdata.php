<?php
require_once('../config.php');
header('Content-Type: application/json');

$db = new Database();
$conn = $db->connect();

$stats = $conn->query("
    SELECT date,
           users_total, users_new,
           studios_total, studios_new,
           games_total, games_new,
           published_total, published_new
    FROM daily_stats
    ORDER BY date ASC
")->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($stats);
