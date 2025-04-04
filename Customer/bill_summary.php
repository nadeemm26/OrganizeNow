<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php'); // Include TCPDF Library

if (!isset($_GET['booking_id'])) {
    die("Invalid request!");
}

$booking_id = $_GET['booking_id'];

// Fetch Booking, Payment & Merchant Details
$query = "SELECT b.*, p.payment_id, p.amount_paid, p.payment_gateway, p.payment_status, 
                 m.name AS merchant_name, m.email AS merchant_email, m.mobile AS merchant_mobile 
          FROM booking2 b 
          LEFT JOIN payments p ON b.id = p.booking_id 
          LEFT JOIN merchant m ON b.merchant_id = m.merchant_id
          WHERE b.id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Booking not found!");
}

$booking = $result->fetch_assoc();

// Generate PDF
class MYPDF extends TCPDF {
    public function Header() {
        $image_file = 'logo.png'; // Change this to your logo file
        if (file_exists($image_file)) {
            $this->Image($image_file, 15, 10, 30, '', 'PNG');
        }
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 15, 'OrganizeNow - Booking Invoice', 0, 1, 'C');
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 10, 'Thank you for choosing OrganizeNow for your event!', 0, 1, 'C');
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 10);
        $this->Cell(0, 10, 'OrganizeNow | Contact: support@organizenow.com | Phone: +91 98765 43210', 0, 0, 'C');
    }
}

$pdf = new MYPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('OrganizeNow');
$pdf->SetTitle('Invoice');
$pdf->SetMargins(15, 20, 15);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Format Bill Content
$html = '
<style>
    .table { border-collapse: collapse; width: 100%; }
    .table th, .table td { border: 1px solid black; padding: 8px; text-align: left; }
    .header { background-color: #f2f2f2; font-weight: bold; }
</style>

<h2>Customer Details</h2>
<table class="table">
    <tr><td><strong>Name:</strong></td><td>' . htmlspecialchars($booking['customer_name']) . '</td></tr>
    <tr><td><strong>Email:</strong></td><td>' . htmlspecialchars($booking['customer_email']) . '</td></tr>
    <tr><td><strong>Mobile:</strong></td><td>' . htmlspecialchars($booking['customer_mobile']) . '</td></tr>
</table>

<h2>Merchant Details</h2>
<table class="table">
    <tr><td><strong>Name:</strong></td><td>' . htmlspecialchars($booking['merchant_name']) . '</td></tr>
    <tr><td><strong>Email:</strong></td><td>' . htmlspecialchars($booking['merchant_email']) . '</td></tr>
    <tr><td><strong>Mobile:</strong></td><td>' . htmlspecialchars($booking['merchant_mobile']) . '</td></tr>
</table>

<h2>Booking Details</h2>
<table class="table">
    <tr class="header"><th>Event</th><th>Date</th><th>Guests</th><th>Days</th><th>Address</th><th>Total Price</th></tr>
    <tr>
        <td>' . htmlspecialchars($booking['service_name']) . '</td>
        <td>' . $booking['booking_date'] . '</td>
        <td>' . $booking['guest_count'] . '</td>
        <td>' . $booking['num_days'] . '</td>
        <td>' . $booking['location'] . '</td>
        <td>' . number_format($booking['total_price'], 2) . '</td>
    </tr>
</table>

<h2>Payment Details</h2>
<table class="table">
    <tr class="header"><th>Payment ID</th><th>Amount Paid</th><th>Payment Method</th><th>Status</th></tr>
    <tr>
        <td>' . htmlspecialchars($booking['payment_id']) . '</td>
        <td>' . number_format($booking['amount_paid'], 2) . '</td>
        <td>' . ucfirst($booking['payment_gateway']) . '</td>
        <td>' . ucfirst($booking['payment_status']) . '</td>
    </tr>
</table>

<h2>Thank You!</h2>
<p>We appreciate your business. If you have any questions, please contact us.</p>
';

// Add HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Save PDF and Provide Download Link
$pdf_filename = "invoice_" . $booking_id . ".pdf";
$pdf->Output($pdf_filename, 'I'); // Show in browser
?>
