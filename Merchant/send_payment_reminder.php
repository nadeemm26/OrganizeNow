<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../Customer/PHPMailer/src/Exception.php';
require '../Customer/PHPMailer/src/PHPMailer.php';
require '../Customer/PHPMailer/src/SMTP.php';

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['customer_email']) && isset($_POST['booking_id'])) {
    $customer_email = $_POST['customer_email'];
    $booking_id = $_POST['booking_id'];

    // Fetch booking details
    $query = "SELECT * FROM booking2 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();

    if (!$booking) {
        echo "<script>alert('Booking details not found.'); window.location.href='accepted_bookings.php';</script>";
        exit();
    }
    
    $mail = new PHPMailer(true);
    
    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Change to your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'mail@gmail.com'; // Replace with your Gmail
        $mail->Password = ''; // Replace with your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Email Content
        $mail->setFrom('makwananadeem3@gmail.com', 'Event Management Team');
        $mail->addAddress($customer_email);
        $mail->Subject = "Payment Reminder for Your Booking";
        
        $mail->Body = "Dear Customer,\n\nThis is a friendly reminder that your payment for the booked event/service is still pending. Below are your booking details:\n\n" .
            "Service Type: " . $booking['service_type'] . "\n" .
            "Service Name: " . $booking['service_name'] . "\n" .
            "Booking Date: " . $booking['booking_date'] . "\n" .
            "Guests: " . $booking['guest_count'] . "\n" .
            "Days: " . $booking['num_days'] . "\n" .
            "Total Price: ₹" . number_format($booking['total_price'], 2) . "\n" .
            "Payment Status: " . $booking['payment_status'] . "\n\n" .
            "Please complete your payment as soon as possible to confirm your booking.\n\nThank you.\n\nBest regards,\nEvent Management Team";
        
        $mail->send();
        echo "<script>alert('Payment reminder sent successfully!'); window.location.href='accepted_bookings.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Failed to send payment reminder: " . $mail->ErrorInfo . "'); window.location.href='accepted_bookings.php';</script>";
    }
} else {
    header("Location: accepted_bookings.php");
    exit();
}
