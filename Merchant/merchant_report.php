<?php
include "sidebarmerchant.php";
include "connection.php";
require_once('../customer/tcpdf/tcpdf.php');

if (!isset($_SESSION['merchant_id'])) {
    header("Location: ../merchant_login.php");
    exit();
}

$merchant_id = $_SESSION['merchant_id'];

$start_date = $_GET['start_date'] ?? "";
$end_date = $_GET['end_date'] ?? "";
$status = $_GET['status'] ?? "";
$payment_status = $_GET['payment_status'] ?? "";

$query = "SELECT * FROM booking2 WHERE merchant_id = ?";
$params = [$merchant_id];
$types = "i";

if (!empty($start_date)) {
    $query .= " AND booking_date >= ?";
    $params[] = $start_date;
    $types .= "s";
}
if (!empty($end_date)) {
    $query .= " AND booking_date <= ?";
    $params[] = $end_date;
    $types .= "s";
}
if (!empty($status)) {
    $query .= " AND status = ?";
    $params[] = $status;
    $types .= "s";
}
if (!empty($payment_status)) {
    $query .= " AND payment_status = ?";
    $params[] = $payment_status;
    $types .= "s";
}

$query .= " ORDER BY booking_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$bookings_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Booking Report</title>
    <style>
        .container {
            max-width: 10000px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #28a745;
            font-size: 24px;
        }

        .filter-form {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .filter-form select,
        .filter-form input {
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 15%;
        }

        .filter-form button {
            background: #28a745;
            color: white;
            width: 8%;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #28a745;
            color: white;
            padding: 12px;
            font-size: 14px;
        }

        td {
            padding: 10px;
            font-size: 14px;
        }

        .export-btn {
            text-align: center;
            padding: 15px;
            margin-top: 10px;
        }

        .export-btn a {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Booking Report</h2>
        <form class="filter-form" method="GET">
            Start Date:-<input type="date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>" placeholder="Start Date">
            End Date:-<input type="date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>" placeholder="End Date">
            <select name="status">
                <option value="">Booking Status</option>
                <option value="Pending" <?php if ($status == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="Accepted" <?php if ($status == 'Accepted') echo 'selected'; ?>>Accepted</option>
                <option value="Rejected" <?php if ($status == 'Rejected') echo 'selected'; ?>>Rejected</option>
            </select>
            <select name="payment_status">
                <option value="">Payment Status</option>
                <option value="Pending" <?php if ($payment_status == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="Paid" <?php if ($payment_status == 'Paid') echo 'selected'; ?>>Paid</option>
            </select>
            <button type="submit">Filter</button>
        </form>

        <table>
            <tr>
                <th>Service Name</th>
                <th>Customer</th>
                <th>Booking Date</th>
                <th>Guest Count</th>
                <th>Days</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Payment</th>
            </tr>
            <?php while ($booking = $bookings_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($booking['service_name']); ?></td>
                    <td><?php echo htmlspecialchars($booking['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                    <td><?php echo htmlspecialchars($booking['guest_count']); ?></td>
                    <td><?php echo htmlspecialchars($booking['num_days']); ?></td>
                    <td>₹<?php echo htmlspecialchars($booking['total_price']); ?></td>
                    <td><?php echo htmlspecialchars($booking['status']); ?></td>
                    <td><?php echo htmlspecialchars($booking['payment_status']); ?></td>
                </tr>
            <?php } ?>
        </table>

        <div class="export-btn">
            <a href="export_report.php?start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>&status=<?php echo urlencode($status); ?>&payment_status=<?php echo urlencode($payment_status); ?>" target="_blank">Export to PDF</a>
        </div>
    </div>

</body>

</html>