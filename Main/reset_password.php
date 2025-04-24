<?php
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['otp'])) {
        // OTP verification
        $entered_otp = $_POST['otp'];
        
        if (isset($_SESSION['otp']) && $entered_otp == $_SESSION['otp']) {
            $_SESSION['otp_verified'] = true;
            $_SESSION['message'] = "OTP verified successfully. Please enter your new password.";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Invalid OTP. Please try again.";
            $_SESSION['message_type'] = "error";
        }
    } elseif (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        // Password reset
        if (!isset($_SESSION['otp_verified']) || !$_SESSION['otp_verified']) {
            $_SESSION['message'] = "OTP verification required.";
            $_SESSION['message_type'] = "error";
        } else {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            
            if ($new_password === $confirm_password) {
                // Update password in database (plain text)
                $email = $_SESSION['email'];
                $sql = "UPDATE user_register SET Password = ? WHERE Email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $new_password, $email);
                
                if ($stmt->execute()) {
                    // Clear session variables
                    unset($_SESSION['otp']);
                    unset($_SESSION['email']);
                    unset($_SESSION['otp_verified']);
                    
                    $_SESSION['message'] = "Password has been reset successfully. Please login with your new password.";
                    $_SESSION['message_type'] = "success";
                    
                    // Redirect to login page
                    header("Location: login.html");
                    exit();
                } else {
                    $_SESSION['message'] = "Failed to reset password. Please try again.";
                    $_SESSION['message_type'] = "error";
                }
                
                $stmt->close();
            } else {
                $_SESSION['message'] = "Passwords do not match.";
                $_SESSION['message_type'] = "error";
            }
        }
    }
    
    $conn->close();
    
    // Redirect back to forgot password page
    header("Location: forgot_pass.php");
    exit();
}
?> 