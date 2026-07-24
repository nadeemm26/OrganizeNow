<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../Customer/PHPMailer/src/Exception.php';
require '../Customer/PHPMailer/src/PHPMailer.php';
require '../Customer/PHPMailer/src/SMTP.php';
include 'connection.php';

if (!isset($_SESSION['merchant_id'])) {
    header("Location: ../merchant_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id'], $_POST['action'])) {
    $booking_id = $_POST['booking_id'];
    $action = $_POST['action'];
    $new_status = ($action == "accept") ? "Accepted" : "Rejected";

    // Fetch booking details
    $query = "SELECT * FROM booking2 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc();
        $customer_email = $booking['customer_email'];
        $customer_name = $booking['customer_name'];
        $service_name = $booking['service_name'];
        $booking_date = $booking['booking_date'];

        // Update booking status
        $update_query = "UPDATE booking2 SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("si", $new_status, $booking_id);

        if ($stmt->execute()) {
            // Send email notification
            $mail = new PHPMailer(true);
            try {
                // SMTP configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // SMTP server (use your email provider's SMTP)
                $mail->SMTPAuth = true;
                $mail->Username = 'mail@gmail.com'; // Your email
                $mail->Password = ''; // Your email password (use App Password if using Gmail)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Email settings
                $mail->setFrom('mail@gmail.com', 'Organize Now || Event Management Team');
                $mail->addAddress($customer_email, $customer_name);
                $mail->Subject = "Booking " . $new_status;

                $message = "Dear $customer_name,<br><br>";
                $message .= "Your booking for <b>'$service_name'</b> on <b>$booking_date</b> has been <b>$new_status</b> by the merchant.<br><br>";

                if ($new_status == "Accepted") {
                    $message .= "Please proceed with the payment to confirm your booking.<br>";
                } else {
                    $message .= "We're sorry, but your booking request has been declined.<br>";
                }

                $message .= "<br>Best Regards,<br>Event Management Team";

                $mail->isHTML(true);
                $mail->Body = $message;

                // Send email
                if ($mail->send()) {
                    echo "<script>alert('Booking updated and email sent successfully!'); window.location='pending_bookings.php';</script>";
                } else {
                    echo "<script>alert('Booking updated, but email notification failed.'); window.location='pending_bookings.php';</script>";
                }
            } catch (Exception $e) {
                echo "<script>alert('Booking updated, but email sending error: {$mail->ErrorInfo}'); window.location='pending_bookings.php';</script>";
            }
        } else {
            echo "<script>alert('Failed to update booking.'); window.location='pending_bookings.php';</script>";
        }
    } else {
        echo "<script>alert('Booking not found.'); window.location='pending_bookings.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location='pending_bookings.php';</script>";
}
?>

