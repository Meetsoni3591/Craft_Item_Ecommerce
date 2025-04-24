<?php
session_start();
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            background: url('Images/loginformbackground.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .forgot-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 4px 10px rgb(0, 0, 0);
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #560e30;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }

        input[type="email"],
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn {
            background: #560e30;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 10px;
        }

        .btn:hover {
            background: #752d42;
        }

        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .otp-section {
            display: none;
        }

        .password-section {
            display: none;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="forgot-container">
            <h2>Forgot Password</h2>
            
            <!-- Email Form -->
            <div id="emailForm">
                <form action="send_otp.php" method="POST">
                    <div class="form-group">
                        <label for="email">Enter your email address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn">Send OTP</button>
                </form>
            </div>

            <!-- OTP Verification Form -->
            <div id="otpForm" class="otp-section">
                <form action="reset_password.php" method="POST">
                    <div class="form-group">
                        <label for="otp">Enter OTP</label>
                        <input type="text" id="otp" name="otp" required maxlength="6">
                    </div>
                    <button type="submit" class="btn">Verify OTP</button>
                </form>
            </div>

            <!-- New Password Form -->
            <div id="passwordForm" class="password-section">
                <form action="reset_password.php" method="POST">
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn">Reset Password</button>
                </form>
            </div>

            <?php
            if (isset($_SESSION['message'])) {
                echo '<div class="message ' . $_SESSION['message_type'] . '">' . $_SESSION['message'] . '</div>';
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            }
            ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        // Show OTP form if OTP is sent
        <?php if (isset($_SESSION['otp_sent'])): ?>
            document.getElementById('emailForm').style.display = 'none';
            document.getElementById('otpForm').style.display = 'block';
        <?php endif; ?>

        // Show password form if OTP is verified
        <?php if (isset($_SESSION['otp_verified'])): ?>
            document.getElementById('emailForm').style.display = 'none';
            document.getElementById('otpForm').style.display = 'none';
            document.getElementById('passwordForm').style.display = 'block';
        <?php endif; ?>
    </script>
</body>
</html> 