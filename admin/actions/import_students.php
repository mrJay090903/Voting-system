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
<<<<<<< HEAD
            // Set UTF-8 encoding for proper handling of special characters
            setlocale(LC_ALL, 'en_US.UTF-8');
            
            // Set the input encoding
            mb_internal_encoding('UTF-8');
            
=======
>>>>>>> cope/main
            // Skip header row
            fgetcsv($handle);
            
            while (($row = fgetcsv($handle)) !== FALSE) {
                // Validate row has all required fields
                if (count($row) < 5) {
                    $error_count++;
                    continue;
                }
                
<<<<<<< HEAD
                // Get and clean student ID first
                $student_id = trim($row[0]);
                
                // Skip empty student IDs
                if (empty($student_id)) {
                    $error_count++;
                    $errors[] = "Empty student ID found - row skipped";
                    continue;
                }
                
                // Check for duplicate student ID first
                $check_id_sql = "SELECT StudentID FROM students WHERE StudentID = '" . mysqli_real_escape_string($conn, $student_id) . "'";
                $check_id_result = $conn->query($check_id_sql);
                
                if ($check_id_result->num_rows > 0) {
                    $error_count++;
                    $errors[] = "Student ID '$student_id' already exists - skipping this record";
                    continue;
                }
                
                // If student ID is unique, proceed with rest of the data processing
                array_walk($row, function(&$value) {
                    $value = trim($value);
                    if (!mb_check_encoding($value, 'UTF-8')) {
                        $value = mb_convert_encoding($value, 'UTF-8', 'Windows-1252');
                    }
                    $search = array("\xC3\xB1", "\xC3\x91", "&ntilde;", "&Ntilde;");
                    $replace = array("ñ", "Ñ", "ñ", "Ñ");
                    $value = str_replace($search, $replace, $value);
                });
                
                $student_id = mysqli_real_escape_string($conn, $row[0]);
                $full_name = mysqli_real_escape_string($conn, $row[1]);
                
                // Format grade properly
                $grade = trim($row[2]);
                if (preg_match('/^Grade\s*(\d+)$/i', $grade, $matches)) {
                    // If format is like "Grade7" or "grade7", convert to "Grade 7"
                    $grade = 'Grade ' . $matches[1];
                } elseif (preg_match('/^g\s*(\d+)$/i', $grade, $matches)) {
                    // If format is like "g7" or "G7", convert to "Grade 7"
                    $grade = 'Grade ' . $matches[1];
                } elseif (preg_match('/^(\d+)$/i', $grade, $matches)) {
                    // If only number is provided (e.g., "7"), convert to "Grade 7"
                    $grade = 'Grade ' . $matches[1];
                } elseif (preg_match('/^gr\s*(\d+)$/i', $grade, $matches)) {
                    // If format is like "gr7" or "GR7", convert to "Grade 7"
                    $grade = 'Grade ' . $matches[1];
                }
                $grade = mysqli_real_escape_string($conn, $grade);
                
                // Handle N/A values for email and contact
                $email = trim($row[3]);
                if (strtolower($email) === 'n/a' || empty($email)) {
                    // Generate email from student ID and name
                    $name_parts = explode(' ', strtolower($full_name));
                    $first_name = $name_parts[0];
                    $last_name = end($name_parts);
                    
                    // Remove special characters and spaces from names
                    $first_name = preg_replace('/[^a-z0-9]/', '', $first_name);
                    $last_name = preg_replace('/[^a-z0-9]/', '', $last_name);
                    
                    // Create email: firstnamelastname.studentID@sslg.edu.ph
                    $email = $first_name . $last_name . '.' . strtolower($student_id) . '@sslg.edu.ph';
                } else {
                    $email = mysqli_real_escape_string($conn, $email);
                }
                
                $contact_number = (trim($row[4]) === 'N/A') ? 'N/A' : mysqli_real_escape_string($conn, trim($row[4]));
                
                // Validate grade format and number range
                if (!preg_match('/^Grade\s*(7|8|9|10|11|12)$/', $grade)) {
                    $error_count++;
                    $errors[] = "Invalid grade format for student ID $student_id. Grade should be between 7-12.";
                    continue;
                }
                
                // Check if student already exists - modified to handle N/A emails
                $check_sql = "SELECT StudentID FROM students WHERE StudentID = '$student_id'";
                if ($email !== 'N/A') {
                    $check_sql .= " OR Email = '$email'";
                }
=======
                $student_id = mysqli_real_escape_string($conn, trim($row[0]));
                $full_name = mysqli_real_escape_string($conn, trim($row[1]));
                $grade = mysqli_real_escape_string($conn, trim($row[2]));
                $email = mysqli_real_escape_string($conn, trim($row[3]));
                $contact_number = mysqli_real_escape_string($conn, trim($row[4]));
                
                // Skip empty rows
                if (empty($student_id)) continue;
                
                // Check if student already exists
                $check_sql = "SELECT StudentID FROM students WHERE StudentID = '$student_id' OR Email = '$email'";
>>>>>>> cope/main
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