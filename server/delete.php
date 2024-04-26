<?php
// Turn off error reporting for notices
error_reporting(E_ALL ^ E_NOTICE);

// Include database connection
require_once __DIR__ . '/../database/conn.php';

// Check if event id is provided in the URL
if (isset($_GET['id'])) {
    $eventid = $_GET['id'];

    // Delete RSVPs associated with the event
    $stmt = $conn->prepare("DELETE FROM rsvp WHERE event_id = ?");
    $stmt->execute([$eventid]);

    // Delete the event from the database
    $stmt = $conn->prepare("DELETE FROM event WHERE id = ?");
    $stmt->execute([$eventid]);

    // Redirect to events page after successful deletion
    header("Location: events.php");
    exit();
} else {
    // Redirect to events page if event id is not provided
    header("Location: events.php");
    exit();
}
?>
