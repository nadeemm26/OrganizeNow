<?php
require '../razorpay-php/Razorpay.php';

use Razorpay\Api\Api;

$key_id = "your key";
$key_secret = "your key";
$api = new Api($key_id, $key_secret);

// 🔹 POST Data (From Razorpay)
$payment_id = $_POST['razorpay_payment_id'];
$order_id = $_POST['order_id'];
$signature = $_POST['razorpay_signature'];

// 🔹 Payment Verify Karein
$generated_signature = hash_hmac('sha256', $order_id . "|" . $payment_id, $key_secret);

if ($generated_signature === $signature) {
    echo "Payment Successful!";
} else {
    echo "Payment Verification Failed!";
}
?>
