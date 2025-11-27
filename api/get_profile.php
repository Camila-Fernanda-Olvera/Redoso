<?php
session_start();
require_once __DIR__.'/../config/db.php';
require_once __DIR__.'/../classes/User.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$userData = $user->getUserById($_SESSION['user_id']);
if ($userData) {
    $stats = $user->getUserStats($_SESSION['user_id']);
    $response = array_merge($userData, $stats);
    echo json_encode($response);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'User not found']);
}
?>