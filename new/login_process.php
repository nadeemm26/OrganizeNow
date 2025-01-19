<?php
// Database connection details
$servername = "localhost";
$username = "root";  // your database username
$password = "";      // your database password
$dbname = "um";  // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // First check in the user table
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, verify password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "User login successful!";
        } else {
            echo "Incorrect password for user!";
        }
    } else {
        // Check in the merchant table
        $sql = "SELECT * FROM merchant WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Merchant found, verify password
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                echo "Merchant login successful!";
            } else {
                echo "Incorrect password for merchant!";
            }
        } else {
            echo "No account found with this email!";
        }
    }

    $stmt->close();
}

$conn->close();
?>
