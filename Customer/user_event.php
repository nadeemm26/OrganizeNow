<?php
session_start();
include 'user_navbar.php';
include 'connection.php';

if (!isset($_SESSION['user_email'])) {
    echo "<script>alert('Please log in first!'); window.location.href='user_login.php';</script>";
    exit();
}

$user_email = $_SESSION['user_email'];

// $query = "SELECT id, service_type, booking_date, status FROM bookings WHERE customer_email = ?";
$query = "SELECT b.id, b.service_id, b.booking_date, b.status, b.payment_status, 
                 e.service_type, e.price 
          FROM bookings b
          JOIN entertainment_service e ON b.service_id = e.entertainment_id
          WHERE b.customer_email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> -->
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Poppins', sans-serif;
        }

        /* .container {
            margin: 102px 100px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    
        } */
        .container {
            width: fit-content;
            margin: 3% 250px;
            padding: 20px;
            /* box-shadow: 2px 4px 1px 2px rgba(0, 0, 0, 0.1); */
        }

        h2 {
            text-align: center;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead {
            background: #007bff;
            color: white;
            text-align: center;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
            padding: 12px;
        }

        .btn {
            border-radius: 20px;
            padding: 8px 15px;
            font-size: 14px;
            transition: all 0.3s ease-in-out;
        }

        .btn-success {
            background: #28a745;
            border: none;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-info {
            background: #17a2b8;
            border: none;
        }

        .btn-info:hover {
            background: #138496;
        }

        .text-warning {
            color: #ff9800;
            font-weight: bold;
        }

        .text-success {
            color: #28a745;
            font-weight: bold;
        }

        .text-danger {
            color: #dc3545;
            font-weight: bold;
        }

        .badge {
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 12px;
        }

        .badge-warning {
            background: #ffc107;
            color: #333;
        }

        .badge-success {
            background: #28a745;
        }

        .badge-danger {
            background: #dc3545;
        }
        a{
            text-decoration: none;
            color: #f4f6f9;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">My Bookings</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th>Booking Date</th>
                    <th>Payment Status</th>
                    <th>Booking Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['service_type']; ?></td>
                        <td><?php echo $row['booking_date']; ?></td>
                        <td class="text-pending"><?php echo $row['payment_status']; ?></td>
                        <td>
                            <strong>
                                <?php
                                if ($row['status'] == 'Pending') {
                                    echo '<span class="text-warning">Pending</span>';
                                } elseif ($row['status'] == 'Accepted') {
                                    echo '<span class="text-success">Accepted</span>';
                                } else {
                                    echo '<span class="text-danger">Rejected</span>';
                                }
                                ?>
                            </strong>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'Accepted') { ?>
                                <a href="payment.php?booking_id=<?php echo $row['id']; ?>&amount=<?php echo $row['price']; ?>" class="btn btn-success">Pay Now</a>
                                <a href="view_booking.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">View Details</a>
                            <?php } else {
                                echo "-"; // No action for pending/rejected bookings
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>







<!-- 
    <h2>My Payments</h2>
    <tr>
        <th>Service Name</th>
        <th>Booking Date</th>
        <th>Amount</th>
        <th>Payment Method</th>
        <th>Status</th>
        <th>Payment Date</th>
    </tr>
    <tr>
        <td><?php echo $row['category']; ?></td>
        <td><?php echo $row['booking_date']; ?></td>
        <td>₹<?php echo $row['amount']; ?></td>
        <td><?php echo $row['payment_method']; ?></td>
        <td><?php echo ucfirst($row['status']); ?></td>
        <td><?php echo $row['created_at']; ?></td>
    </tr>
 -->