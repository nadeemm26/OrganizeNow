<?php
session_start();
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serviceType = $_POST['service_type'];
    $serviceId = (int)$_POST['service_id'];
    $merchantId = (int)$_POST['merchant_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $eventDate = $_POST['event_date'];
    $details = $_POST['details'];

    // Insert booking into database
    $query = "INSERT INTO bookings (service_type, service_id, merchant_id, user_name, email, mobile, event_date, details, status) 
              VALUES ('$serviceType', '$serviceId', '$merchantId', '$name', '$email', '$mobile', '$eventDate', '$details', 'Pending')";

    if ($conn->query($query)) {
        echo " ✅ Booking Request Submitted Successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
