<?php
include "connection.php";
include "admin.php";

$successMsg = $errorMsg = "";

if (isset($_POST['submit'])) {   
    $name = trim($_POST['name']);
    $type = $_POST['type'];
    $details = trim($_POST['details']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $password = trim($_POST['password']);

    // Basic validation
    if (empty($name) || empty($type) || empty($details) || empty($email) || empty($mobile) || empty($password)) {
        $errorMsg = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = "Invalid email format!";
    } elseif (!preg_match("/^[0-9]{10}$/", $mobile)) {
        $errorMsg = "Invalid mobile number! Must be 10 digits.";
    } elseif (strlen($password) < 6) {
        $errorMsg = "Password must be at least 6 characters long!";
    } else {
        // Check if email already exists
        $checkEmail = "SELECT * FROM `merchant` WHERE email='$email'";
        $result = mysqli_query($con, $checkEmail);
        
        if (mysqli_num_rows($result) > 0) {
            $errorMsg = "Email already registered!";
        } else {
            // Hash the password for security
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert merchant data
            $insertQuery = "INSERT INTO `merchant` (id, name, type, details, email, mobile, password) 
                            VALUES (NULL, '$name', '$type', '$details', '$email', '$mobile', '$hashedPassword')";

            if (mysqli_query($con, $insertQuery)) {
                $successMsg = "New merchant created successfully!";
            } else {
                $errorMsg = "Error: " . mysqli_error($con);
            }
        }
    }
}
?>

<h1>Add New Merchant</h1>

<!-- Success/Error Message Display -->
<?php if (!empty($successMsg)) echo "<p style='color: green;'>$successMsg</p>"; ?>
<?php if (!empty($errorMsg)) echo "<p style='color: red;'>$errorMsg</p>"; ?>

<form method="POST">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" name="name" required>
    </div>
    <div class="form-group">
        <label for="type">Type:</label>
        <select name="type" required>
            <option value="Catering">Catering</option>
            <option value="Decoration">Decoration</option>
            <option value="Photo">Photo</option>
            <option value="Venue">Venue</option>
            <option value="Other">Other</option>
        </select>
    </div>
    <div class="form-group">
        <label for="details">Details:</label>
        <textarea name="details" required></textarea>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="mobile">Mobile:</label>
        <input type="number" name="mobile" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" required>
    </div>
    <div class="form-group">
        <button type="submit" name="submit">Submit</button>
        <a href="merchant_management.php"><button type="button">Cancel</button></a>
    </div>
</form>
</body>
</html>
