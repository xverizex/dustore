<?php
require_once('../../config.php');
require_once('../user.php');

$data = json_decode(file_get_contents('php://input'), true);
$id = intval($data['id']);
$role = trim($data['role']);

if ($id && $role !== "") {
    $db = new Database();
    $pdo = $db->connect();
    $stmt = $pdo->prepare("UPDATE users SET l4t_role = ? WHERE id = ?");
    if ($stmt->execute([$role, $id])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
