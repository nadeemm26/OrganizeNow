<?php
include 'user_navbar.php';
include 'connection.php';
require '../razorpay-php/Razorpay.php'; // 🔹 Razorpay SDK Include

use Razorpay\Api\Api;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$key_id = "rzp_test_V1lMsadicHcdXy"; // 🔹 Replace with your Razorpay Key ID
$key_secret = "MBTWmcyoqijBHZLnZTyFalWr"; // 🔹 Replace with your Razorpay Secret

$api = new Api($key_id, $key_secret);

if (!isset($_GET['booking_id'])) {
    echo "Invalid Booking ID!";
    exit();
}

$booking_id = $_GET['booking_id'];

// 🔹 Get Booking Details from Database
$query = "SELECT * FROM booking2 WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $booking_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Booking Not Found!";
    exit();
}

$booking = $result->fetch_assoc();
$amount = $booking['total_price'] * 100; // 🔹 Convert to paise (₹1000 = 100000)

// 🔹 Razorpay Order Create
$orderData = [
    'receipt'         => strval($booking_id),  // 🔹 Ensure receipt is string
    'amount'          => $amount,  // 🔹 Amount in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // 🔹 Auto capture payment
];

$order = $api->order->create($orderData);
$order_id = $order['id']; // 🔹 Razorpay Order ID
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pay Now</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <h2>Payment for Booking #<?php echo $booking_id; ?></h2>
    <p>Total Amount: ₹<?php echo number_format($booking['total_price'], 2); ?></p>
    
    <button id="payBtn">Pay Now</button>

    <script>
        var options = {
            "key": "<?php echo $key_id; ?>", 
            "amount": "<?php echo $amount; ?>",
            "currency": "INR",
            "name": "Event Management",
            "description": "Booking Payment",
            "order_id": "<?php echo $order_id; ?>",
            "handler": function (response) {
                window.location.href = "payment_success.php?payment_id=" + response.razorpay_payment_id + "&order_id=" + response.razorpay_order_id + "&booking_id=<?php echo $booking_id; ?>";
            },
            "prefill": {
                "name": "<?php echo $_SESSION['user_name']; ?>",
                "email": "<?php echo $_SESSION['user_email']; ?>"
            },
            "theme": {
                "color": "#3399cc"
            }
        };

        var rzp1 = new Razorpay(options);
        document.getElementById('payBtn').onclick = function(e){
            rzp1.open();
            e.preventDefault();
        }
    </script>
</body>
</html>
