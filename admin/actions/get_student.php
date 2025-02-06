<?php
session_start();
include '../../database/db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

if (isset($_GET['student_id'])) {
    $student_id = mysqli_real_escape_string($conn, $_GET['student_id']);
    $sql = "SELECT * FROM students WHERE StudentID = '$student_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $student = $result->fetch_assoc();
        header('Content-Type: application/json');
        echo json_encode($student);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Student not found']);
    }
}
?>