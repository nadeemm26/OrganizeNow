<?php
include "connection.php";
require_once('../customer/tcpdf/tcpdf.php');
session_start();
$merchant_id = $_SESSION['merchant_id'];

$start_date = $_GET['start_date'] ?? "";
$end_date = $_GET['end_date'] ?? "";
$status = $_GET['status'] ?? "";
$payment_status = $_GET['payment_status'] ?? "";

$query = "SELECT * FROM booking2 WHERE merchant_id = ?";
$params = [$merchant_id];
$types = "i";

if (!empty($start_date)) { $query .= " AND booking_date >= ?"; $params[] = $start_date; $types .= "s"; }
if (!empty($end_date)) { $query .= " AND booking_date <= ?"; $params[] = $end_date; $types .= "s"; }
if (!empty($status)) { $query .= " AND status = ?"; $params[] = $status; $types .= "s"; }
if (!empty($payment_status)) { $query .= " AND payment_status = ?"; $params[] = $payment_status; $types .= "s"; }

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(190, 10, "Booking Report", 1, 1, 'C');

$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(30, 10, "Date", 1);
$pdf->Cell(40, 10, "Customer", 1);
$pdf->Cell(30, 10, "Service", 1);
$pdf->Cell(20, 10, "Guests", 1);
$pdf->Cell(20, 10, "Days", 1);
$pdf->Cell(20, 10, "Price", 1);
$pdf->Cell(30, 10, "Status", 1);
$pdf->Ln();

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(30, 10, $row['booking_date'], 1);
    $pdf->Cell(40, 10, $row['customer_name'], 1);
    $pdf->Cell(30, 10, $row['service_name'], 1);
    $pdf->Cell(20, 10, $row['guest_count'], 1);
    $pdf->Cell(20, 10, $row['num_days'], 1);
    $pdf->Cell(20, 10, "₹" . $row['total_price'], 1);
    $pdf->Cell(30, 10, $row['status'], 1);
    $pdf->Ln();
}

$pdf->Output('report.pdf', 'D');
?>
