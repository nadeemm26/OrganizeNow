<?php
session_start();
include "connection.php";

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please login first.");
}

// Check if required parameters exist
if (!isset($_GET['service_type']) || !isset($_GET['service_id']) || !isset($_GET['merchant_id'])) {
    die("Invalid request. Missing parameters.");
}

// Get service details from URL
$serviceType = $_GET['service_type'];
$serviceId = (int) $_GET['service_id'];  // Convert to integer for safety
$merchantId = (int) $_GET['merchant_id'];

// Validate service type to prevent SQL injection
$allowedServices = ['catering_service', 'decoration_service', 'entertainment_service', 'photography_service', 'venue_booking'];
if (!in_array($serviceType, $allowedServices)) {
    die("Invalid service type.");
}

// Fetch service details
$query = "SELECT * FROM $serviceType WHERE {$serviceType}_id = $serviceId";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    die("Service not found.");
}

$service = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Service</title>
</head>
<body>
    <h2>Book Service: <?php echo htmlspecialchars($service[array_keys($service)[1]]); ?></h2>
    <form action="process_booking.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
        <input type="hidden" name="merchant_id" value="<?php echo $merchantId; ?>">
        <input type="hidden" name="service_type" value="<?php echo $serviceType; ?>">
        <input type="hidden" name="service_id" value="<?php echo $serviceId; ?>">
        
        <label>Event Date:</label>
        <input type="date" name="event_date" required>
        
        <label>Your Name:</label>
        <input type="text" name="contact_name" required>
        
        <label>Your Email:</label>
        <input type="email" name="contact_email" required>
        
        <label>Your Phone:</label>
        <input type="text" name="contact_phone" required>
        
        <button type="submit">Submit Booking</button>
    </form>
</body>
</html>
<?php $conn->close(); ?>
