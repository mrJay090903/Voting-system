<?php
session_start();
include '../../database/db.php';

// Check if user is logged in as admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['from_grade']) && isset($_POST['to_grade'])) {
    $from_grade = mysqli_real_escape_string($conn, $_POST['from_grade']);
    $to_grade = mysqli_real_escape_string($conn, $_POST['to_grade']);
    
    // First, get the count of students to be updated
    $count_sql = "SELECT COUNT(*) as count FROM students WHERE Grade = '$from_grade'";
    $count_result = $conn->query($count_sql);
    $count_row = $count_result->fetch_assoc();
    $students_count = $count_row['count'];
    
    if ($students_count == 0) {
        header("Location: ../students.php?error=No students found in $from_grade");
        exit();
    }
    
    // Proceed with update
    $sql = "UPDATE students SET Grade = '$to_grade' WHERE Grade = '$from_grade'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../students.php?success=Successfully updated " . $students_count . " students from " . $from_grade . " to " . $to_grade);
    } else {
        header("Location: ../students.php?error=Failed to update students from " . $from_grade . " to " . $to_grade);
    }
} else {
    header("Location: ../students.php?error=Invalid request");
}
exit();
?> 