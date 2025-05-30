<?php
header('Content-Type: application/json');
require_once('../swad/config.php');

$db = new Database();

// Получение отзывов для конкретной игры
$game_id = $_GET['game_id'] ?? null;

if (!$game_id) {
    echo json_encode(['error' => 'Game ID not provided']);
    exit;
}

try {
    // Подготовка запроса с использованием PDO
    $sql = "SELECT text FROM game_reviews WHERE game_id = :game_id";
    $stmt = $db->connect()->prepare($sql);

    // Привязка параметра и выполнение запроса
    $stmt->bindParam(':game_id', $game_id, PDO::PARAM_INT);
    $stmt->execute();

    // Получение результатов
    $reviews = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    // Если нет отзывов - возвращаем пустой результат
    if (empty($reviews)) {
        echo json_encode([
            'summary' => "Отзывов пока нет",
            'improvements' => [],
            'sentiment_stats' => ["POSITIVE" => 0, "NEGATIVE" => 0, "NEUTRAL" => 0]
        ]);
        exit;
    }

    // Создаем временный файл для передачи в Python
    $temp_file = tempnam(sys_get_temp_dir(), 'reviews_');
    file_put_contents($temp_file, json_encode($reviews, JSON_UNESCAPED_UNICODE));

    // Вызов Python-скрипта
    $python_script = __DIR__ . '/review_analyzer.py';
    $command = "python3 " . escapeshellarg($python_script) . " " . escapeshellarg($temp_file) . " 2>&1";
    $output = shell_exec($command);

    // Удаление временного файла
    unlink($temp_file);

    // Проверка и возврат результата
    if ($output === null) {
        echo json_encode(['error' => 'Python script execution failed']);
    } else {
        $decoded_output = json_decode($output, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            echo json_encode($decoded_output);
        } else {
            echo json_encode([
                'error' => 'Invalid JSON from Python script',
                'raw_output' => $output
            ]);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
