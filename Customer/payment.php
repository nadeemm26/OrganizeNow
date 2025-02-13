<?php
include 'user_navbar.php';
include 'connection.php';
// session_start();

if (!isset($_GET['booking_id'])) {
    die("Invalid request.");
}

$booking_id = $_GET['booking_id'];
$user_id = $_SESSION['user_id']; 

// Fetch booking details
$sql = "SELECT * FROM bookings WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    die("Booking not found.");
}

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment_method'];
    $amount = $booking['total_price'];
    
    // Insert into payments table
    $sql = "INSERT INTO payment (booking_id, user_id, merchant_id, amount, payment_method, status) 
            VALUES (?, ?, ?, ?, ?, 'Completed')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiids", $booking_id, $user_id, $booking['merchant_id'], $amount, $payment_method);
    
    if ($stmt->execute()) {
        echo "<script>alert('Payment Successful!'); window.location.href='user_event.php';</script>";
    } else {
        echo "<script>alert('Payment Failed! Try Again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment</title>
</head>
<body>
    <h2>Payment for <?php echo $booking['category']; ?></h2>
    <p>Booking Date: <?php echo $booking['booking_date']; ?></p>
    <p>Total Price: ₹<?php echo $booking['total_price']; ?></p>

    <form method="POST">
        <label>Select Payment Method:</label>
        <select name="payment_method" required>
            <option value="Card">Card</option>
            <option value="UPI">UPI</option>
            <option value="Net Banking">Net Banking</option>
        </select>
        <button type="submit">Make Payment</button>
    </form>
</body>
</html>
