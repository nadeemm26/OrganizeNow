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
    $businessName = $_POST['name'];
    $businessEmail = $_POST['email'];
    $password = $_POST['password']; 
    

    // Insert data into Merchant table
    $sql = "INSERT INTO merchant (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $businessName, $businessEmail, $password);

    if ($stmt->execute()) {
        echo "Merchant registration successful!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
