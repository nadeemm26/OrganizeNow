<?php

include "sidebarmerchant.php";

?>
<div class="header">
    <h1>
        Booking Of User
    </h1><hr>
</div>
<?php
// session_start();
include "connection.php";

// Ensure merchant is logged in
if (!isset($_SESSION['merchant_id'])) {
    die("Access denied. Please login first.");
}

$merchant_id = $_SESSION['merchant_id'];
$query = "SELECT * FROM bookings WHERE merchant_id = $merchant_id";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Bookings</title>
</head>
<body>
    <h2>My Bookings</h2>
    <table border="1">
        <tr>
            <th>User Name</th>
            <th>Service Type</th>
            <th>Event Date</th>
            <th>Contact</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['contact_name']; ?></td>
                <td><?php echo ucfirst(str_replace('_', ' ', $row['service_type'])); ?></td>
                <td><?php echo $row['event_date']; ?></td>
                <td><?php echo $row['contact_email'] . "<br>" . $row['contact_phone']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <a href="update_booking.php?id=<?php echo $row['booking_id']; ?>&status=Accepted">Accept</a> |
                    <a href="update_booking.php?id=<?php echo $row['booking_id']; ?>&status=Rejected">Reject</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>
