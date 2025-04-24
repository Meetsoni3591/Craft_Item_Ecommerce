<?php
session_start();
$host = 'localhost';
$user = 'root'; 
$password = ''; 
$dbname = 'project_craft'; 
$conn = new mysqli($host, $user, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $em = $_POST['email'];
    $pwd = $_POST['Password'];

    $sql = "SELECT * FROM user_register WHERE email='$em' ";
    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
        $data = $res->fetch_assoc();
        $user_id = $data['ID'];
        $user_email = $data['Email'];
        $user_pass = $data['Password'];
        $user_name = $data['First_name']; // Assuming you have a Full_Name column
        $user_phone = $data['Phone']; // Assuming you have a Phone column
        $user_address = $data['Address']; // Assuming you have an Address column
        // $profile_image = $data['Profile_Image']; // Assuming you store profile image

        if ($pwd == $user_pass) {
            $_SESSION['user'] = [
                'userid' => $user_id,
                'email' => $user_email,
                'first_name' => $user_name,
                'phone' => $user_phone,
                'address' => $user_address,
                'profile_image' => $profile_image
            ];
           
            header('Location: homepage.php'); // Redirect to profile page
            exit;
        } else {
            echo "Invalid password. <a href='register.html'>Try again</a>";
        }
    } else {
        echo "No user found with this email. <a href='register.html'>Register here</a>";
    }
}
?>
