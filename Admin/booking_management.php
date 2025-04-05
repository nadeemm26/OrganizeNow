<?php
include "connection.php";
include "admin_sidebar.php";
?>
<?php
// Check if delete action is requested
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Prepare and execute delete query
    $deleteQuery = "DELETE FROM booking2 WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $booking_id);

    if ($stmt->execute()) {
        echo "<script>alert('Booking deleted successfully'); window.location.href='booking_management.php';</script>";
    } else {
        echo "<script>alert('Error deleting booking');</script>";
    }

    $stmt->close();
}
?>

<h1>Booking Management</h1>
<p>View and manage all event bookings here.</p>

<?php
// Status filter
$selectedStatus = isset($_GET['status']) ? $_GET['status'] : '';
$paymentstatus = isset($_GET['payment_status']) ? $_GET['payment_status'] : '';
// Fetch bookings with status filter
$query = "SELECT * FROM booking2 WHERE 1";
if ($selectedStatus) {
    $query .= " AND status = '$selectedStatus'";
}
if($paymentstatus){
    $query .= " AND payment_status = '$paymentstatus'";
}
$result = $conn->query($query);
?>

<head>
    <style>
        h1 {
            color: #333;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        p {
            font-size: 18px;
            color: #555;
        }
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
            /* margin-top: 10px; */
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
        table {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        thead {
            background: #388E3C;
            color: rgb(0, 0, 0);
        }

        th,
        td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        tr:hover {
            background: #c8e6c9;
            transition: 0.3s ease-in-out;
        }

        .action-buttons a {
            text-decoration: none;
            color: white;
        }

        .action-buttons .delete {
            background: linear-gradient(to bottom, #D32F2F, #B71C1C);
            box-shadow: 0px 4px #880E4F;
        }

        .action-buttons .delete:hover {
            background: linear-gradient(to bottom, #E57373, #C62828);
            transform: translateY(-2px);
            box-shadow: 0px 6px #880E4F;
        }
    </style>
</head>
<form method="GET">
    <label for="status">Booking Status:</label>
    <select name="status" id="status">
        <option value="">All Status</option>
        <option value="Pending" <?php echo ($selectedStatus == 'Pending') ? 'selected' : ''; ?>>Pending</option>
        <option value="Accepted" <?php echo ($selectedStatus == 'Accepted') ? 'selected' : ''; ?>>Accepted</option>
        <option value="Rejected" <?php echo ($selectedStatus == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
    </select>
    <button type="submit">Filter</button>
    <label for="payment_status">Payment Status:</label>
    <select name="payment_status" id="payment_status">
        <option value="">All Status</option>
        <option value="Pending" <?php echo ($paymentstatus == 'Pending') ? 'selected' : ''; ?>>Pending</option>
        <option value="Paid" <?php echo ($paymentstatus == 'Paid') ? 'selected' : ''; ?>>Paid</option>
        
    </select>
    <button type="submit">Filter</button>
</form>

<table>
    <thead>
        <tr>
            <th>Booking ID</th>
            <th>Service Type</th>
            <th>Service Name</th>
            <th>Customer Name</th>
            <th>Customer Email</th>
            <th>Customer Mobile</th>
            <th>Booking Date</th>
            <th>Address</th>
            <th>Amount</th>
            <th>Booking Status</th>
            <th>Payment Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['service_type']; ?></td>
                <td><?php echo $row['service_name']; ?></td>
                <td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row['customer_email']; ?></td>
                <td><?php echo $row['customer_mobile']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td><?php echo $row['location']; ?></td>
                <td><?php echo $row['total_price']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['payment_status']; ?></td>
                <td class="action-buttons">
                    <button class="delete"><a href="?action=delete&booking_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a></button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php $conn->close(); ?>