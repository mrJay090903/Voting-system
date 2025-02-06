<?php
session_start();
include '../../database/db.php';

// Check if user is logged in as admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No candidate ID provided']);
    exit();
}

$candidate_id = intval($_GET['id']);

try {
    // Start transaction
    $conn->begin_transaction();

    // First, get the candidate's info including image URL and position
    $candidate_query = "SELECT image_url, position, election_id FROM candidates WHERE id = ?";
    $stmt = $conn->prepare($candidate_query);
    $stmt->bind_param("i", $candidate_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $candidate = $result->fetch_assoc();
    $stmt->close();

    if (!$candidate) {
        throw new Exception("Candidate not found");
    }

    // Delete votes for all candidates of this position in this election
    $delete_position_votes = "DELETE FROM votes 
                            WHERE election_id = ? 
                            AND candidate_position = ?";
    $stmt = $conn->prepare($delete_position_votes);
    $stmt->bind_param("is", $candidate['election_id'], $candidate['position']);
    $stmt->execute();
    $stmt->close();

    // Then delete the candidate
    $delete_query = "DELETE FROM candidates WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $candidate_id);
    
    if ($stmt->execute()) {
        // If deletion was successful and there was an image, delete it
        if ($candidate['image_url']) {
            $image_path = "../../" . $candidate['image_url'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        
        // Commit the transaction
        $conn->commit();
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Candidate deleted successfully']);
    } else {
        throw new Exception("Error deleting candidate");
    }
} catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollback();
    
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false, 
        'message' => 'Error deleting candidate: ' . $e->getMessage()
    ]);
}

if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?> 