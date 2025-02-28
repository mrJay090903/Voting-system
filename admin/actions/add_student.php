<?php
session_start();
include '../../database/db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $grade = mysqli_real_escape_string($conn, $_POST['grade']);
    
    // Accept N/A for email and contact number
    $email = $_POST['email'] === 'N/A' ? 'N/A' : mysqli_real_escape_string($conn, $_POST['email']);
    $contact_number = $_POST['contact_number'] === 'N/A' ? 'N/A' : mysqli_real_escape_string($conn, $_POST['contact_number']);

    // Check if student already exists - modified to handle N/A emails
    $check_sql = "SELECT * FROM students WHERE StudentID = '$student_id'";
    if ($email !== 'N/A') {
        $check_sql .= " OR Email = '$email'";
    }
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        header("Location: ../students.php?error=Student ID or Email already exists");
        exit();
    }

    // Insert new student
    $sql = "INSERT INTO students (StudentID, FullName, Grade, Email, ContactNumber) 
            VALUES ('$student_id', '$full_name', '$grade', '$email', '$contact_number')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../students.php?success=Student added successfully");
    } else {
        header("Location: ../students.php?error=Failed to add student");
    }
}
?>