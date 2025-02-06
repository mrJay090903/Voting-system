<?php
session_start();
include '../../database/db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Get partylist info for logo deletion
    $partylist = $conn->query("SELECT logo_url FROM partylists WHERE id = '$id'")->fetch_assoc();
    
    // Begin transaction
    $conn->begin_transaction();
    
    try {
        // Update related candidates to independent
        $update_candidates = "UPDATE candidates SET 
            candidate_type = 'independent',
            partylist_name = NULL 
            WHERE partylist_name = (SELECT name FROM partylists WHERE id = '$id')";
        $conn->query($update_candidates);
        
        // Delete the partylist
        $delete_partylist = "DELETE FROM partylists WHERE id = '$id'";
        if ($conn->query($delete_partylist)) {
            // Delete partylist logo if exists
            if ($partylist['logo_url']) {
                $logo_path = "../../" . $partylist['logo_url'];
                if (file_exists($logo_path)) {
                    unlink($logo_path);
                }
            }
            
            // Commit transaction
            $conn->commit();
            header("Location: ../candidates.php?success=Partylist deleted successfully");
        } else {
            throw new Exception("Failed to delete partylist");
        }
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        header("Location: ../candidates.php?error=Failed to delete partylist: " . $e->getMessage());
    }
} else {
    header("Location: ../candidates.php?error=Invalid partylist ID");
}
?> 