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


// session_start();
if (!isset($_SESSION['merchant_id'])) {
    header("Location: merchant_login.php");
    exit();
}

$merchant_id = $_SESSION['merchant_id'];

$query = "SELECT b.id, b.customer_name, b.customer_email, b.service_type, b.booking_date, b.status 
          FROM bookings b 
          JOIN entertainment_service e ON b.service_id = e.entertainment_id
          WHERE e.merchant_id = ? AND b.status = 'Rejected'";

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
    <h2 class="text-center">Rejected Bookings</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>User Name</th>
                <th>User Email</th>
                <th>Event Name</th>
                <th>Booking Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['customer_name']}</td>
                            <td>{$row['customer_email']}</td>
                            <td>{$row['service_type']}</td>
                            <td>{$row['booking_date']}</td>
                            <td><span class='btn-danger'>{$row['status']}</span></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No rejected bookings found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
