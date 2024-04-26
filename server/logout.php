<?php

// If it's desired to kill the session, also 
// delete the session cookie. 
// Note: This will destroy the session, and 
// not just the session data! 
// Start the session
session_start(); 

// Clear all session variables
$_SESSION = []; 

// If the session uses cookies, delete the session cookie
if (ini_get("session.use_cookies")) { 
    $params = session_get_cookie_params(); 
    setcookie(session_name(), '', time() - 42000, 
        $params["path"], $params["domain"], 
        $params["secure"], $params["httponly"] 
    ); 
} 

// Destroy the session
session_destroy();

// Redirect to events.php after destroying the session
header("Location: events.php");
?>
