<?php
session_start();

// Check if the admin is logged in
if (isset($_SESSION['email'])) {
    header("Location: dashboard.php"); // Redirect to admin dashboard
    exit();
} else {
    header("Location: admin_login.html"); // Redirect to login page
    exit();
}
?>
