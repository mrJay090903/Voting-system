<?php
session_start();
include '../../database/db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    $required_fields = ['election_id', 'student_id', 'position', 'candidate_type', 'platform', 'vision', 'mission'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            header("Location: ../candidates.php?error=All fields are required");
            exit();
        }
    }

    $election_id = mysqli_real_escape_string($conn, $_POST['election_id']);
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $candidate_type = mysqli_real_escape_string($conn, $_POST['candidate_type']);
    $partylist_name = $candidate_type === 'partylist' ? mysqli_real_escape_string($conn, $_POST['partylist_name']) : NULL;
    $platform = mysqli_real_escape_string($conn, $_POST['platform']);
    $vision = mysqli_real_escape_string($conn, $_POST['vision']);
    $mission = mysqli_real_escape_string($conn, $_POST['mission']);

    // Verify election exists
    $check_election = $conn->query("SELECT id FROM elections WHERE id = '$election_id'");
    if ($check_election->num_rows === 0) {
        header("Location: ../candidates.php?error=Invalid election selected");
        exit();
    }

    // Verify student exists
    $check_student = $conn->query("SELECT StudentID FROM students WHERE StudentID = '$student_id'");
    if ($check_student->num_rows === 0) {
        header("Location: ../candidates.php?error=Invalid student selected");
        exit();
    }

    // Handle image upload
    $image_url = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = "../../uploads/candidates/";
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid() . "." . $file_extension;
        $target_file = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_url = "uploads/candidates/" . $file_name;
        }
    }

    // Insert candidate
    $sql = "INSERT INTO candidates (
        election_id, student_id, position, candidate_type, partylist_name,
        platform, vision, mission, image_url, status
    ) VALUES (
        '$election_id', '$student_id', '$position', '$candidate_type',
        " . ($partylist_name ? "'$partylist_name'" : "NULL") . ",
        '$platform', '$vision', '$mission',
        " . ($image_url ? "'$image_url'" : "NULL") . ",
        'active'
    )";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../candidates.php?success=Candidate added successfully");
    } else {
        header("Location: ../candidates.php?error=Failed to add candidate: " . $conn->error);
    }
}
?> 