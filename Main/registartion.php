<?php
$host = 'localhost';
$user = 'root'; // Default username for XAMPP/WAMP
$password = ''; // Default password for XAMPP/WAMP
$dbname = 'project_craft'; // Database name

// Connect to the database
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $fn = $_POST['first'];
    $ln = $_POST['last'];
    $pw = $_POST['password'];
    $em = $_POST['email'];
    $ph = $_POST['phone'];
    $ad = $_POST['address'];

    // Insert data into the register table
    $sql = "INSERT INTO user_register (First_name, Last_name, Password, Email, Phone, Address)
            VALUES ('$fn', '$ln', '$pw', '$em', '$ph', '$ad')";

    if ($conn->query($sql) === TRUE) {
        header('Location: login.html');
    
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
       
    }
}

// Close the connection
$conn->close();
?>