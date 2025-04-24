<?php
session_start();
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'project_craft';

// Create database connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_email = $_POST['email'];
    $admin_name = $_POST['name'];
    $admin_password = $_POST['password']; // Ensure 'password' matches input field name in HTML

    // Fetch admin details from database
    $sql = "SELECT * FROM admin_register WHERE email='$admin_email'";
    $res = $conn->query($sql);
    
    if ($res->num_rows > 0) {
        $data = $res->fetch_assoc();

        // Verify password (assuming it's stored as a hashed password)
        if ($admin_password == $data['password'] && $admin_name == $data['Admin_name']) { 
            // Store admin details in session
            $_SESSION['Admin_name'] = $admin_name;
            $_SESSION['email'] = $data['email'];
            // $_SESSION['Admin_name'] = $data['Admin_name']; // Make sure 'name' column exists in your database
            
            header('Location: dashboard.php'); // Redirect to dashboard
            exit();
        } else {
            echo "<script>alert('Invalid password!'); window.location.href='admin_login.html';</script>";
        }
    } else {
        echo "<script>alert('No user found with this email!'); window.location.href='admin_login.html';</script>";
    }
}

// Close database connection
$conn->close();
?>
