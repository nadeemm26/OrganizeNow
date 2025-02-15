<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php'); // Redirect to login page
    exit;
}

// Logout URL
$logout_url = 'logout.php';
?>

<html>

<head>
    <title>OrganizeNow-Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="admin_style.css">
    <link rel="stylesheet" href="form.css">
</head>

<body>
    <div class="sidebar">
        <h2>OrganizeNow</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="user_management.php">User Management</a></li>
            <li><a href="merchant_management.php">Merchant Management</a></li>
            <li><a href="event_management.php">Event Management</a></li>
            <li><a href="booking_management.php">Booking Management</a></li>
            <li><a href="payment_management.php">Payment Management</a></li>
            <li><a href="<?php echo $logout_url; ?>">Logout</a></li>
        </ul>
    </div>
    <!-- <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <div class="search-bar">
            <input placeholder="Search..." type="text" />
        </div>
        <div class="user-info">
            <img alt="User Avatar" height="40" src="https://storage.googleapis.com/a1aa/image/e36lXxKb7ayf6USC6uReBg8wMsEnnQRRKftAJ6XNwH6mM5DQB.jpg" width="40" />
            <span>Nadeem Makwana</span>
        </div>
        <div class="clock-container" id="clock"> -->
            <!-- The live clock will display here -->
        <!-- </div> -->
        <!-- <p>Thursday, August 1, 2024 | 9:10 PM</p> -->
    <!-- </div> -->
    <div class="content">