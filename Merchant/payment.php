<?php

include "sidebarmerchant.php";

?>
<div class="header">
    <h1>
        Payments Of Booking 
    </h1>
    <hr>
</div>
<?php
include 'connection.php';
// session_start();

$merchant_id = $_SESSION['merchant_id'];

$sql = "SELECT payments.*, booking2.service_type, booking2.booking_date, user.name AS user_name 
        FROM payments 
        JOIN booking2 ON payments.booking_id = booking2.id 
        JOIN user ON payments.user_id = user.user_id
        WHERE payments.merchant_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $merchant_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Received Payments</title>
</head>
<body>
    <h2>Received Payments</h2>
    <table border="1">
        <tr>
            <th>Customer Name</th>
            <th>Service Name</th>
            <th>Booking Date</th>
            <th>Amount</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Payment Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['user_name']; ?></td>
                <td><?php echo $row['service_type']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td>₹<?php echo $row['amount_paid']; ?></td>
                <td><?php echo $row['payment_gateway']; ?></td>
                <td><?php echo ucfirst($row['payment_status']); ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
