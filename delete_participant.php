<?php
include 'db.php';

if (isset($_GET['id'])) {
    $participant_id = $_GET['id'];
    
    // Get event_id before deleting the participant
    $sql = "SELECT event_id FROM participants WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $participant_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $participant = $result->fetch_assoc();
    $event_id = $participant['event_id'];
    
    // Delete the participant
    $sql = "DELETE FROM participants WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $participant_id);
    
    if ($stmt->execute()) {
        header("Location: event_details.php?id=" . $event_id);
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
