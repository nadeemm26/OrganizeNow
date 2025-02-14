<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

session_start();
$conn = new mysqli('localhost', 'root', '', 'um');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['reset'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $result = $conn->query("SELECT * FROM user WHERE email='$email'");

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50));
        $conn->query("UPDATE user SET reset_token='$token' WHERE email='$email'");

        $reset_link = "http://localhost:8080/OrganizeNow/Customer/reset_password.php?token=$token";


        // ✅ Setup PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'makwananadeem3@gmail.com'; // Change this
            $mail->Password = 'asfz zife ytvk fdgl';   // Change this (Use App Password)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('makwananadeem3@gmail.com', 'OrganizeNow');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "Click <a href='$reset_link'>here</a> to reset your password carefully and remember.";

            if ($mail->send()) {
                echo "<script>alert('✔ Reset link sent! Check your email.');</script>";
            } else {
                echo "<script>alert('❌ Failed to send email.');</script>";
            }
        } catch (Exception $e) {
            echo "<script>alert('❌ Email error: {$mail->ErrorInfo}');</script>";
        }
    } else {
        echo "<script>alert('❌ Email not found!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../Admin/all_form.css">
</head>
<body>
    <form method="post">
        <h2>Forgot Password</h2>
        <input type="email" name="email" placeholder="Enter your email" required><br>
        <button type="submit" name="reset">Send Reset Link</button>
    </form>
</body>
</html>
