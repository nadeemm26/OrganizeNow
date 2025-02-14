<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'um');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['change_password'])) {
    $token = $_SESSION['reset_token'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $confirm_password = $_POST['confirm_password'];

    if ($_POST['new_password'] !== $confirm_password) {
        echo "<script>alert('❌ Passwords do not match!');</script>";
    } else {
        $conn->query("UPDATE user SET password='$new_password', reset_token=NULL WHERE reset_token='$token'");
        session_destroy();
        echo "<script>alert('✔ Password changed successfully! Login now.'); window.location='user_login.php';</script>";
    }
}
?>
