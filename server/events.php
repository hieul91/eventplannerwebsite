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

// Get search term from query parameter
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Retrieve events based on search term or get all events
if ($searchTerm) {
    $stmt = $conn->prepare("
        SELECT e.*, count(r.user_id) as numberofguests
        FROM event e 
        LEFT JOIN rsvp r ON e.id = r.event_id
        WHERE e.name LIKE :searchTerm OR e.type LIKE :searchTerm OR e.location LIKE :searchTerm
        GROUP BY e.id
    ");
    $stmt->execute(['searchTerm' => "%$searchTerm%"]);
    $events = $stmt->fetchAll();
} else {
    $stmt = $conn->prepare("
        SELECT e.*, count(r.user_id) as numberofguests
        FROM event e 
        LEFT JOIN rsvp r ON e.id = r.event_id
        GROUP BY e.id
    ");
    $stmt->execute();
    $events = $stmt->fetchAll();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Planning</title>

    <!-- External libraries and stylesheets -->
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/registration.css">
    <script src="../scripts/events.js"></script>

</head>
<body>
    <!-- Navbar -->
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

    <!-- Search form -->
    <form action="events.php" method="get">
        <div class="textfield">
            <label for="search"></label>
            <input type="text" id="search" name="search" placeholder="Search by name, location, or type..."
                   value="<?php echo $searchTerm ?>">
            <button type="submit" value="Search">Search</button>
        </div>
    </form>

    <!-- Event table -->
    <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Date and Time</th>
            <th>Type</th>
            <th>Location</th>
            <th>Enrolled Guests</th>
            <th>Max Guests</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Display events and their details
        if (empty(($events[0]['id']))) {
            echo '<tr><td colspan="8">No records found</td></tr>';
        } else {
            foreach ($events as $event) {
                echo '<tr>';
                echo '<td>'.$event['id'].'</td>';
                echo '<td>'.$event['name'].'</td>';
                echo '<td>'.date('Y-m-d H:i', $event['datetime']).'</td>';
                echo '<td>'.$event['type'].'</td>';
                echo '<td>'.$event['location'].'</td>';
                echo '<td>'.$event['numberofguests'].'</td>';
                echo '<td>'.$event['maxguests'].'</td>';
                echo '<td>';
                // Display RSVP button based on available space
                if ($event['numberofguests'] < $event['maxguests']) {
                    echo '<a class="rsvpBtn" href="rsvp.php?id=' . $event['id'] . '">RSVP</a>';
                } else {
                    echo '<a class="norsvpBtn" href="javascript:void(0)">RSVP</a>';
                }
                // Display edit and delete buttons for events created by the logged-in user
                if ($event['createdby'] == $_SESSION['id']) {
                    echo '<a class="editBtn" href="edit.php?id=' . $event['id'] . '">View/Edit</a>';
                    echo '<a class="deleteBtn" onclick="delete_event(\'' . $event['id'] . '\')">Delete</a>';
                }
                echo '</td>';
                echo '</tr>';
            }
        }
        ?>
        </tbody>
    </table>
    <!-- Create event button -->
    <a href="create.php" class="createBtn">Create Event</a>
</body>
</html>
