<?php
include 'sidebarmerchant.php';
include 'connection.php'; ?>
<div class="header">
    <h1>Bookings</h1>
    <hr>
</div>
<!-- event 3 button -->
<div class="event-button">
    <div class="add-event">
        <button><a href="pending_bookings.php">Pending Bookings</a></button>
    </div>
    <div class="add-service">
        <button><a href="accepted_bookings.php">Accepted Bookings</a></button>
    </div>
    <div class="view-event">
        <button><a href="rejected_bookings.php">Rejected Bookings</a></button>
    </div>
</div>
<?php

if (!isset($_SESSION['merchant_id'])) {
    header("Location: ../merchant_login.php");
    exit();
}

$merchant_id = $_SESSION['merchant_id'];
$payment_filter = isset($_GET['payment_status']) ? $_GET['payment_status'] : '';

// Fetch accepted bookings with optional payment filter
$query = "SELECT * FROM booking2 WHERE merchant_id = ? AND status = 'Accepted'";
if ($payment_filter === 'Paid') {
    $query .= " AND payment_status = 'Paid'";
} elseif ($payment_filter === 'Pending') {
    $query .= " AND payment_status = 'Pending'";
}

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $merchant_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .container {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #28a745;
            color: white;
        }

        .btn-delete,
        .btn-reminder {
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-delete {
            background: #dc3545;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .btn-reminder {
            background: #ffc107;
            color: black;
        }

        .btn-reminder:hover {
            background: #e0a800;
        }

        .filter-form {
            margin-bottom: 20px;
            text-align: center;
        }

        .filter-form select,
        .filter-form button {
            padding: 5px 10px;
            margin-right: 10px;
        }

        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }

        #searchInput {
            width: 50%;
            padding: 10px;
            border: 2px solid #28a745;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
        }

        #searchInput:focus {
            border-color: #218838;
        }
    </style>
    <!-- search bar  -->
    <script>
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("bookingTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                td_name = tr[i].getElementsByTagName("td")[0];
                td_service = tr[i].getElementsByTagName("td")[3];

                if (td_name || td_service) {
                    txtValue_name = td_name.textContent || td_name.innerText;
                    txtValue_service = td_service.textContent || td_service.innerText;

                    if (txtValue_name.toUpperCase().indexOf(filter) > -1 ||
                        txtValue_service.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

</head>

<body>
    <div class="container">
        <h2>Confirmed Bookings</h2>

        <!-- Payment Filter -->
        <form method="GET" class="filter-form">
            <label for="payment_status">Filter by Payment Status:</label>
            <select name="payment_status" id="payment_status">
                <option value="">All</option>
                <option value="Paid" <?php if ($payment_filter === 'Paid') echo 'selected'; ?>>Paid</option>
                <option value="Pending" <?php if ($payment_filter === 'Pending') echo 'selected'; ?>>Unpaid</option>
            </select>
            <button type="submit">Filter</button>
        </form>
        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search by Customer Name or Service Type">
        </div>

        <table id="bookingTable">
            <tr>
                <th>Customer Name</th>
                <th>Customer Email</th>
                <th>Customer Mobile</th>
                <th>Service Type</th>
                <th>Service Name</th>
                <th>Booking Date</th>
                <th>Guests</th>
                <th>Days</th>
                <th>Location</th>
                <th>Total Price</th>
                <th>Payment Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['customer_email']; ?></td>
                    <td><?php echo $row['customer_mobile']; ?></td>
                    <td><?php echo $row['service_type']; ?></td>
                    <td><?php echo $row['service_name']; ?></td>
                    <td><?php echo $row['booking_date']; ?></td>
                    <td><?php echo $row['guest_count']; ?></td>
                    <td><?php echo $row['num_days']; ?></td>
                    <td><?php echo $row['location']; ?></td>
                    <td>₹<?php echo number_format($row['total_price'], 2); ?></td>
                    <td><?php echo $row['payment_status']; ?></td>
                    <td>
                        <?php if ($row['payment_status'] === 'Pending') { ?>
                            <form action="send_payment_reminder.php" method="POST">
                                <input type="hidden" name="customer_email" value="<?php echo $row['customer_email']; ?>">
                                <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn-reminder">Send Payment Reminder</button>
                            </form>

                        <?php } ?>
                        <form action="delete_booking.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                            <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>