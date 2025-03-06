<?php
include 'user_navbar.php';
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
$user_mobile = $_SESSION['user_mobile']; // Fetch user mobile from session

if (isset($_GET['id']) && isset($_GET['type']) && isset($_GET['merchant_id'])) {
    $service_id = $_GET['id'];
    $service_type = $_GET['type'];
    $merchant_id = $_GET['merchant_id'];

    $query = "SELECT * FROM $service_type WHERE service_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $service = $result->fetch_assoc();
        $service_image = $service['event_image'];
    } else {
        echo "<script>alert('Invalid service.'); window.location='main_home.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid request.'); window.location='main_home.php';</script>";
    exit();
}
$venue_location = "";
if ($service_type == "venue_booking") {
    $venue_location = $service['location']; // Database se venue location le rahe hain
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_date = $_POST['booking_date'];
    $guest_count = $_POST['guest_count'];
    $num_days = $_POST['num_days'];
    $user_mobile = $_POST['user_mobile'];

    // Price Calculation Based on Service Type
    if ($service_type == 'catering_service') {
        $total_price = $service['price'] * $guest_count * $num_days; // Price * Guest Count
    } else {
        $total_price = $service['price'] * $num_days; // Price * Number of Days
    }

    $status = "Pending";
    $payment_status = "Pending";
    $created_at = date("Y-m-d H:i:s");
    $location = ($service_type == "venue_booking") ? $venue_location : $_POST['location'];
    $insert_query = "INSERT INTO booking2 (service_id, service_name, service_type, booking_date, 
                customer_name, customer_email, customer_mobile, guest_count, num_days, 
                total_price, status, payment_status, created_at, user_id, merchant_id, event_image, location) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param(
        "issssssiiisssiiss",
        $service_id,
        $service['service_name'],
        $service_type,
        $booking_date,
        $user_name,
        $user_email,
        $user_mobile,
        $guest_count,
        $num_days,
        $total_price,
        $status,
        $payment_status,
        $created_at,
        $user_id,
        $merchant_id,
        $service_image,
        $location
    );

    if ($stmt->execute()) {
        echo "<script>alert('Booking Successful!'); window.location='user_event.php';</script>";
    } else {
        echo "<script>alert('Booking Failed. Try Again!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .con {
            width: 50%;
            margin: auto;
            margin-top: 50px;
            background: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input {
            width: 97%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn {
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
            border-radius: 5px;
        }

        .btn:hover {
            background: #0056b3;
        }
    </style>
    <!-- price mate -->
    <script>
        function calculateTotalPrice() {
            let pricePerUnit = <?php echo $service['price']; ?>;
            let guestCount = document.getElementById("guest_count").value;
            let numDays = document.getElementById("num_days").value;
            let serviceType = "<?php echo $service_type; ?>";

            let totalPrice = 0;

            if (serviceType === "catering_service") {
                totalPrice = pricePerUnit * guestCount * numDays;
            } else {
                totalPrice = pricePerUnit * numDays;
            }

            document.getElementById("total_price").value = "₹" + totalPrice.toFixed(2);
        }
    </script>
    <!-- date select karva mate -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let today = new Date();
            let minDate = new Date();
            minDate.setDate(today.getDate() + 6); // Set min date to today + 6 days

            let formattedMinDate = minDate.toISOString().split('T')[0];

            let bookingDateInput = document.getElementById("booking_date");
            bookingDateInput.setAttribute("min", formattedMinDate);
        });
    </script>
    <!-- location mate  -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let serviceType = "<?php echo $service_type; ?>";
            let locationField = document.getElementById("location");

            if (serviceType === "venue_booking") {
                locationField.setAttribute("disabled", "true"); // Disable location for venue
            }
        });
    </script>
</head>

<body>

    <div class="con">
        <h2>Book Service: <?php echo $service['service_name']; ?></h2>
        <form method="POST" class="f">
            <label>Service Type</label>
            <input type="text" value="<?php echo $service['service_type']; ?>" disabled>

            <label>Price Per Unit</label>
            <input type="text" value="₹<?php echo number_format($service['price'], 2); ?>" disabled>

            <label>Booking Date</label>
            <input type="date" name="booking_date" id="booking_date" required>

            <label>Location</label>
            <input type="text" id="location" name="location"
                value="<?php echo $venue_location; ?>"
                <?php echo ($service_type == "venue_booking") ? 'disabled' : 'required'; ?>>

            <label>Guest Count (For Catering Only)</label>
            <input type="number" id="guest_count" name="guest_count" min="1" required oninput="calculateTotalPrice()">

            <label>Number of Days (For Other Services)</label>
            <input type="number" id="num_days" name="num_days" min="1" required oninput="calculateTotalPrice()">

            <label>Total Price</label>
            <input type="text" id="total_price" value="₹0.00" disabled>

            <label>Customer Name</label>
            <input type="text" name="customer_name" value="<?php echo $user_name; ?>" disabled>

            <label>Customer Email</label>
            <input type="email" name="customer_email" value="<?php echo $user_email; ?>" disabled>

            <label>Customer Mobile</label>
            <input type="text" name="user_mobile" value="<?php echo $user_mobile; ?>" required>

            <button type="submit" class="btn">Confirm Booking</button>
        </form>
    </div>

</body>

</html>