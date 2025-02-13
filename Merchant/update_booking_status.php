<?php
include 'connection.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $booking_id = $_GET['id'];
    $status = $_GET['status'];

    $query = "UPDATE bookings SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $booking_id);

    if ($stmt->execute()) {
        echo "<script>alert('Booking status updated successfully!'); window.location.href='merchant_dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to update status!'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request!'); window.history.back();</script>";
}
?>
