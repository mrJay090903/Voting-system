<?php
session_start();
include '../../database/db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $candidate_id = mysqli_real_escape_string($conn, $_POST['candidate_id']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $candidate_type = mysqli_real_escape_string($conn, $_POST['candidate_type']);
    $partylist_name = $candidate_type === 'partylist' ? mysqli_real_escape_string($conn, $_POST['partylist_name']) : NULL;
    $platform = mysqli_real_escape_string($conn, $_POST['platform']);
    $vision = mysqli_real_escape_string($conn, $_POST['vision']);
    $mission = mysqli_real_escape_string($conn, $_POST['mission']);

    // Handle image upload if a new image is provided
    $image_sql = "";
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
            $image_sql = ", image_url = '$image_url'";
        }
    }

    // Update candidate
    $sql = "UPDATE candidates SET 
            position = '$position',
            candidate_type = '$candidate_type',
            partylist_name = " . ($partylist_name ? "'$partylist_name'" : "NULL") . ",
            platform = '$platform',
            vision = '$vision',
            mission = '$mission'
            $image_sql
            WHERE id = '$candidate_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../candidates.php?success=Candidate updated successfully");
    } else {
        header("Location: ../candidates.php?error=Failed to update candidate: " . $conn->error);
    }
}
?> 