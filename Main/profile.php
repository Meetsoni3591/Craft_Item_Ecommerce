<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.html"); 
    exit();
}

$user = $_SESSION['user'];
// $user_id = $user['userid'];

$em = $user['email'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_craft";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM user_register WHERE email='$em' ";
$res = $conn->query($sql);

if ($res->num_rows > 0) {
    $data = $res->fetch_assoc();
    $user_id = $data['ID'];
    $user_email = $data['Email'];
    $user_name = $data['First_name']; // Assuming you have a Full_Name column
    $user_phone = $data['Phone']; // Assuming you have a Phone column
    $user_address = $data['Address']; 
}

// Include header
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- <link rel="stylesheet" href="profile.css"> -->
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background: url('Images/loginformbackground.jpg') no-repeat center center fixed;
            background-size: cover;
            background-color: white;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1 0 auto;
            padding: 20px;
        }

        .profile-container {
            /* background-image: url("Images/loginformbackground.jpg"); */
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 4px 10px rgb(0, 0, 0);
            width: 500px;
            text-align: justify;
            margin: 50px auto;
            /* animation: fadeIn 0.5s ease-in-out; */
        }

        /* @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        } */

        h2 {
            font-size: 26px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }

        .profile-pic {
            background-image: url("Images/loginformbackground.jpg");

            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgb(190, 190, 190);
            margin-bottom: 15px;
        }

        .info {
            font-size: 18px;
            margin: 10px 0;
            color: #555;
            font-weight: 500;
        }

        strong {
            color: #333;
        }

        .btn {
            background: rgb(123, 67, 172);
            color: white;
            padding: 12px;
            width: 100%;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-top: 15px;
        }

        .btn:hover {
            background: rgb(136, 120, 137);
        }

        .logout {
            color: blueviolet;
            display: block;
            margin-top: 10px;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
        }

        .logout:hover {
            text-decoration: underline;
        }

        .breadcrumb {
            margin: 20px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }

        .breadcrumb a {
            color: #560e30;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        footer {
            flex-shrink: 0;
            width: 100%;
            background-color: #6c243c;
            color: white;
            padding: 20px 0;
            margin-top: auto;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-section {
            width: 18%;
        }

        .footer-section h3 {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 8px;
        }

        .footer-section ul li a {
            text-decoration: none;
            color: white;
            font-size: 14px;
        }

        .footer-section ul li a:hover {
            text-decoration: underline;
        }

        .contact p {
            font-size: 14px;
            margin: 5px 0;
        }

        .contact a {
            color: white;
        }

        .socialMedia a {
            width: 50px;
            height: 50px;
            text-decoration: none;
            text-align: right;
            margin-right: 15px;
            border-radius: 5px;
            transition: 0.4s;
            padding: 2px;
        }

        .socialMedia a i {
            color: #ddd;
            font-size: 25px;
            line-height: 35px;
            border: 1px solid transparent;
            transition-delay: 0.4s;
        }

        .socialMedia a:hover i {
            color: rgb(203, 128, 170);
        }

        .copyright {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>
    <!-- <div class="breadcrumb">
        <a href="homepage.php">Home</a> / 
        <span>Profile</span>
    </div> -->

    <div class="main-content">
        <div class="profile-container">
            <h2>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h2>
            <!-- <img src="<?php echo $user['profile_image']; ?>" alt="Profile Picture" class="profile-pic"> -->
            <p class="info"><strong>Email:</strong> <?php echo htmlspecialchars($user_email); ?></p>
            <p class="info"><strong>Phone:</strong> <?php echo htmlspecialchars($user_phone); ?></p>
            <p class="info"><strong>Address:</strong> <?php echo htmlspecialchars($user_address); ?></p>

            <a href="edit_profile.php" class="btn">Edit Profile</a>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
