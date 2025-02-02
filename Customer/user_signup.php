<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'um');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// User signup functionality
if (isset($_POST['signup'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $checkEmail = $conn->query("SELECT id FROM user WHERE email='$email'");
    if ($checkEmail->num_rows > 0) {
        echo "<script>alert('❌Email already exists!');</script>";
    } else {
        $conn->query("INSERT INTO user (name, email, mobile, password) VALUES ('$name', '$email', '$mobile', '$password')");
        echo "<script>alert('✅Signup successful! Please login.');</script>";
        header('Location: user_login.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User SignUp</title>
    <link rel="stylesheet" href="../Admin/all_form.css">
</head>
<body>
    <form onsubmit="return validateSignup()" method="post">
        <h2>User Registration</h2>
        <input type="text" id="name" name="name" placeholder="Enter Name" ><br>
        <input type="email" id="email" name="email" placeholder="Enter Email" ><br>
        <input type="text" id="mobile" name="mobile" placeholder="Enter Mobile Number" ><br>
        <input type="password" id="password" name="password" placeholder="Enter One Time Password" ><br>
        <button type="submit" name="signup">Signup</button>
        <p>Already have an account? <a href="user_login.php">Login as User</a></p>
        <p>Are you a merchant? <a href="../Merchant/merchant_signup.php">Register as Merchant</a></p>
    </form>
    <script>
        function validateSignup() {
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var mobile = document.getElementById('mobile').value;
            var password = document.getElementById('password').value;

            if (name === "" || email === "" || mobile === "" || password === "") {
                alert("Please fill in all fields.");
                return false;
            }

            // mobile number (10 digits)
            if (mobile.length !== 10 || isNaN(mobile)) {
                alert("Please enter a valid 10-digit mobile number.");
                return false;
            }

            // email validation
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            return true; 
        }
    </script>
</body>
</html>