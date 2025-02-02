<?php
// Database connection parameters
$host = 'localhost'; // Replace with your database host
$dbname = 'um';      // Replace with your database name
$username = 'root';  // Replace with your database username
$password = '';      // Replace with your database password

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    die("Database connection failed: " . $e->getMessage());
}

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get and sanitize inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        http_response_code(400);
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        die("Invalid email address.");
    }

    // Insert data into the database
    try {
        $stmt = $pdo->prepare("INSERT INTO contact_submissions (name, email, message) VALUES (:name, :email, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);

        if ($stmt->execute()) {
            http_response_code(200);
            echo "Form submitted successfully!";
        } else {
            http_response_code(500);
            echo "Failed to save data.";
        }
    } catch (PDOException $e) {
        http_response_code(500);
        die("Database error: " . $e->getMessage());
    }
} else {
    http_response_code(405);
    echo "Method not allowed.";
}
?>
