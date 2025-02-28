<?php
session_start();
include '../../database/db.php';

// Check if user is logged in as admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['grade'])) {
    $grade = mysqli_real_escape_string($conn, $_POST['grade']);
    
    // First, get the count of students to be deleted
    $count_sql = "SELECT COUNT(*) as count FROM students WHERE Grade = '$grade'";
    $count_result = $conn->query($count_sql);
    $count_row = $count_result->fetch_assoc();
    $students_count = $count_row['count'];
    
    // Proceed with deletion
    $sql = "DELETE FROM students WHERE Grade = '$grade'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../students.php?success=Successfully deleted " . $students_count . " students from " . $grade);
    } else {
        header("Location: ../students.php?error=Failed to delete students from " . $grade);
    }
} else {
    header("Location: ../students.php?error=Invalid request");
}
exit();
?> 