<?php
session_start();
include "connection.php";

// Ensure merchant is logged in
if (!isset($_SESSION['merchant_id'])) {
    die("Access denied.");
}

$booking_id = $_GET['id'];
$status = $_GET['status'];

$query = "UPDATE bookings SET status = '$status' WHERE booking_id = $booking_id";

if ($conn->query($query)) {
    echo "Booking status updated!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
