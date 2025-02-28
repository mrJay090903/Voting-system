<?php
session_start();
include '../database/db.php';
$conn = connect(); // Using PDO connection
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_type = $_POST['user_type'];

    if ($user_type === 'student') {
        // Student Login - removed full name requirement
        $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
        $sql = "SELECT * FROM students WHERE StudentID = '$student_id'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Check if student has already voted
            $check_votes_sql = "SELECT COUNT(*) as vote_count FROM votes WHERE student_id = '$student_id'";
            $votes_result = $conn->query($check_votes_sql);
            $votes_data = $votes_result->fetch_assoc();
            
            if ($votes_data['vote_count'] > 0) {
                // Student has already voted
                header("Location: ../index.php?error=You have already cast your votes. Thank you for participating!");
                exit();
            }
            
            // Student exists and hasn't voted yet - proceed with login
            $student = $result->fetch_assoc();
            $_SESSION['user_type'] = 'student';
            $_SESSION['student_id'] = $student['StudentID'];
            $_SESSION['full_name'] = $student['FullName']; // Keep this for display purposes
            header("Location: ../dashboard.php?success=Login successful! Welcome back " . $student['FullName']);
            exit();
        } else {
            header("Location: ../index.php?error=Login failed! Invalid student ID");
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