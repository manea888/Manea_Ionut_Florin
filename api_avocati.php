<?php
require 'db.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

// 1. GET: Trimitem lista de avocati
if ($method === 'GET') {
    try {
        $stmt = $pdo->query("SELECT * FROM avocati ORDER BY id DESC");
        echo json_encode($stmt->fetchAll());
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

// 2. POST: Adaugam un avocat nou
elseif ($method === 'POST') {
    try {
        $inputJSON = file_get_contents('php://input');
        $data = json_decode($inputJSON, true);

        $sql = "INSERT INTO avocati (nume_complet, email, telefon, specializare) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $data['nume'], 
            $data['email'], 
            $data['telefon'], 
            $data['specializare']
        ]);

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>