<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'um');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Merchant login functionality
if (isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM merchant WHERE email='$email'");
    if ($result->num_rows > 0) {
        $merchant = $result->fetch_assoc();
        if (password_verify($password, $merchant['password'])) {
            $_SESSION['merchant_id'] = $merchant['merchant_id'];
            $_SESSION['merchant_name'] = $merchant['name'];
            header('Location: ../OrganizeNow/Merchant/merchant_home.php');
            exit;
        } else {
            echo "<script>alert('❌ Invalid password!');</script>";
        }
    } else {
        echo "<script>alert('❌ No merchant found with this email!');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merchant Login</title>
    <link rel="stylesheet" href="../OrganizeNow/Admin/all_form.css">
</head>
<body>
    <form method="post">
        <h2>Merchant Login</h2>
        <!-- <label for="email">Email:</label> -->
        <input type="email" id="email" name="email" placeholder="Email:"><br>

        <!-- <label for="password">Password:</label> -->
        <input type="password" id="password" name="password" placeholder="Password:"><br>

        <button type="submit" name="login">Login</button>
        <p><a href="./Merchant/forgot_password.php">Forgot Password?</a></p>
        <p>Don't have an account? <a href="merchant_signup.php">Register as Merchant</a> or <a href="user_signup.php">Register as User</a></p>
        <p>have an account? <a href="index.php">Login as User</a></p>
    </form>
</body>
</html>