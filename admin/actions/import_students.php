<?php
session_start();
include '../../database/db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['file'])) {
    try {
        $file = $_FILES['file']['tmp_name'];
        
        // Begin transaction
        $conn->begin_transaction();
        
        $success_count = 0;
        $error_count = 0;
        $errors = [];
        
        if (($handle = fopen($file, "r")) !== FALSE) {
            // Skip header row
            fgetcsv($handle);
            
            while (($row = fgetcsv($handle)) !== FALSE) {
                // Validate row has all required fields
                if (count($row) < 5) {
                    $error_count++;
                    continue;
                }
                
                $student_id = mysqli_real_escape_string($conn, trim($row[0]));
                $full_name = mysqli_real_escape_string($conn, trim($row[1]));
                $grade = mysqli_real_escape_string($conn, trim($row[2]));
                $email = mysqli_real_escape_string($conn, trim($row[3]));
                $contact_number = mysqli_real_escape_string($conn, trim($row[4]));
                
                // Skip empty rows
                if (empty($student_id)) continue;
                
                // Check if student already exists
                $check_sql = "SELECT StudentID FROM students WHERE StudentID = '$student_id' OR Email = '$email'";
                $check_result = $conn->query($check_sql);
                
                if ($check_result->num_rows > 0) {
                    $error_count++;
                    $errors[] = "Student with ID $student_id or email $email already exists";
                    continue;
                }
                
                // Insert student
                $sql = "INSERT INTO students (StudentID, FullName, Grade, Email, ContactNumber) 
                        VALUES ('$student_id', '$full_name', '$grade', '$email', '$contact_number')";
                
                if ($conn->query($sql)) {
                    $success_count++;
                } else {
                    $error_count++;
                    $errors[] = "Failed to add student with ID $student_id: " . $conn->error;
                }
            }
            fclose($handle);
        }
        
        if ($error_count === 0) {
            $conn->commit();
            $_SESSION['message'] = "$success_count students imported successfully";
            $_SESSION['message_type'] = 'success';
        } else {
            if ($success_count > 0) {
                $conn->commit();
                $_SESSION['message'] = "$success_count students imported successfully, $error_count failed";
                $_SESSION['message_type'] = 'warning';
                $_SESSION['errors'] = $errors;
            } else {
                $conn->rollback();
                $_SESSION['message'] = "Import failed: $error_count errors";
                $_SESSION['message_type'] = 'error';
                $_SESSION['errors'] = $errors;
            }
        }
        
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['message'] = "Import failed: " . $e->getMessage();
        $_SESSION['message_type'] = 'error';
    }
    
    header("Location: ../students.php");
    exit();
}

$_SESSION['message'] = "No file uploaded";
$_SESSION['message_type'] = 'error';
header("Location: ../students.php");
exit();
?>