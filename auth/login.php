<?php
session_start();
include '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_type = $_POST['user_type'];

    if ($user_type === 'student') {
        // Student Login
        $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $sql = "SELECT * FROM students WHERE StudentID = '$student_id' AND FullName = '$full_name'";

        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION['user_type'] = 'student';
            $_SESSION['student_id'] = $row['StudentID'];
            $_SESSION['full_name'] = $row['FullName'];
            header("Location: ../dashboard.php?success=Login successful! Welcome back " . $row['FullName']);
            exit();
        } else {
            header("Location: ../index.php?error=Login failed! Invalid student ID or full name combination");
            exit();
        }
    } else {
        // Admin Login
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $sql = "SELECT * FROM admin WHERE username = '$username' LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if ($password === 'admin123') {
                $_SESSION['user_type'] = 'admin';
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_username'] = $row['username'];
                header("Location: ../admin/dashboard.php?success=Login successful! Welcome back Administrator");
                exit();
            } else {
                header("Location: ../index.php?error=Login failed! Invalid password for admin account");
                exit();
            }
        } else {
            header("Location: ../index.php?error=Login failed! Admin account not found");
            exit();
        }
    }
}
?>