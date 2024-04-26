<?php
// Enable displaying all errors and warnings
error_reporting(E_ALL ^ E_NOTICE);

// Start the session
session_start();

// Extract POST data
extract($_POST);

// Connect to MySQL database
require_once __DIR__ . '/../database/conn.php';

// Check if the email already exists in the database
$stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$result = $stmt->fetchAll();

// If the email already exists, display an error message and redirect
if ($result) {
    echo "<script>
    alert('A user with this email has already signed up!'); 
    window.location.href = 'http://localhost/book/pages/registration.html';
    </script>";
} else {
    // Hash the password
    $hashedPassword = hash("sha256", $pass);

    // Insert the new user into the database
    $stmt = $conn->prepare("
        INSERT INTO user 
        VALUES(NULL, :fullname, :email, :hashedPassword)
    ");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':hashedPassword', $hashedPassword);
    $result = $stmt->execute();

    // If the user is successfully registered, store data in session and redirect
    if ($result) {
        $id = $conn->lastInsertId();
        $_SESSION["id"] = $id;
        $_SESSION["fullname"] = $fullname;
        header("Location: events.php");
    }
}
?>
