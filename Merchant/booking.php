<?php
include 'sidebarmerchant.php';
include 'connection.php';
// session_start(); // Ensure session is started

$merchant_id = $_SESSION['merchant_id']; // Logged-in merchant's ID

$sql = "SELECT * FROM bookings WHERE merchant_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $merchant_id);
$stmt->execute();
$result = $stmt->get_result();

// 🛠 Fix: Handle the POST Request for Booking Action (Accept/Reject)
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $booking_id = $_POST['id'];
    $status = $_POST['status']; // Accepted or Rejected

    $update_sql = "UPDATE bookings SET status = ? WHERE id = ? AND merchant_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sii", $status, $booking_id, $merchant_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Booking $status successfully!');window.location='booking.php';</script>";
    } else {
        echo "<script>alert('Error updating booking!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Manage Bookings</h2>
        <table border="1">
            <tr>
                <th>Service Name</th>
                <th>Customer Name</th>
                <th>Booking Date</th>
                <th>Guests</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['user_name']; ?></td>
                    <td><?php echo $row['booking_date']; ?></td>
                    <td><?php echo $row['guest_count']; ?></td>
                    <td>₹<?php echo $row['total_price']; ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                    <td>
                        <?php if ($row['status'] == 'Pending') { ?>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" name="status" value="Accepted">Accept</button>
                                <button type="submit" name="status" value="Rejected">Reject</button>
                            </form>
                        <?php } else {
                            echo ucfirst($row['status']);
                        } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
