<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: login.php");
exit;
?>
