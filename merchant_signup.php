<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'um');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Merchant signup functionality
if (isset($_POST['signup'])) {
    $name = $conn->real_escape_string($_POST['businessname']);
    // $type = $conn->real_escape_string($_POST['type']);
    $details = $conn->real_escape_string($_POST['businessdetails']);
    $email = $conn->real_escape_string($_POST['email']);
    $mobile = $conn->real_escape_string($_POST['merchantmobile']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $checkEmail = $conn->query("SELECT merchant_id FROM merchant WHERE email='$email'");
    if ($checkEmail->num_rows > 0) {
        echo "<script>alert('❌Email already exists!');</script>";
    } else {
        $conn->query("INSERT INTO merchant (name, details, email, mobile, password) VALUES ('$name', '$details', '$email', '$mobile', '$password')");
        echo "<script>alert('✅Signup successful! Please login.');</script>";
        header('Location: merchant_login.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merchant SignUp</title>
    <link rel="stylesheet" href="../OrganizeNow/Admin/all_form.css">
</head>

<body>
    <form onsubmit="return validateSignup()" method="post">
        <h2>Merchant Registration</h2>
        <input type="text" id="businessname" name="businessname" placeholder="Business Name:"><br>

        <!-- <label>Business Type:</label>
        <input type="radio" name="type" id="catring" value="catring">
        <label for="catring">Catering</label>
        <input type="radio" name="type" id="decoration" value="decoration">
        <label for="decoration">Decoration</label>
        <input type="radio" name="type" id="photo" value="photo">
        <label for="photo">Photo</label>
        <input type="radio" name="type" id="venue" value="venue">
        <label for="venue">Venue</label>
        <input type="radio" name="type" id="other" value="other">
        <label for="other">Other</label><br> -->

        <input type="text" id="businessdetails" name="businessdetails" placeholder="Business Details:"><br>

        <input type="email" id="email" name="email" placeholder="Business Email:"><br>

        <input type="number" id="merchantmobile" name="merchantmobile" placeholder="Mobile:"><br>

        <input type="password" id="password" name="password" placeholder="Password:"><br>

        <button type="submit" name="signup">SignUp</button>
        <p>Are you a user? <a href="user_signup.php">Register as User</a></p>
        <p>Already have an account? <a href="merchant_login.php">Login as Merchant</a></p>
    </form>
    <script>
        function validateSignup() {
            var name = document.getElementById('businessname').value;
            // var type = document.getElementsByName('type').value;
            var details = document.getElementById('businessdetails').value;
            var email = document.getElementById('email').value;
            var mobile = document.getElementById('merchantmobile').value;
            var password = document.getElementById('password').value;

            if (name === "" || details ==="" || email === "" || mobile === "" || password === "") {
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