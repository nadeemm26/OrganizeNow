<?php
session_start();


$conn = new mysqli('localhost', 'root', '', 'um');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM user WHERE email='$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $email;
            $_SESSION['user_mobile'] = $mobile;
            header('Location: main_home.php');
            exit;
        } else {
            echo "<script>alert('❌Invalid password!');</script>";
        }
    } else {
        echo "<script>alert('❌No user found with this email!');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <link rel="stylesheet" href="../Admin/all_form.css">
</head>
<body>
    <form method="post">
        <h2>User Login</h2>

        <input type="email" name="email" placeholder="Email" required><br>
        
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="login">Login</button>
        <p><a href="forgot_password.php">Forgot Password?</a></p>
       
        <p>Don't have an account? <a href="user_signup.php">Register as User</a> or <a href="../Merchant/merchant_signup.php">Register as Merchant</a></p>
        <p>have an account? <a href="../Merchant/merchant_login.php">Login as Merchant</a></p>
    </form>
</body>
</html>
