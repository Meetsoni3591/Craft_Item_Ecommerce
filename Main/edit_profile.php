<?php
session_start();
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'project_craft';
$conn = new mysqli($host, $user, $password, $dbname);

if (!isset($_SESSION['user']['userid'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user']['userid'];

// Fetch user details safely
$stmt = $conn->prepare("SELECT First_name, Last_name, Email, Phone, Address FROM user_register WHERE ID = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc() ?? [];

$first = $user['First_name'] ?? '';
$last = $user['Last_name'] ?? '';
$email = $user['Email'] ?? '';
$phone = $user['Phone'] ?? '';
$address = $user['Address'] ?? '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = trim($_POST['first'] ?? '');
    $last = trim($_POST['last'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');

    // Validate email & phone
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        die("Invalid phone number. Must be 10 digits.");
    }

    $stmt = $conn->prepare("UPDATE user_register SET First_name=?, Last_name=?, Email=?, Phone=?, Address=? WHERE ID=?");
    $stmt->bind_param("sssssi", $first, $last, $email, $phone, $address, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Profile Updated Successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="registration.css">
</head>
<style>
    /* General Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

/* Background Styling */
body {
    background: url('Images/loginformbackground.jpg') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Container Box */
.container {
    background: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 10px;
    width: 400px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    text-align: center;
    animation: fadeIn 0.5s ease-in-out;
}

/* Form Header */
h2 {
    margin-bottom: 20px;
    color: #333;
    font-size: 22px;
}

/* Input Fields */
.input-group {
    margin-bottom: 15px;
    text-align: left;
}

.input-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #444;
}

.input-group input,
.input-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    transition: 0.3s ease-in-out;
}

.input-group input:focus,
.input-group textarea:focus {
    border-color: #6c404f;
    outline: none;
    box-shadow: 0 0 5px rgba(108, 64, 79, 0.5);
}

/* Buttons */
.btn {
    display: block;
    width: 100%;
    background: rgb(108, 64, 79);
    color: white;
    padding: 12px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
    transition: 0.3s ease-in-out;
}

.btn:hover {
    background: rgb(85, 50, 63);
}

.cancel {
    background: rgb(96, 72, 100);
}

.cancel:hover {
    background: rgb(85, 50, 63);
    opacity: 0.9;
}

/* Responsive Design */
@media screen and (max-width: 500px) {
    .container {
        width: 90%;
        padding: 20px;
    }

    h2 {
        font-size: 20px;
    }

    .btn {
        font-size: 14px;
    }
}

/* Fade In Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

</style>
<body>
    <div class="container">
        <h2>EDIT PROFILE</h2>
        <form method="POST" action="">
            <div class="input-group">
                <label for="first">First Name</label>
                <input type="text" id="first" name="first" value="<?php echo htmlspecialchars($first); ?>" required>
            </div>

            <div class="input-group">
                <label for="last">Last Name</label>
                <input type="text" id="last" name="last" value="<?php echo htmlspecialchars($last); ?>" required>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <div class="input-group">
                <label for="phone">Phone</label>
                <input type="number" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
            </div>

            <div class="input-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" required><?php echo htmlspecialchars($address); ?></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn">Update Profile</button>
                <a href="profile.php" class="btn cancel">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
