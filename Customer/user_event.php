<?php
session_start();
include 'user_navbar.php';
include 'connection.php';

if (!isset($_SESSION['user_email'])) {
    echo "<script>alert('Please log in first!'); window.location.href='user_login.php';</script>";
    exit();
}

$user_email = $_SESSION['user_email'];

$query = "SELECT id, service_type, booking_date, status FROM bookings WHERE customer_email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Dashboard - My Bookings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">My Bookings</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Service</th>
                <th>Booking Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['service_type']; ?></td>
                    <td><?php echo $row['booking_date']; ?></td>
                    <td>
                        <strong>
                            <?php 
                            if ($row['status'] == 'Pending') {
                                echo '<span class="text-warning">Pending</span>';
                            } elseif ($row['status'] == 'Accepted') {
                                echo '<span class="text-success">Accepted</span>';
                            } else {
                                echo '<span class="text-danger">Rejected</span>';
                            }
                            ?>
                        </strong>
                    </td>
                    <td>
                        <?php if ($row['status'] == 'Accepted') { ?>
                            <a href="view_booking.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">View Details</a>
                        <?php } else {
                            echo "-"; // No action for pending/rejected bookings
                        } ?>
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



<?php
// session_start();
include 'connection.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's accepted bookings
$query = "SELECT b.id, b.service_id, b.booking_date, b.status, b.payment_status, 
                 e.service_type, e.price 
          FROM bookings b
          JOIN entertainment_service e ON b.service_id = e.entertainment_id
          WHERE b.user_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center mb-4">My Bookings</h2>

    <?php if ($result->num_rows > 0) { ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th>Booking Date</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['service_type']; ?></td>
                        <td><?php echo $row['booking_date']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['payment_status']; ?></td>
                        <td>
                            <?php if ($row['status'] == 'Accepted' && $row['payment_status'] == 'Pending') { ?>
                                <a href="payment.php?booking_id=<?php echo $row['id']; ?>&amount=<?php echo $row['price']; ?>" class="btn btn-success">Pay Now</a>
                            <?php } else {
                                echo "Paid";
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No bookings found.</p>
    <?php } ?>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>











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
                        <?php if ($row['status'] == 'Accepted' && $row['status'] == 'Pending') { ?>
                            <a href="payment.php?id=<?= $row['id'] ?>">Proceed to Payment</a>
                        <?php } elseif ($row['status'] == 'Rejected') {
                            echo "Booking Rejected";
                        } elseif ($row['status'] == 'Paid') {
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

