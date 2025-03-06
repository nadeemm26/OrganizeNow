<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../Customer/PHPMailer/src/Exception.php';
require '../Customer/PHPMailer/src/PHPMailer.php';
require '../Customer/PHPMailer/src/SMTP.php';

session_start();
$conn = new mysqli('localhost', 'root', '', 'um');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Function to send OTP via Email
function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'makwananadeem3@gmail.com'; // Gmail ID
        $mail->Password   = 'asfz zife ytvk fdgl'; // App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('makwananadeem3@gmail.com', 'Organize Now');
        $mail->addAddress($email);
        $mail->Subject = 'Your OTP Code';

        $mail->isHTML(true);
        $mail->Body = "<h2>Your OTP Code</h2><p style='font-size:18px; font-weight:bold;'>$otp</p>";
        $mail->AltBody = "Your OTP is: $otp";

        return $mail->send();
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}

// ✅ Step 1: Send OTP
if (isset($_POST['send_otp'])) {
    $email = trim($_POST['email']);
    $_SESSION['email'] = $email;

    // Generate OTP
    $otp = rand(100000, 999999);
    $expiry = time() + 300; // 5 min expiry

    // Store OTP using Prepared Statement
    $stmt = $conn->prepare("UPDATE user SET otp=?, otp_expiry=? WHERE email=?");
    $stmt->bind_param("sis", $otp, $expiry, $email);
    
    if ($stmt->execute() && sendOTP($email, $otp)) {
        $_SESSION['step'] = 2;
        header("Location: forgot_password.php");
        exit();
    } else {
        echo "<script>alert('❌ Failed to send OTP!');</script>";
    }
    $stmt->close();
}

// ✅ Step 2: Verify OTP
if (isset($_POST['verify_otp'])) {
    $email = $_SESSION['email'];
    $otp = trim($_POST['otp']);

    $stmt = $conn->prepare("SELECT otp, otp_expiry FROM user WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($db_otp, $otp_expiry);
    $stmt->fetch();
    $stmt->close();

    if ($db_otp == $otp && time() < $otp_expiry) {
        $_SESSION['otp_verified'] = true;
        $_SESSION['step'] = 3;
        header("Location: forgot_password.php");
        exit();
    } else {
        echo "<script>alert('❌ Invalid or Expired OTP!');</script>";
    }
}

// ✅ Step 3: Reset Password
if (isset($_POST['reset_password']) && isset($_SESSION['otp_verified'])) {
    $email = $_SESSION['email'];
    $new_password = password_hash(trim($_POST['new_password']), PASSWORD_BCRYPT);

    $stmt = $conn->prepare("UPDATE user SET password=?, otp=NULL, otp_expiry=NULL WHERE email=?");
    $stmt->bind_param("ss", $new_password, $email);
    
    if ($stmt->execute()) {
        session_destroy();
        echo "<script>alert('✅ Password Reset Successfully!'); window.location.href = '../index.php';</script>";
        exit();
    } else {
        echo "<script>alert('❌ Failed to reset password!');</script>";
    }
    $stmt->close();
}

// ✅ Step Control
$step = isset($_SESSION['step']) ? $_SESSION['step'] : 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../Admin/all_form.css">
</head>
<body>

<?php if ($step == 1): ?>
    <form method="post">
        <h2>Forgot Password</h2>
        <input type="email" name="email" required placeholder="Enter your email">
        <button type="submit" name="send_otp">Send OTP</button>
    </form>
<?php elseif ($step == 2): ?>
    <form method="post">
        <h2>Verify OTP</h2>
        <input type="text" name="otp" required placeholder="Enter OTP">
        <button type="submit" name="verify_otp">Verify OTP</button>
    </form>
<?php elseif ($step == 3): ?>
    <form method="post">
        <h2>New Password</h2>
        <input type="password" name="new_password" required placeholder="Enter New Password">
        <button type="submit" name="reset_password">Reset Password</button>
    </form>
<?php endif; ?>

</body>
</html>
