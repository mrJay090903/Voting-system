<?php
session_start();
include '../../database/db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);

    // Validate dates
    if (strtotime($end_date) <= strtotime($start_date)) {
        header("Location: ../elections.php?error=End date must be after start date");
        exit();
    }

    $sql = "INSERT INTO elections (title, description, start_date, end_date, status) 
            VALUES ('$title', '$description', '$start_date', '$end_date', 'pending')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../elections.php?success=Election created successfully");
    } else {
        header("Location: ../elections.php?error=Failed to create election");
    }
}
?> 