<?php
include '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $grade = mysqli_real_escape_string($conn, $_POST['grade']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);

    // Check if student already exists
    $check_sql = "SELECT * FROM students WHERE StudentID = '$student_id' OR Email = '$email'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        header("Location: ../index.php?error=Registration failed! Student ID or Email already exists");
        exit();
    }

    // Insert new student
    $sql = "INSERT INTO students (StudentID, FullName, Grade, Email, ContactNumber) 
            VALUES ('$student_id', '$full_name', '$grade', '$email', '$contact_number')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../index.php?success=Registration successful! You can now login with your credentials");
    } else {
        header("Location: ../index.php?error=Registration failed! Please try again later");
    }
}
?> 