<?php
session_start();
include '../../database/db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['partylist_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Check if new name already exists (excluding current partylist)
    $check_sql = "SELECT * FROM partylists WHERE name = '$name' AND id != '$id'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        header("Location: ../candidates.php?error=Partylist name already exists");
        exit();
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Handle logo upload if new logo is provided
        $logo_sql = "";
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
            $upload_dir = "../../uploads/partylists/";
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
            $file_name = uniqid() . "." . $file_extension;
            $target_file = $upload_dir . $file_name;
            
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_file)) {
                // Delete old logo if exists
                $old_logo = $conn->query("SELECT logo_url FROM partylists WHERE id = '$id'")->fetch_assoc();
                if ($old_logo['logo_url']) {
                    $old_logo_path = "../../" . $old_logo['logo_url'];
                    if (file_exists($old_logo_path)) {
                        unlink($old_logo_path);
                    }
                }
                
                $logo_url = "uploads/partylists/" . $file_name;
                $logo_sql = ", logo_url = '$logo_url'";
            }
        }

        // Get old partylist name for updating candidates
        $old_name = $conn->query("SELECT name FROM partylists WHERE id = '$id'")->fetch_assoc()['name'];

        // Update partylist
        $update_partylist = "UPDATE partylists SET 
            name = '$name',
            description = '$description',
            status = '$status'
            $logo_sql
            WHERE id = '$id'";

        if ($conn->query($update_partylist)) {
            // Update related candidates with new partylist name
            $update_candidates = "UPDATE candidates SET 
                partylist_name = '$name'
                WHERE partylist_name = '$old_name'";
            $conn->query($update_candidates);
            
            // Commit transaction
            $conn->commit();
            header("Location: ../candidates.php?success=Partylist updated successfully");
        } else {
            throw new Exception("Failed to update partylist");
        }
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        header("Location: ../candidates.php?error=Failed to update partylist: " . $e->getMessage());
    }
}
?> 