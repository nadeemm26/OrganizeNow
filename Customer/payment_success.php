<?php
session_start();
require('connection.php');

if (!isset($_SESSION['user_id'])) {
    echo "<div class='error-message'>User Not Logged In!</div>";
    exit();
}

if (!isset($_GET['payment_id']) || !isset($_GET['order_id']) || !isset($_GET['booking_id'])) {
    echo "<div class='error-message'>Invalid Request!</div>";
    exit();
}

$payment_id = $_GET['payment_id'];
$order_id = $_GET['order_id'];
$booking_id = $_GET['booking_id'];
$user_id = $_SESSION['user_id'];

// 🔹 Check if Payment Already Exists
$check_payment = "SELECT * FROM payments WHERE payment_id = ?";
$stmt = $conn->prepare($check_payment);
$stmt->bind_param("s", $payment_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // 🔹 Get Booking Details
    $query = "SELECT merchant_id, total_price FROM booking2 WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $booking_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<div class='error-message'>Booking Not Found!</div>";
        exit();
    }

    $booking = $result->fetch_assoc();
    $amount_paid = $booking['total_price'];
    $merchant_id = $booking['merchant_id'];
    $payment_method = "Razorpay"; // 🔹 Default payment method
    $status = "Paid"; // 🔹 Mark as successful

    // 🔹 Insert Payment Data into Database
    $insert_payment = "INSERT INTO payments (booking_id, merchant_id, user_id, payment_id, order_id, amount_paid, payment_gateway, payment_status) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_payment);
    $stmt->bind_param("iiissdss", $booking_id, $merchant_id, $user_id, $payment_id, $order_id, $amount_paid, $payment_method, $status);
    $stmt->execute();

    // 🔹 Update Booking Status to "Paid"
    $update_booking = "UPDATE booking2 SET payment_status = 'Paid' WHERE id = ?";
    $stmt = $conn->prepare($update_booking);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();

    // 🔹 Notify Merchant (Optional: Send Email or Add Notification in Merchant Dashboard)
}

// 🔹 Fetch Payment Details for Display
$query = "SELECT p.*, b.service_name, b.booking_date, b.total_price, b.payment_status, b.merchant_id 
          FROM payments p 
          JOIN booking2 b ON p.booking_id = b.id 
          WHERE p.payment_id = ? AND b.user_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("si", $payment_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<div class='error-message'>Payment Not Found!</div>";
    exit();
}

$payment = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 30px;
            text-align: center;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            width: 400px;
        }
        .success-icon {
            font-size: 50px;
            color: green;
        }
        .success-message {
            font-size: 22px;
            color: #333;
            margin-top: 10px;
        }
        .details {
            margin-top: 20px;
            text-align: left;
            font-size: 16px;
        }
        .details strong {
            color: #555;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: green;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background: darkgreen;
        }
        .error-message {
            color: red;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="success-icon">✅</div>
    <div class="success-message">Payment Successful!</div>
    <div class="details">
        <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($payment['booking_id']); ?></p>
        <p><strong>Event:</strong> <?php echo htmlspecialchars($payment['service_name']); ?></p>
        <p><strong>Booking Date:</strong> <?php echo htmlspecialchars($payment['booking_date']); ?></p>
        <p><strong>Total Paid:</strong> ₹<?php echo number_format($payment['amount_paid'], 2); ?></p>
        <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment['payment_gateway']); ?></p>
        <p><strong>Merchant ID:</strong> <?php echo htmlspecialchars($payment['merchant_id']); ?></p>
        <p><strong>Status:</strong> <?php echo ucfirst(htmlspecialchars($payment['payment_status'])); ?></p>
    </div>
    <a href="user_event.php" class="btn">Back to Dashboard</a>
</div>

</body>
</html>
