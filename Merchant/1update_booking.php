<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['id'];
    $action = $_POST['action']; // "Accepted" ya "Rejected"

    // Booking status update query
    $sql = "UPDATE bookings SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $action, $booking_id);
    
    if ($stmt->execute()) {
        echo "Booking status updated successfully!";
        header("Location: booking.php"); // Redirect back to dashboard
        exit();
    } else {
        echo "Error updating booking: " . $conn->error;
    }
}
?>
