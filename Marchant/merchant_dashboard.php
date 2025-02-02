<?php
session_start();

if (!isset($_SESSION['merchant_id'])) {
    header('Location: merchant_login.php');
    exit;
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: merchant_login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merchant Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['merchant_name']); ?>!</h2>
    <p>This is your dashboard.</p>
    <a href="?logout=true">Logout</a>
</body>
</html>