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
    $pw = $_POST['password'];
    $em = $_POST['email'];
    $ph = $_POST['contact'];
   
    // Insert data into the register table
    $sql = "INSERT INTO vendors( Name, Password, Email, contact)
            VALUES ('$fn', '$pw', '$em', '$ph')";

    if ($conn->query($sql) === TRUE) {
        header('Location: vendor_login.html');
    
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
       
    }
}

// Close the connection
$conn->close();
?>