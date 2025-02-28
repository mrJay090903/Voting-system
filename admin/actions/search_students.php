<?php
session_start();
include '../../database/db.php';

// Check if user is logged in as admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$results_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $results_per_page;

$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$sql = "SELECT * FROM students WHERE FullName LIKE '%$search_query%' ORDER BY Grade, FullName LIMIT $start_from, $results_per_page";
$students = $conn->query($sql);

// Count total records for pagination
$total_students_result = $conn->query("SELECT COUNT(*) AS total FROM students WHERE FullName LIKE '%$search_query%'");
$total_students_row = $total_students_result->fetch_assoc();
$total_students = $total_students_row['total'];

$total_pages = ceil($total_students / $results_per_page);

$results = [];
while($student = $students->fetch_assoc()) {
    $results[] = $student;
}

header('Content-Type: application/json');
echo json_encode([
    'students' => $results,
    'pagination' => [
        'current_page' => $page,
        'total_pages' => $total_pages,
        'total_records' => $total_students
    ]
]);
?> 