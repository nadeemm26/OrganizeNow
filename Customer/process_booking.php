<?php
session_start();
include "connection.php";

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Access denied.");
}

// Get form data
$user_id = $_POST['user_id'];
$merchant_id = $_POST['merchant_id'];
$service_type = $_POST['service_type'];
$service_id = $_POST['service_id'];
$event_date = $_POST['event_date'];
$contact_name = $_POST['contact_name'];
$contact_email = $_POST['contact_email'];
$contact_phone = $_POST['contact_phone'];

// Insert booking request into database
$query = "INSERT INTO bookings (user_id, merchant_id, service_type, service_id, event_date, contact_name, contact_email, contact_phone, status)
          VALUES ('$user_id', '$merchant_id', '$service_type', '$service_id', '$event_date', '$contact_name', '$contact_email', '$contact_phone', 'Pending')";

if ($conn->query($query)) {
    echo "Booking request submitted successfully!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
