<?php
session_start();
include "connection.php";

// URL parameters check karo
if (!isset($_GET['service']) || !isset($_GET['id']) || !isset($_GET['merchant'])) {
    die("Invalid request. Missing parameters.");
}

$serviceType = $_GET['service']; // Table name
$serviceId = (int)$_GET['id']; // Service ID
$merchantId = (int)$_GET['merchant']; // Merchant ID

// Allowed service tables
$services = [
    'catering_service' => 'catering_id',
    'decoration_service' => 'decoration_id',
    'entertainment_service' => 'entertainment_id',
    'photography_service' => 'photography_id',
    'venue_booking' => 'venue_id'
];

// Check karo ki service type valid hai ya nahi
if (!array_key_exists($serviceType, $services)) {
    die("Invalid service type.");
}

// Dynamic query based on service type
$serviceIdColumn = $services[$serviceType];
$query = "SELECT * FROM $serviceType WHERE $serviceIdColumn = $serviceId AND merchant_id = $merchantId";
$result = $conn->query($query);

// Check karo ki service exist karti hai ya nahi
if ($result->num_rows == 0) {
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
    <h2>Book Now: <?php echo ucfirst(str_replace('_', ' ', $serviceType)); ?></h2>
    
    <form action="submit_booking.php" method="POST">
        <input type="hidden" name="service_type" value="<?php echo $serviceType; ?>">
        <input type="hidden" name="service_id" value="<?php echo $serviceId; ?>">
        <input type="hidden" name="merchant_id" value="<?php echo $merchantId; ?>">
        
        <label>Name:</label>
        <input type="text" name="name" required><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Mobile:</label>
        <input type="text" name="mobile" required><br>

        <label>Event Date:</label>
        <input type="date" name="event_date" required><br>

        <label>Additional Details:</label>
        <textarea name="details"></textarea><br>

        <button type="submit">Confirm Booking</button>
    </form>
</body>
</html>
