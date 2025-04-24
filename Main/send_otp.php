<?php
session_start();

// Include PHPMailer files
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

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
    $email = $_POST['email'];
    
    // Check if email exists in database
    $sql = "SELECT * FROM user_register WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate 6-digit OTP
        $otp = rand(100000, 999999);
        
        // Store OTP in session
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;
        $_SESSION['otp_sent'] = true;
        
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'meets3591@gmail.com';
            $mail->Password = 'pvib snnq tqyf lgmb'; // You need to generate an App Password from Google Account
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('meets3591@gmail.com', 'Craft Maestros');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .otp-box { 
                            background-color: #f8f9fa; 
                            padding: 20px; 
                            border-radius: 5px; 
                            text-align: center; 
                            margin: 20px 0; 
                        }
                        .otp { 
                            font-size: 24px; 
                            font-weight: bold; 
                            color: #560e30; 
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <h2>Password Reset Request</h2>
                        <p>You have requested to reset your password. Please use the following OTP to proceed:</p>
                        <div class='otp-box'>
                            <span class='otp'>$otp</span>
                        </div>
                        <p>This OTP is valid for 10 minutes.</p>
                        <p>If you didn't request this password reset, please ignore this email.</p>
                        <p>Best regards,<br>Craft Maestros Team</p>
                    </div>
                </body>
                </html>
            ";

            $mail->send();
            $_SESSION['message'] = "OTP has been sent to your email address.";
            $_SESSION['message_type'] = "success";
        } catch (Exception $e) {
            $_SESSION['message'] = "Failed to send OTP. Please try again later.";
            $_SESSION['message_type'] = "error";
            // For debugging
            // $_SESSION['message'] = "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        $_SESSION['message'] = "Email address not found in our records.";
        $_SESSION['message_type'] = "error";
    }
    
    $stmt->close();
    $conn->close();
    
    // Redirect back to forgot password page
    header("Location: forgot_pass.php");
    exit();
}
?> 