<?php
include "connection.php";
include "admin_sidebar.php";
?>

<h1>Booking Management</h1>
<p>View and manage all event bookings here.</p>

<?php
// Status filter
$selectedStatus = isset($_GET['status']) ? $_GET['status'] : '';

// Handle admin actions
if (isset($_GET['action']) && isset($_GET['booking_id'])) {
    $bookingId = $_GET['booking_id'];

    if ($_GET['action'] == "accept") {
        $updateQuery = "UPDATE bookings SET status = 'Accepted' WHERE id = ?";
    } elseif ($_GET['action'] == "reject") {
        $updateQuery = "UPDATE bookings SET status = 'Rejected' WHERE id = ?";
    } elseif ($_GET['action'] == "delete") {
        $updateQuery = "DELETE FROM bookings WHERE id = ?";
    }

    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $bookingId);

    if ($stmt->execute()) {
        echo "<script>alert('Booking updated successfully!'); window.location.href='booking_management.php';</script>";
    } else {
        echo "<script>alert('Error updating booking.');</script>";
    }
    $stmt->close();
}

// Fetch bookings with status filter
$query = "SELECT * FROM bookings WHERE 1";
if ($selectedStatus) {
    $query .= " AND status = '$selectedStatus'";
}
$result = $conn->query($query);
?>

<head>
    <style>
        form {
            display: flex;
            align-items: center;
            gap: 10px;
            /* background: linear-gradient(145deg, #e3e3e3, #ffffff); */
            padding: 15px;
            border-radius: 10px;
            /* box-shadow: 5px 5px 15px #b8b8b8, -5px -5px 15px #ffffff; */
            max-width: 400px;
            margin: 20px auto;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        select {
            padding: 10px;
            border: none;
            border-radius: 8px;
            /* box-shadow: inset 3px 3px 6px #b8b8b8, inset -3px -3px 6px #ffffff; */
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        select:focus {
            outline: none;
            box-shadow: inset 2px 2px 5px #a8a8a8, inset -2px -2px 5px #ffffff;
        }

        button {
            padding: 10px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(145deg, #27ae60, #2ecc71);
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 5px 5px 10px #b8b8b8, -5px -5px 10px #ffffff;
            transition: all 0.3s ease-in-out;
        }

        button:hover {
            background: linear-gradient(145deg, #2ecc71, #27ae60);
            box-shadow: 3px 3px 8px #b8b8b8, -3px -3px 8px #ffffff;
        }

        button:active {
            box-shadow: inset 3px 3px 6px #a8a8a8, inset -3px -3px 6px #ffffff;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            background: #e74c3c;
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn:hover {
            background: #c0392b;
        }
    </style>
</head>
<form method="GET">
    <label for="status">Status:</label>
    <select name="status" id="status">
        <option value="">All Status</option>
        <option value="Pending" <?php echo ($selectedStatus == 'Pending') ? 'selected' : ''; ?>>Pending</option>
        <option value="Accepted" <?php echo ($selectedStatus == 'Accepted') ? 'selected' : ''; ?>>Accepted</option>
        <option value="Rejected" <?php echo ($selectedStatus == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
    </select>
    <button type="submit">Filter</button>
</form>

<table>
    <thead>
        <tr>
            <th>Booking ID</th>
            <th>Event Name</th>
            <th>Customer Name</th>
            <th>Customer Email</th>
            <th>Customer Mobile</th>
            <th>Booking Date</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Payment Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['service_type']; ?></td>
                <td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row['customer_email']; ?></td>
                <td><?php echo $row['customer_mobile']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td><?php echo $row['amount']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['payment_status']; ?></td>
                <td>
                    <a class="btn" href="?action=delete&booking_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php $conn->close(); ?>