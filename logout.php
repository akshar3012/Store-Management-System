<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Optionally, redirect to login or homepage
header("Location: index.php"); // Change to your login page
exit;
?>
