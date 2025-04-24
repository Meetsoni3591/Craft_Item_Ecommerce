<?php
session_start(); 

// Check if the admin is logged in
if (isset($_SESSION['user'])) {

    header("Location: /Projectcraft/Main/Homepage.php"); // Redirect to user Homepage
    // exit();
} else {
    header("Location: /Projectcraft/main/login.html"); // Redirect to login page
    // exit();
}
?>
