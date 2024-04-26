<?php
// Enable displaying all errors and warnings
error_reporting(E_ALL ^ E_NOTICE);

// Start the session
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION["id"]) && !isset($_SESSION["fullname"])) {
    header("Location: ../pages/login.html");
    exit();
}

// Connect to MySQL database
require_once __DIR__ . '/../database/conn.php';

// Check if 'id' parameter is set in the URL and user is logged in
if (isset($_GET['id']) && isset($_SESSION['id'])) {
    extract($_GET);

    // Check if the user has already RSVPed to the event
    $stmt = $conn->prepare("
        SELECT * FROM rsvp WHERE user_id = :user_id AND event_id = :event_id
    ");
    $stmt->execute(['user_id' => $_SESSION['id'], 'event_id' => $id]);
    $rsvp = $stmt->fetchAll();

    // If user has already RSVPed, display an alert and redirect
    if (!empty($rsvp[0]['id'])) {
        echo "<script>
        alert('You have already RSVPed to this event!'); 
        window.location.href = 'events.php';
        </script>";
        exit();
    }

    // Insert RSVP into the database
    $stmt = $conn->prepare("
        INSERT INTO rsvp
        VALUES(NULL, :user_id, :event_id)
    ");
    $result = $stmt->execute(['user_id' => $_SESSION['id'], 'event_id' => $id]);

    // Display success or failure message based on RSVP result
    if ($result) {
        echo "<script>
        alert('Successfully reserved!'); 
        window.location.href = 'events.php';
        </script>";
    } else {
        echo "<script>
        alert('Failed to reserve!'); 
        window.location.href = 'events.php';
        </script>";
    }
} else {
    // Redirect to events page if 'id' parameter is not set or user is not logged in
    header("Location: events.php");
    exit();
}
?>
