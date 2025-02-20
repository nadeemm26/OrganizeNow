<?php
    include "connection.php";
    include "admin_sidebar.php";
?>

        <h1>Payment Management</h1>
        <p>Manage All Registered Events Payments.</p>
        <table>
            <thead>
                <tr>
                    <th>Payment Id</th>
                    <th>Booking Id</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Customer Mobile</th>
                    <th>Merchant Name</th>
                    <th>Service/Event</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="action-buttons">
                        <button>Edit</button>
                        <button class="delete">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
// session_start();
// include('../config/db_connect.php'); // Database connection

// Check if admin is logged in


// Update Payment Status
if (isset($_POST['update_payment'])) {
    $payment_id = $_POST['payment_id'];
    $status = $_POST['status'];
    $query = "UPDATE payments SET status='$status' WHERE id='$payment_id'";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Payment status updated successfully!";
    } else {
        $_SESSION['error'] = "Failed to update payment status.";
    }
}

// Fetch Payments
$query = "SELECT p.id, u.name AS user_name, p.amount_paid, p.payment_status, FROM payments p INNER JOIN user u ON p.user_id = u.id ";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Management</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Payment Management</h2>
    
    <?php if(isset($_SESSION['success'])) { echo "<p class='success'>" . $_SESSION['success'] . "</p>"; unset($_SESSION['success']); } ?>
    <?php if(isset($_SESSION['error'])) { echo "<p class='error'>" . $_SESSION['error'] . "</p>"; unset($_SESSION['error']); } ?>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Payment Date</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['user_name']; ?></td>
                <td><?php echo $row['amount']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['payment_date']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="payment_id" value="<?php echo $row['id']; ?>">
                        <select name="status">
                            <option value="Pending" <?php if($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Completed" <?php if($row['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                            <option value="Failed" <?php if($row['status'] == 'Failed') echo 'selected'; ?>>Failed</option>
                        </select>
                        <button type="submit" name="update_payment">Update</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
