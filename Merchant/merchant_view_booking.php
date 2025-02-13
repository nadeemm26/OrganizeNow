<?php
session_start();
include 'connection.php';

// Ensure merchant is logged in
if (!isset($_SESSION['merchant_id'])) {
    header("Location: ../merchant_login.php");
    exit();
}

$merchant_id = $_SESSION['merchant_id'];

// Fetch accepted bookings for this merchant
$query = "SELECT b.id, b.customer_name, b.customer_email, b.customer_mobile, 
                 b.booking_date, b.status, e.service_type, e.performance_duration, 
                 e.price, e.event_image 
          FROM bookings b
          JOIN entertainment_service e ON b.service_id = e.entertainment_id
          WHERE e.merchant_id = ? AND b.status = 'Accepted'";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $merchant_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accepted Bookings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center mb-4">Accepted Bookings</h2>

    <?php if ($result->num_rows > 0) { ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Booking Date</th>
                    <th>Service</th>
                    <th>Duration</th>
                    <th>Price</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['customer_email']; ?></td>
                        <td><?php echo $row['customer_mobile']; ?></td>
                        <td><?php echo $row['booking_date']; ?></td>
                        <td><?php echo $row['service_type']; ?></td>
                        <td><?php echo $row['performance_duration']; ?></td>
                        <td>₹<?php echo number_format($row['price'], 2); ?></td>
                        <td><img src="../Merchant/<?php echo $row['event_image']; ?>" width="100" height="60" alt="Service Image"></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No accepted bookings found.</p>
    <?php } ?>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
