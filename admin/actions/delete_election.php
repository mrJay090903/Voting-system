<?php
session_start();
include '../../database/db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // First delete related records
    $conn->query("DELETE FROM votes WHERE election_id = '$id'");
    $conn->query("DELETE FROM candidates WHERE election_id = '$id'");
    
    // Then delete the election
    $sql = "DELETE FROM elections WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../elections.php?success=Election deleted successfully");
    } else {
        header("Location: ../elections.php?error=Failed to delete election");
    }
}
?> 