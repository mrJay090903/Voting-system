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
    
    $sql = "SELECT c.*, s.FullName as student_name 
            FROM candidates c 
            JOIN students s ON c.student_id = s.StudentID 
            WHERE c.id = '$id'";
            
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $candidate = $result->fetch_assoc();
        header('Content-Type: application/json');
        echo json_encode($candidate);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Candidate not found']);
    }
}
?> 