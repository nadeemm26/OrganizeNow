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

$sql = "SELECT payments.*, booking2.service_type,booking2.service_name, booking2.booking_date, user.name AS user_name 
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
    <style>
        .container {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #28a745;
            color: white;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-delete:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <h2>Received Payments</h2>
    <table border="1">
        <tr>
            <th>Customer Name</th>
            <th>Service Name</th>
            <th>Service Type</th>
            <th>Booking Date</th>
            <th>Amount</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Payment Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['user_name']; ?></td>
                <td><?php echo $row['service_name']; ?></td>
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
