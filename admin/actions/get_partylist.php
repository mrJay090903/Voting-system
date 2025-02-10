<?php
session_start();
include '../../database/db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM partylists WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $partylist = $result->fetch_assoc();
        header('Content-Type: application/json');
        echo json_encode($partylist);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Partylist not found']);
    }
}
?> 