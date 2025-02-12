<?php
    include 'user_navbar.php';
?>
<?php
// include 'sidebaruser.php';
include 'connection.php';

$user_id = $_SESSION['user_id']; // Logged-in user's ID
$sql = "SELECT * FROM bookings WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookings</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>My Bookings</h2>
        <table border="1">
            <tr>
                <th>Service Name</th>
                <th>Booking Date</th>
                <th>Guests</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['booking_date']; ?></td>
                    <td><?php echo $row['guest_count']; ?></td>
                    <td>₹<?php echo $row['total_price']; ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                    <td>
                        <?php if ($row['status'] == 'Accepted' && $row['payment_status'] == 'Pending') { ?>
                            <a href="payment.php?id=<?= $row['id'] ?>">Proceed to Payment</a>
                        <?php } elseif ($row['status'] == 'Rejected') {
                            echo "Booking Rejected";
                        } elseif ($row['payment_status'] == 'Paid') {
                            echo "Payment Completed";
                        } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>

<?php
include 'connection.php';
$user_id = $_SESSION['user_id']; // Logged-in user ID

$sql = "SELECT * FROM bookings WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<table border="1">
    <tr>
        <th>Service Name</th>
        <th>Merchant</th>
        <th>Booking Date</th>
        <th>Total Price</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo $row['merchant_id']; ?></td>
            <td><?php echo $row['booking_date']; ?></td>
            <td>₹<?php echo $row['total_price']; ?></td>
            <td><?php echo ucfirst($row['status']); ?></td>
            <td>
                <?php if ($row['status'] == 'Accepted') { ?>
                    <a href="payment.php?booking_id=<?= $row['id'] ?>">Proceed to Payment</a>
                <?php } else {
                    echo "Waiting for Approval";
                } ?>
            </td>
        </tr>
    <?php } ?>
</table>
<?php
include 'connection.php';
// session_start();

$user_id = $_SESSION['user_id'];

$sql = "SELECT payment.*, bookings.category, bookings.booking_date 
        FROM payment 
        JOIN bookings ON payment.booking_id = bookings.id 
        WHERE payment.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Payments</title>
</head>
<body>
    <h2>My Payments</h2>
    <table border="1">
        <tr>
            <th>Service Name</th>
            <th>Booking Date</th>
            <th>Amount</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Payment Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['category']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td>₹<?php echo $row['amount']; ?></td>
                <td><?php echo $row['payment_method']; ?></td>
                <td><?php echo ucfirst($row['status']); ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

