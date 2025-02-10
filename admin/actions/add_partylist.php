<?php
session_start();
include '../../database/db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Check if partylist name already exists
    $check_sql = "SELECT * FROM partylists WHERE name = '$name'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        header("Location: ../candidates.php?error=Partylist name already exists");
        exit();
    }

    // Handle logo upload
    $logo_url = null;
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
        $upload_dir = "../../uploads/partylists/";
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid() . "." . $file_extension;
        $target_file = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_file)) {
            $logo_url = "uploads/partylists/" . $file_name;
        }
    }

    // Insert partylist
    $sql = "INSERT INTO partylists (name, description, logo_url) 
            VALUES ('$name', '$description', " . ($logo_url ? "'$logo_url'" : "NULL") . ")";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../candidates.php?success=Partylist added successfully");
    } else {
        header("Location: ../candidates.php?error=Failed to add partylist");
    }
}
?>