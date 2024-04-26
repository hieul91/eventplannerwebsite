<?php
// Turn off error reporting for notices
error_reporting(E_ALL ^ E_NOTICE);

// Start the session
session_start();

// Extract POST data
extract($_POST);

// Connect to the MySQL database
require_once __DIR__ . '/../database/conn.php';

// Hash the password for security
$hashedPassword = hash("sha256", $pass);

// Prepare and execute the SQL statement to retrieve user data
$stmt = $conn->prepare("SELECT * FROM user WHERE email = :email AND password = :password");
$stmt->bindParam(':email', $email); // Bind email parameter to prevent SQL injection
$stmt->bindParam(':password', $hashedPassword); // Bind hashed password for comparison
$stmt->execute();
$result = $stmt->fetchAll();

/* Query the database for existing password and email.
If exists or not, will perform corresponding action */

if(!$result){
    // Redirect to login page with error message if login fails
    echo "<script>
    alert('Invalid email and/or password. Please login again.'); 
    window.location.href = '../pages/login.html';
    </script>";
} else {
    // Store user data in session variables
    $_SESSION["id"] = $result[0]['id'];
    $_SESSION["fullname"] = $result[0]['fullname'];
    
    // Redirect to events page on successful login
    header("Location: events.php");
}
?>

