<?php
include "connection.php";

if (isset($_GET['id'])) {
    $payment_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM payments WHERE id = ?");
    $stmt->bind_param("i", $payment_id);

    if ($stmt->execute()) {
        echo "<script>alert('Payment record deleted successfully.'); window.location.href='payment_management.php';</script>";
    } else {
        echo "<script>alert('Error deleting payment record.'); window.history.back();</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
$conn->close();
?>
