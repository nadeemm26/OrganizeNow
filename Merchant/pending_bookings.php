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

$merchant_id = $_SESSION['merchant_id']; // Ensure merchant is logged in

$query = "SELECT b.id, b.customer_name, b.customer_email, b.customer_mobile, b.booking_date, 
                 b.service_type, b.status, e.service_type AS service_name
          FROM bookings b
          JOIN entertainment_service e ON b.service_id = e.entertainment_id
          WHERE e.merchant_id = ? AND b.status = 'Pending'";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $merchant_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../Merchant/css_for_table.css">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">Pending Bookings</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Booking Date</th>
                <th>Service</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['customer_email']; ?></td>
                    <td><?php echo $row['customer_mobile']; ?></td>
                    <td><?php echo $row['booking_date']; ?></td>
                    <td><?php echo $row['service_name']; ?></td>
                    <td><strong><?php echo $row['status']; ?></strong></td>
                    <td>
                        <a href="update_booking_status.php?id=<?php echo $row['id']; ?>&status=Accepted" class="btn btn-success btn-sm">Accept</a>
                        <a href="update_booking_status.php?id=<?php echo $row['id']; ?>&status=Rejected" class="btn btn-danger btn-sm">Reject</a>
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