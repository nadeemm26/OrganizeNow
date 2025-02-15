<?php
session_start();
include 'user_navbar.php';
include 'connection.php';

if (!isset($_SESSION['user_email'])) {
    echo "<script>alert('Please log in first!'); window.location.href='user_login.php';</script>";
    exit();
}

if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid request!'); window.history.back();</script>";
    exit();
}

$booking_id = $_GET['id'];
$user_email = $_SESSION['user_email'];

// Fetch booking details
$query = "SELECT b.id, b.customer_name, b.customer_email, b.customer_mobile, 
                 b.booking_date, b.status, e.service_type, e.performance_duration, 
                 e.price, e.event_image 
          FROM bookings b
          JOIN entertainment_service e ON b.service_id = e.id
          WHERE b.id = ? AND b.customer_email = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("is", $booking_id, $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('No booking found!'); window.history.back();</script>";
    exit();
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Booking Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">Booking Details</h2>
    <div class="card">
        <img src="../Merchant/<?php echo $row['event_image']; ?>" class="card-img-top" alt="Service Image">
        <div class="card-body">
            <h5 class="card-title"><?php echo $row['service_type']; ?></h5>
            <p><strong>Customer Name:</strong> <?php echo $row['customer_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $row['customer_email']; ?></p>
            <p><strong>Mobile:</strong> <?php echo $row['customer_mobile']; ?></p>
            <p><strong>Booking Date:</strong> <?php echo $row['booking_date']; ?></p>
            <p><strong>Duration:</strong> <?php echo $row['performance_duration']; ?></p>
            <p><strong>Price:</strong> ₹<?php echo number_format($row['price'], 2); ?></p>
            <p><strong>Status:</strong> <span class="text-success"><?php echo $row['status']; ?></span></p>
            <a href="user_event.php" class="btn btn-primary">Back to Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
