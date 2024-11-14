<?php
global $conn;
require 'db.php';
header('Content-Type: application/json');

$request_method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

switch ($request_method) {
    case 'GET':
        if ($id) {
            $stmt = $conn->prepare("SELECT * FROM items WHERE id = ?");
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $conn->query("SELECT * FROM items");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode($data);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("INSERT INTO items (name, description) VALUES (?, ?)");
        $stmt->execute([$input['name'], $input['description']]);
        echo json_encode(['message' => 'Record created', 'id' => $conn->lastInsertId()]);
        break;

    case 'PUT':
        if ($id) {
            $input = json_decode(file_get_contents('php://input'), true);
            $stmt = $conn->prepare("UPDATE items SET name = ?, description = ? WHERE id = ?");
            $stmt->execute([$input['name'], $input['description'], $id]);
            echo json_encode(['message' => 'Record updated']);
        } else {
            echo json_encode(['error' => 'ID not provided']);
        }
        break;

    case 'DELETE':
        if ($id) {
            $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['message' => 'Record deleted']);
        } else {
            echo json_encode(['error' => 'ID not provided']);
        }
        break;

    default:
        echo json_encode(['error' => 'Invalid request method']);
        break;
}
?>
