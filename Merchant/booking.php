<?php
include 'sidebarmerchant.php';
include 'connection.php';

$merchant_id = $_SESSION['merchant_id']; // Ensure merchant is logged in

$query = "SELECT b.id, b.customer_name, b.customer_email, b.customer_mobile, b.booking_date, 
                 b.service_type, b.status, e.service_type AS service_name
          FROM bookings b
          JOIN entertainment_service e ON b.service_id = e.entertainment_id
          WHERE e.merchant_id = ? AND b.status = 'Pending'";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $merchant_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Merchant Dashboard - Pending Bookings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">Pending Bookings</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Booking Date</th>
                <th>Service</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['customer_email']; ?></td>
                    <td><?php echo $row['customer_mobile']; ?></td>
                    <td><?php echo $row['booking_date']; ?></td>
                    <td><?php echo $row['service_name']; ?></td>
                    <td><strong><?php echo $row['status']; ?></strong></td>
                    <td>
                        <a href="update_booking_status.php?id=<?php echo $row['id']; ?>&status=Accepted" class="btn btn-success btn-sm">Accept</a>
                        <a href="update_booking_status.php?id=<?php echo $row['id']; ?>&status=Rejected" class="btn btn-danger btn-sm">Reject</a>
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


<?php
// session_start();
include 'sidebarmerchant.php';
include 'connection.php';

if (!isset($_SESSION['merchant_id'])) {
    echo "<script>alert('Please log in first!'); window.location.href='merchant_login.php';</script>";
    exit();
}

// $merchant_email = $_SESSION['merchant_email'];
$merchant_id = $_SESSION['merchant_id']; // Ensure merchant is logged in

$query = "SELECT b.id, b.customer_name, b.customer_email, b.customer_mobile, 
                 b.booking_date, b.status, e.service_type, e.performance_duration, 
                 e.price, e.event_image 
          FROM bookings b
          JOIN entertainment_service e ON b.service_id = e.entertainment_id
          WHERE e.merchant_id = ? AND b.status = 'Accepted'";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $merchant_id);

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Merchant Dashboard - Accepted Bookings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">Accepted Bookings</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Service</th>
                <th>Booking Date</th>
                <th>Price</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['customer_email']; ?></td>
                    <td><?php echo $row['customer_mobile']; ?></td>
                    <td><?php echo $row['service_type']; ?></td>
                    <td><?php echo $row['booking_date']; ?></td>
                    <td>₹<?php echo number_format($row['price'], 2); ?></td>
                    <td>
                        <a href="merchant_view_booking.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">View Details</a>
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


















<?php
include 'sidebarmerchant.php';
include 'connection.php';

// $merchant_id = $_SESSION['merchant_id']; // Logged-in merchant's ID

// // Define how many results per page
$results_per_page = 7;

// // Find out the total number of bookings
// $sql = "SELECT COUNT(*) AS total FROM bookings WHERE merchant_id = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $merchant_id);
// $stmt->execute();
// $result = $stmt->get_result();
// $row = $result->fetch_assoc();
// $total_results = $row['total'];

// // Calculate the total number of pages
// $total_pages = ceil($total_results / $results_per_page);

// // Get the current page from the URL, default to page 1
// $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// $start_limit = ($page - 1) * $results_per_page;

// // Fetch the data for the current page
// $sql = "SELECT * FROM bookings WHERE merchant_id = ? LIMIT ?, ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("iii", $merchant_id, $start_limit, $results_per_page);
// $stmt->execute();
// $result = $stmt->get_result();
$merchant_id = $_SESSION['merchant_id']; // Ensure merchant is logged in

if (!isset($merchant_id)) {
    echo "Merchant not logged in!";
    exit;
}

// Find out the total number of bookings for the logged-in merchant
$sql = "SELECT COUNT(*) AS total FROM bookings WHERE merchant_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $merchant_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_results = $row['total'];

// Calculate the total number of pages
$total_pages = ceil($total_results / $results_per_page);

// Get current page number
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_limit = ($page - 1) * $results_per_page;

// Fetch only bookings for the logged-in merchant
$sql = "SELECT * FROM bookings WHERE merchant_id = ? LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $merchant_id, $start_limit, $results_per_page);
$stmt->execute();
$result = $stmt->get_result();

// Handle the POST Request for Booking Action (Accept/Reject)
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $booking_id = $_POST['id'];
    $status = $_POST['status']; // Accepted or Rejected

    $update_sql = "UPDATE bookings SET status = ? WHERE id = ? AND merchant_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sii", $status, $booking_id, $merchant_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Booking $status successfully!');window.location='booking.php';</script>";
    } else {
        echo "<script>alert('Error updating booking!');</script>";
    }
}
?>

<!-- Pagination Links -->
<div class="pagination">
    <a href="booking.php?page=1" class="<?php if ($page == 1) echo 'disabled'; ?>">&laquo; First</a>
    <a href="booking.php?page=<?php echo $page - 1; ?>" class="<?php if ($page == 1) echo 'disabled'; ?>">Prev</a>

    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
        <a href="booking.php?page=<?php echo $i; ?>" class="<?php if ($page == $i) echo 'active'; ?>"><?php echo $i; ?></a>
    <?php } ?>

    <a href="booking.php?page=<?php echo $page + 1; ?>" class="<?php if ($page == $total_pages) echo 'disabled'; ?>">Next</a>
    <a href="booking.php?page=<?php echo $total_pages; ?>" class="<?php if ($page == $total_pages) echo 'disabled'; ?>">Last &raquo;</a>
</div>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
        /* General Layout */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
        }

        /* Header Section */
        h2 {
            text-align: center;
            color: #333;
            font-size: 1.8rem;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-size: 1.1rem;
        }

        td {
            font-size: 1rem;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Action Button Styling */
        button {
            padding: 6px 12px;
            margin: 2px;
            font-size: 0.9rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        button[type="submit"]:active {
            background-color: #398e38;
        }

        button[type="submit"]:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        button[type="submit"]:not([disabled]) {
            background-color: #f44336;
            color: white;
        }

        button[type="submit"]:not([disabled]):hover {
            background-color: #e53935;
        }

        /* Pagination Styling */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            text-decoration: none;
            padding: 10px 15px;
            margin: 0 5px;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .pagination a:hover {
            background-color: #ddd;
        }

        .pagination .active {
            background-color: #4CAF50;
            color: white;
        }

        .pagination .disabled {
            color: #ccc;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
            }

            table,
            th,
            td {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Manage Bookings</h2>
        <table border="1">
            <tr>
                <th>Service Name</th>
                <th>Customer Name</th>
                <th>Booking Date</th>
                <th>Guests</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['booking_date']; ?></td>
                    <td><?php echo $row['guest_count']; ?></td>
                    <td>₹<?php echo $row['total_price']; ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                    <td>
                        <?php if ($row['status'] == 'Pending') { ?>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" name="status" value="Accepted">Accept</button>
                                <button type="submit" name="status" value="Rejected">Reject</button>
                            </form>
                        <?php } else {
                            echo ucfirst($row['status']);
                        } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>