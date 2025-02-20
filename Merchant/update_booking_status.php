<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id']) && isset($_POST['action'])) {
    $booking_id = $_POST['booking_id'];
    $action = $_POST['action'];
    
    if ($action == "accept") {
        $status = "Accepted";
    } elseif ($action == "reject") {
        $status = "Rejected";
    } else {
        header("Location: merchant_bookings.php");
        exit();
    }

    // Update booking status
    $query = "UPDATE booking2 SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $booking_id);

    if ($stmt->execute()) {
        echo "<script>alert('Booking status updated!'); window.location='pending_bookings.php';</script>";
    } else {
        echo "<script>alert('Error updating status. Try again.'); window.location='pending_bookings.php';</script>";
    }
} else {
    header("Location: pending_bookings.php");
    exit();
}
?>
