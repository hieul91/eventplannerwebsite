<?php
//PHP page for creating events
// Turn off error reporting for notices
error_reporting(E_ALL ^ E_NOTICE);

// Start session
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION["id"]) && !isset($_SESSION["fullname"])) {
    header("Location: ../pages/login.html");
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract form data
    extract($_POST);

    // Include database connection
    require_once __DIR__ . '/../database/conn.php';

    // Prepare and execute SQL query to insert new event
    $stmt = $conn->prepare("
        INSERT INTO event
        VALUES(NULL, :name, :datetime, :location, :maxguest, :type, :createdby)
    ");
    $stmt->bindParam(':name', $name);
    $strtotime = strtotime($datetime);
    $stmt->bindParam(':datetime', $strtotime);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':maxguest', $maxguest);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':createdby', $_SESSION['id']);
    $stmt->execute();

    // Redirect to events page after event creation
    header("Location: events.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character set and viewport -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- External CSS files for styling -->
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/registration.css">
    
    <!-- Title of the webpage -->
    <title>Event Planning Form</title>
</head>
<body>
<header>
    <h1>Event Planner</h1>
    <!-- Navigation menu -->
    <nav>
        <ul>
            <?php
            // Display welcome message and logout link if user is logged in
            if (isset($_SESSION['fullname'])) {
                echo '<li><a class="nav-link" href="">Welcome '.$_SESSION['fullname'].'</a></li>';
                echo '<li><a class="nav-link" href="logout.php">Log Out</a></li>';
                echo '<li><a href="events.php">EVENT</a></li>';
            }
            // Display login and registration links if user is not logged in
            else {
                echo '<li><a href="../pages/index.html">HOME</a></li>';
                echo '<li><a href="events.php">EVENT</a></li>';
                echo '<li><a href="../pages/login.html">LOGIN</a></li>';
                echo '<li><a href="../pages/registration.html">REGISTRATION</a></li>';
            }
            ?>
        </ul>
    </nav>
</header>

<!-- Form for creating a new event -->
<h2>Create an event</h2>
<form action="create.php" method="POST">
    <div class="textfield">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    </div>

    <div class="textfield">
        <label for="datetime">Date:</label>
        <input type="datetime-local" id="datetime" name="datetime" required>
    </div>

    <div class="textfield">
        <label for="location">Location:</label>
        <select id="location" name="location" required>
            <option value="blue">Blue Room</option>
            <option value="green">Green Room</option>
            <option value="red">Red Room</option>
        </select>
    </div>

    <div class="textfield">
        <label for="maxguest">Maximum Guest</label>
        <input type="number" id="maxguest" name="maxguest" required>
    </div>

    <div class="textfield">
        <label for="type">Type of Event:</label>
        <select id="type" name="type" required>
            <option value="birthday">Birthday</option>
            <option value="wedding">Wedding</option>
            <option value="concert">Concert</option>
            <option value="meeting">Meeting</option>
        </select>
    </div>

    <!-- Submit and back buttons for the form -->
    <button type="submit">Save</button>
    <button type="button" onclick="window.location.href='../server/events.php'">Back</button>
</form>
</body>
</html>


