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
    header("Location: login.php");
    exit();
}

$merchant_id = $_SESSION['merchant_id'];

// Fetch accepted bookings for this merchant
$query = "SELECT * FROM booking2 WHERE merchant_id = ? AND status = 'Accepted'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $merchant_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .container {
            /* width: 80%;
            margin: auto;
            background: #f9f9f9;
            padding: 20px; */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }h2{
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
    </style>
</head>
<body>

<div class="container">
    <h2>Confirmed Bookings</h2>
    <table>
        <tr>
            <th>Customer Name</th>
            <th>Customer Email</th>
            <th>Customer Mobile</th>
            <th>Service Type</th>
            <th>Service Name</th>
            <th>Booking Date</th>
            <th>Guests</th>
            <th>Days</th>
            <th>Total Price</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row['customer_email']; ?></td>
                <td><?php echo $row['customer_mobile']; ?></td>
                <td><?php echo $row['service_type']; ?></td>
                <td><?php echo $row['service_name']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td><?php echo $row['guest_count']; ?></td>
                <td><?php echo $row['num_days']; ?></td>
                <td>₹<?php echo number_format($row['total_price'], 2); ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
