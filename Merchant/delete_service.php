<?php
include "connection.php";
session_start();

// Ensure merchant is logged in
if (!isset($_SESSION['merchant_id'])) {
    die("Access denied.");
}

$merchant_id = $_SESSION['merchant_id']; // Get logged-in merchant ID

// Validate and get service type and ID
if (!isset($_GET['service']) || !isset($_GET['id'])) {
    die("Invalid request.");
}

$serviceType = $_GET['service'];
$serviceId = (int)$_GET['id'];

// Define allowed service tables
$allowedServices = ['catering_service', 'decoration_service', 'entertainment_service', 'photography_service', 'venue_booking'];

// Check if the service type is valid
if (!in_array($serviceType, $allowedServices)) {
    die("Invalid service type.");
}

// Delete the record, ensuring it belongs to the logged-in merchant
$query = "DELETE FROM $serviceType WHERE id = ? AND merchant_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $serviceId, $merchant_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<script>alert('✅Service deleted successfully!'); window.location.href='1view_all_service.php?service=$serviceType';</script>";
} else {
    echo "<script>alert('❌Error deleting service or unauthorized action.'); window.location.href='1view_all_service.php?service=$serviceType';</script>";
}

$stmt->close();
$conn->close();
?>
