<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'um');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $result = $conn->query("SELECT * FROM merchant WHERE reset_token='$token'");

    if ($result->num_rows > 0) {
        $_SESSION['reset_token'] = $token;
    } else {
        die("Invalid or expired token!");
    }
} else {
    die("No token provided!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="../Admin/all_form.css">
</head>
<body>
    <form method="post" action="new_password.php">
        <h2>Reset Password</h2>
        <input type="password" name="new_password" placeholder="Enter new password" required><br>
        <input type="password" name="confirm_password" placeholder="Confirm new password" required><br>
        <button type="submit" name="change_password">Change Password</button>
    </form>
</body>
</html>
