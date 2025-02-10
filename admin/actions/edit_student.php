<?php
session_start();
include '../../database/db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $original_student_id = mysqli_real_escape_string($conn, $_POST['original_student_id']);
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $grade = mysqli_real_escape_string($conn, $_POST['grade']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);

    // Check if new student ID or email already exists (excluding the current student)
    if ($original_student_id !== $student_id) {
        $check_sql = "SELECT * FROM students WHERE (StudentID = '$student_id' OR Email = '$email') AND StudentID != '$original_student_id'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            header("Location: ../students.php?error=Student ID or Email already exists");
            exit();
        }
    }

    // Update student
    $sql = "UPDATE students SET 
            StudentID = '$student_id',
            FullName = '$full_name',
            Grade = '$grade',
            Email = '$email',
            ContactNumber = '$contact_number'
            WHERE StudentID = '$original_student_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../students.php?success=Student updated successfully");
    } else {
        header("Location: ../students.php?error=Failed to update student");
    }
}
?>