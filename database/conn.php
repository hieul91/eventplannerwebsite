<?php 

// Database connection parameters
$servername = "localhost"; // Server name
$username = "root"; // Database username
$password = ""; // Database password
$db = "event_db"; // Database name

try {
    // Attempt to create a new PDO connection to the database
    $conn = new PDO("mysql:host=$servername;port=3350;dbname=$db", $username, $password);
    
    // Set PDO error mode to throw exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Successful connection message (empty echo)
    echo ""; 
} catch (PDOException $e) {
    // Exception handling in case of connection failure
    echo "Failed" . $e->getMessage();
}

?>
