<?php
session_start();
if (!isset($_SESSION['merchant_id'])) {
    header('Location: merchant_login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrganizeNow-Merchant</title>
    <link rel="stylesheet" href="sidebarmerchant.css">
</head>

<body>
    <div class="sidebar">
        <h1>OrganizeNow</h1>
        <div class="option">
            <a href="merchant_home.php">Home</a>
            <a href="myevent.php">My Events</a>
            <a href="booking.php">Booking of User</a>
            <a href="payment.php">Payment</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="main-content">