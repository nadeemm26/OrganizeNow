<?php
include 'connection.php';
include 'user_navbar.php';
// session_start();

if (!isset($_SESSION['user_id'])) {
    die("Please login first.");
}

if (isset($_GET['id']) && isset($_GET['category'])) {
    $id = intval($_GET['id']);
    $table = $_GET['category'];

    // Fetch service details
    $sql = "SELECT * FROM $table WHERE " . array_keys(mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM $table LIMIT 1")))[0] . " = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Service not found.");
    }
} else {
    die("Invalid request.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $service_id = intval($_POST['service_id']);
    $category = $_POST['category'];
    $booking_date = $_POST['booking_date'];
    $guest_count = intval($_POST['guest_count']);
    $num_days = intval($_POST['num_days']);
    $total_price = floatval($_POST['total_price']);
    $merchant_id = $_SESSION['merchant_id'];

    $insert_sql = "INSERT INTO bookingsright (user_id, service_id, category, booking_date, guest_count, num_days, total_price,merchant_id) 
                   VALUES (?, ?, ?, ?, ?, ?, ?,?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("iissiidi", $user_id, $service_id, $category, $booking_date, $guest_count, $num_days, $total_price ,$merchant_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Booking successful!'); window.location='user_event.php';</script>";
    } else {
        echo "<script>alert('Booking failed!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Service</title>
    <script>
        function calculateTotal() {
            var price = parseFloat(document.getElementById('base_price').value) || 0;
            var guestCount = parseInt(document.getElementById('guest_count').value) || 1;
            var numDays = parseInt(document.getElementById('num_days').value) || 1;
            var category = document.getElementById('category').value;

            var total = 0;

            if (category === "catering_service") {
                total = price * guestCount; // Per Plate Price x Guests
            } else {
                total = price * numDays; // Per Day Price x Days
            }

            document.getElementById('total_price').value = total.toFixed(2);
        }
    </script>
</head>
<body>
    <h2>Book: <?php echo $row["name"] ?? $row["venue_name"] ?? 'Service'; ?></h2>
    
    <form method="POST">
        <input type="hidden" name="service_id" value="<?php echo $id; ?>">
        <input type="hidden" name="category" id="category" value="<?php echo $table; ?>">
        <input type="hidden" id="base_price" value="<?php echo $row["price"] ?? 0; ?>">

        <label>Select Booking Date:</label>
        <input type="date" name="booking_date" required>

        <label>Number of Guests:</label>
        <input type="number" id="guest_count" name="guest_count" min="1" value="1" oninput="calculateTotal()" required>

        <label>Number of Days:</label>
        <input type="number" id="num_days" name="num_days" min="1" value="1" oninput="calculateTotal()" required>

        <label>Total Price:</label>
        <input type="text" id="total_price" name="total_price" readonly>

        <button type="submit">Confirm Booking</button>
    </form>

    <a href="main_home.php">Cancel</a>
</body>
</html>
