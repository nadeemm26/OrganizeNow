<?php
include 'sidebarmerchant.php';
include 'connection.php';
?>

<div class="header">
    <h1>Bookings</h1>
    <hr>
</div>
<!-- event 3 button -->
<div class="event-button">
    <div class="add-event">
        <button><a href="pending_bookings.php">Pending Bookings</a></button>
    </div>
    <div class="add-service">
        <button ><a href="accepted_bookings.php">Accepted Bookings</a></button>
    </div>
    <div class="view-event">
        <button><a href="rejected_bookings.php">Rejected Bookings</a></button>
    </div>
</div>
<?php

if (!isset($_SESSION['merchant_id'])) {
    echo "<script>alert('Please log in first!'); window.location.href='merchant_login.php';</script>";
    exit();
}

// $merchant_email = $_SESSION['merchant_email'];
$merchant_id = $_SESSION['merchant_id']; // Ensure merchant is logged in

$query = "SELECT b.id, b.customer_name, b.customer_email, b.customer_mobile, 
                 b.booking_date, b.status, e.service_type, e.performance_duration, 
                 e.price, e.event_image 
          FROM bookings b
          JOIN entertainment_service e ON b.service_id = e.id
          WHERE e.merchant_id = ? AND b.status = 'Accepted'";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $merchant_id);

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Merchant Dashboard - Accepted Bookings</title>
    <link rel="stylesheet" href="../Merchant/css_for_table.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> -->
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">Accepted Bookings</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Service</th>
                <th>Booking Date</th>
                <th>Price</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['customer_email']; ?></td>
                    <td><?php echo $row['customer_mobile']; ?></td>
                    <td><?php echo $row['service_type']; ?></td>
                    <td><?php echo $row['booking_date']; ?></td>
                    <td>₹<?php echo number_format($row['price'], 2); ?></td>
                    <td>
                        <a href="merchant_view_booking.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">View Details</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
