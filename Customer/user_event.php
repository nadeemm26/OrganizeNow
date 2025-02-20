<?php
include 'user_navbar.php';
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if status filter is applied
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

$query = "SELECT * FROM booking2 WHERE user_id = ?";
if ($status_filter) {
    $query .= " AND status = ?";
}

$stmt = $conn->prepare($query);
if ($status_filter) {
    $stmt->bind_param("is", $user_id, $status_filter);
} else {
    $stmt->bind_param("i", $user_id);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 2% 12%;
            padding: 20px;
        }

        /* Heading */
        h2 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        /* Filter Buttons */
        .filter-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .filter-container a {
            padding: 12px 18px;
            margin: 5px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: 0.3s ease-in-out;
            box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.15);
        }

        .filter-container a:hover {
            background: #0056b3;
            transform: scale(1.05);
        }

        /* Booking Card */
        .booking-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 4px 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            transition: transform 0.3s ease-in-out;
        }

        .booking-card:hover {
            transform: scale(1.02);
        }

        /* Booking Image */
        .booking-card img {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 20px;
        }

        /* Booking Info */
        .booking-info {
            flex: 1;
        }

        .booking-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            padding-right: 10px;
        }

        .booking-info strong {
            color: #555;
        }

        /* Booking Actions (Buttons) */
        .booking-actions {
            text-align: right;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: 0.3s;
        }

        .btn-pay {
            background: #28a745;
            color: white;
            box-shadow: 3px 3px 8px rgba(0, 128, 0, 0.3);
        }

        .btn-pay:hover {
            background: #218838;
            transform: scale(1.05);
        }

        .btn-bill {
            background: #ffc107;
            color: black;
            box-shadow: 3px 3px 8px rgba(255, 165, 0, 0.3);
        }

        .btn-bill:hover {
            background: #e0a800;
            transform: scale(1.05);
        }

        .btn-disabled {
            background: gray;
            color: white;
            cursor: not-allowed;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .booking-card {
                flex-direction: column;
                text-align: center;
                padding: 15px;
            }

            .booking-card img {
                margin: 0 auto 10px;
                width: 120px;
                height: 120px;
            }

            .booking-actions {
                text-align: center;
                margin-top: 10px;
            }
        }
    </style>

</head>

<body>

    <div class="container">
        <h2 style="text-align: center;">My Bookings</h2>

        <!-- Filter Buttons -->
        <div class="filter-container">
            <a href="user_event.php">All</a>
            <a href="user_event.php?status=Pending">Pending</a>
            <a href="user_event.php?status=Accepted">Accepted</a>
            <a href="user_event.php?status=Rejected">Rejected</a>
            <!-- <a href="user_event.php?status=Paid">Paid</a> -->
        </div>

        <!-- Display Bookings -->
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="booking-card">
                <img src="../merchant/<?php echo htmlspecialchars(trim($row['event_image'])); ?>" alt="Service Image">

                <!-- <img src="../Merchant/ <?php echo $row['event_image']; ?>" alt="Service Image" class="booking-image"> -->
                <div class="booking-title"><?php echo $row['service_name']; ?></div>
                <div class="booking-info">
                    <strong>Date:</strong> <?php echo $row['booking_date']; ?> <br>
                    <strong>Guests:</strong> <?php echo $row['guest_count']; ?> <br>
                    <strong>Days:</strong> <?php echo $row['num_days']; ?> <br>
                    <strong>Total Price:</strong> ₹<?php echo number_format($row['total_price'], 2); ?> <br>
                    <strong>Status:</strong> <?php echo ucfirst($row['status']); ?> <br>
                    <strong>Payment:</strong> <?php echo ucfirst($row['payment_status']); ?>
                </div>

                <div class="booking-actions">
                    <?php if ($row['status'] == 'Accepted' && $row['payment_status'] == 'Pending') { ?>
                        <a href="pay_now.php?booking_id=<?php echo $row['id']; ?>" class="btn btn-pay">Pay Now</a>
                        <a href="bill_summary.php?booking_id=<?php echo $row['id']; ?>" class="btn btn-bill">View Bill Summary</a>
                    <?php } elseif ($row['payment_status'] == 'Paid') { ?>
                        <a href="bill_summary.php?booking_id=<?php echo $row['id']; ?>" class="btn btn-bill">View Bill Summary</a>
                    <?php } else { ?>
                        <span class="btn btn-disabled">Waiting for Approval</span>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

    </div>

</body>

</html>