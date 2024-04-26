<?php
// Turn off error reporting for notices
error_reporting(E_ALL ^ E_NOTICE);

// Start the session
session_start();

// Redirect to login page if user is not logged in
if(!isset($_SESSION["id"]) && !isset($_SESSION["fullname"])){
    header("Location: ../pages/login.html");
    exit();
}

// Include database connection
require_once __DIR__ . '/../database/conn.php';

// Process GET request
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    if (empty($id)) {
        // Redirect to events page if event id is not provided
        header("Location: events.php");
        exit();
    } else {
        // Retrieve event details and associated guests from the database
        $stmt = $conn->prepare("
            SELECT * FROM event WHERE id = :id
        ");
        $stmt->execute(['id' => $id]);
        $event = $stmt->fetch();

        $stmt = $conn->prepare("
            SELECT user.*
            FROM rsvp
            LEFT JOIN user ON rsvp.user_id = user.id
            WHERE rsvp.event_id = :id
        ");
        $stmt->execute(['id' => $event['id']]);
        $guests = $stmt->fetchAll();
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process POST request to update event details
    extract($_POST);
    $stmt = $conn->prepare("
        UPDATE event
        SET name = :name, datetime = :datetime, location = :location, maxguests = :maxguest, type = :type
        WHERE id = :id
    ");
    $stmt->bindParam(':name', $name);
    $strtotime = strtotime($datetime);
    $stmt->bindParam(':datetime', $strtotime);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':maxguest', $maxguest);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam('id', $id);
    $stmt->execute();

    // Redirect to events page after updating event details
    header("Location: events.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/registration.css">
    <link rel="stylesheet" href="../css/table.css">
    <title>Event Planning Details</title>

    <!-- Additional inline styling -->
    <style>
        .container {
            display: flex;
            justify-content: center;
        }
        .left {
            width: 50%;
            padding: 1em;
            box-sizing: border-box;
        }
        .right {
            width: 30%;
            padding: 2em 1em;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
<header>
    <h1>Event Planner</h1>
    <nav>
        <ul>
            <?php
            // Display navigation links based on user session
            if(isset($_SESSION['fullname'])) {
                echo '<li><a class="nav-link" href="">Welcome '.$_SESSION['fullname'].'</a></li>';
                echo '<li><a class="nav-link" href="logout.php">Log Out</a></li>';
                echo '<li><a href="events.php">EVENT</a></li>';
            }
            else{
                echo '<li><a href="../pages/index.html">HOME</a></li>';
                echo '<li><a href="events.php">EVENT</a></li>';
                echo '<li><a href="../pages/login.html">LOGIN</a></li>';
                echo '<li><a href="../pages/registration.html">REGISTRATION</a></li>';
            }
            ?>
        </ul>
    </nav>
</header>

<!-- Edit event form -->
<h2>Edit an event</h2>
<div class="container">
    <div class="left">
        <form action="edit.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $event['id']; ?>">

            <!-- Input fields for event details -->
            <div class="textfield">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $event['name']; ?>"  required>
            </div>

            <!-- Additional input fields for event details -->
            <div class="textfield">
                <label for="datetime">Date:</label>
                <input type="datetime-local" id="datetime" name="datetime" value="<?php echo date('Y-m-d\TH:i', $event['datetime']); ?>" required>
            </div>

            <div class="textfield">
                <label for="location">Location:</label>
                <select id="location" name="location" required>
                    <?php
                    $locations = ['blue', 'green', 'red'];
                    foreach($locations as $location){
                        if($location == $event['location']){
                            echo "<option value='$location' selected>$location</option>";
                        } else {
                            echo "<option value='$location'>$location</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="textfield">
                <label for="maxguest">Maximum Guest</label>
                <input type="number" id="maxguest" name="maxguest" value="<?php echo $event['maxguests']; ?>" required>
            </div>

            <div class="textfield">
                <label for="type">Type of Event:</label>
                <select id="type" name="type" required>
                    <?php
                    $types = ['birthday', 'wedding', 'concert', 'meeting'];
                    foreach($types as $type){
                        if($type == $event['type']){
                            echo "<option value='$type' selected>$type</option>";
                        } else {
                            echo "<option value='$type'>$type</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <!-- ... -->

            <button type="submit">Save</button>
            <button type="button" onclick="window.location.href='../server/events.php'">Back</button>
        </form>
    </div>
    <!-- Display guests information -->
    <div class="right">
        <h3>Guests Information</h3>
        <p><?php echo count($guests)?> guest(s) have been reserved.</p>
        <table>
            <thead>
            <tr>
                <th colspan="2">ID</th>
                <th>Full name</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Display guest details
            if (empty(($guests[0]['id']))) {
                echo '<tr><td colspan="8">No records found</td></tr>';
            } else {
                foreach($guests as $guest){
                    echo "<tr>
                            <td colspan='2'>{$guest['id']}</td>
                            <td>{$guest['fullname']}</td>
                            <td>{$guest['email']}</td>
                          </tr>";
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>