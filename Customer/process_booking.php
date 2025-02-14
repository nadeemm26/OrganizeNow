<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $service_id = $_POST['service_id'];
    $service_type = $_POST['service_type'];
    $booking_date = $_POST['booking_date'];
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_mobile = $_POST['customer_mobile'];
    $user_id = $_SESSION['user_id'];

    // Validate fields
    if (empty($service_id) || empty($service_type) || empty($booking_date) || empty($customer_name) || empty($customer_email) || empty($customer_mobile)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit();
    }

    // Insert booking into database
    $query = "INSERT INTO bookings (service_id, service_type, booking_date, customer_name, customer_email, customer_mobile, status , user_id) 
              VALUES (?, ?, ?, ?, ?, ?, 'Pending' ,?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssssi", $service_id, $service_type, $booking_date, $customer_name, $customer_email, $customer_mobile, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Booking request sent successfully!'); window.location.href='user_event.php';</script>";
    } else {
        echo "<script>alert('Booking failed! Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request!'); window.location.href='user_about.php';</script>";
}
?>
