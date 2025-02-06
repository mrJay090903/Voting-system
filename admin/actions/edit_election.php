<?php
session_start();
include '../../database/db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['election_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Validate dates
    if (strtotime($end_date) <= strtotime($start_date)) {
        header("Location: ../elections.php?error=End date must be after start date");
        exit();
    }

    $sql = "UPDATE elections SET 
            title = '$title',
            description = '$description',
            start_date = '$start_date',
            end_date = '$end_date',
            status = '$status'
            WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../elections.php?success=Election updated successfully");
    } else {
        header("Location: ../elections.php?error=Failed to update election");
    }
}
?> 