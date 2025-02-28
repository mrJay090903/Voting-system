<?php
session_start();
include '../../database/db.php';

// Check if user is logged in as admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Get all students for printing with proper grade sorting
$sql = "SELECT StudentID, FullName, Grade, Email, ContactNumber 
        FROM students 
        WHERE FullName LIKE '%$search_query%' 
        ORDER BY 
            CASE 
                WHEN Grade = 'Grade 7' THEN 1
                WHEN Grade = 'Grade 8' THEN 2
                WHEN Grade = 'Grade 9' THEN 3
                WHEN Grade = 'Grade 10' THEN 4
                WHEN Grade = 'Grade 11' THEN 5
                WHEN Grade = 'Grade 12' THEN 6
                ELSE 7
            END,
            FullName";

$result = $conn->query($sql);
$students = [];

while ($row = $result->fetch_assoc()) {
    // Sanitize data for JSON
    array_walk($row, function(&$value) {
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    });
    $students[] = $row;
}

header('Content-Type: application/json');
echo json_encode($students);
?> 