<?php
include "sidebarmerchant.php";
include "connection.php";

if (!isset($_SESSION['merchant_id'])) {
    header("Location: ../merchant_login.php");
    exit();
}

$merchant_id = $_SESSION['merchant_id'];
$search_service = isset($_GET['service_name']) ? $_GET['service_name'] : '';
$search_type = isset($_GET['service_type']) ? $_GET['service_type'] : '';

$search_condition = "";
$params = [$merchant_id];
$types = "i";

if (!empty($search_service)) {
    $search_condition .= " AND service_name LIKE ?";
    $params[] = "%$search_service%";
    $types .= "s";
}
if (!empty($search_type)) {
    $search_condition .= " AND service_type LIKE ?";
    $params[] = "%$search_type%";
    $types .= "s";
}

// Fetch total events from different service tables
$total_events_query = "
    (SELECT COUNT(*) AS total FROM catering_service WHERE merchant_id = ?) 
    UNION ALL
    (SELECT COUNT(*) FROM decoration_service WHERE merchant_id = ?)
    UNION ALL
    (SELECT COUNT(*) FROM entertainment_service	 WHERE merchant_id = ?)
    UNION ALL
    (SELECT COUNT(*) FROM photography_service WHERE merchant_id = ?)
    UNION ALL
    (SELECT COUNT(*) FROM venue_booking WHERE merchant_id = ?)
";

$stmt = $conn->prepare($total_events_query);
$stmt->bind_param("iiiii", $merchant_id, $merchant_id, $merchant_id, $merchant_id, $merchant_id);
$stmt->execute();
$result = $stmt->get_result();

$total_events = 0;
while ($row = $result->fetch_assoc()) {
    $total_events += $row['total'];
}

// Fetch total bookings count for the merchant
$total_bookings_query = "SELECT COUNT(*) AS total FROM booking2 WHERE merchant_id = ?";
$stmt = $conn->prepare($total_bookings_query);
$stmt->bind_param("i", $merchant_id);
$stmt->execute();
$total_bookings_result = $stmt->get_result()->fetch_assoc();
$total_bookings = $total_bookings_result['total'];

// Fetch upcoming accepted bookings for this merchant
$upcoming_bookings_query = "
    SELECT service_name, service_type, booking_date, customer_name, customer_email, customer_mobile, guest_count, num_days, total_price, event_image,location 
    FROM booking2 
    WHERE merchant_id = ? AND booking_date >= CURDATE() AND status = 'Accepted' $search_condition
    ORDER BY booking_date ASC
";

$stmt = $conn->prepare($upcoming_bookings_query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$bookings_result = $stmt->get_result();

// Fetch past completed events (accepted bookings with a past date)
$completed_events_query = "
    SELECT service_name, service_type, booking_date, customer_name, customer_email, customer_mobile, guest_count, num_days, total_price, event_image,location 
    FROM booking2 
    WHERE merchant_id = ? AND booking_date < CURDATE() AND status = 'Accepted' $search_condition
    ORDER BY booking_date DESC
";
$stmt = $conn->prepare($completed_events_query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$completed_events_result = $stmt->get_result();

// Fetch total revenue from accepted bookings
$revenue_query = "SELECT SUM(total_price) AS total_revenue FROM booking2 WHERE merchant_id = ? AND status = 'Accepted'";
$stmt = $conn->prepare($revenue_query);
$stmt->bind_param("i", $merchant_id);
$stmt->execute();
$revenue_result = $stmt->get_result()->fetch_assoc();
$total_revenue = $revenue_result['total_revenue'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Merchant Dashboard</title>
    <style>
        /* body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        } */
        .header {
            text-align: center;
            padding: 20px;
            background-color: #529cb4;
            color: white;
            border-radius: 50px;
        }
        .dashboard {
            display: flex;
            justify-content: space-around;
            margin: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 200px;
        }
        .card h3 {
            margin-bottom: 10px;
            color: #529cb4;
        }
        .events {
            margin: 20px;
        }
        .events h2 {
            text-align: center;
            color: #529cb4;
        }
        .event {
            display: flex;
            align-items: center;
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }
        .event:hover {
            transform: scale(1.02);
        }
        .event img {
            width: 250px;
            height: 200px;
            border-radius: 10px;
            object-fit: fill;
            border: 3px solid #529cb4;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease-in-out;
        }
        .event img:hover {
            transform: scale(1.1);
        }
        .event-details {
            flex: 1;
            padding-left: 15px;
        }
        .event-details h4 {
            margin: 5px 0;
            color: #529cb4;
            font-size: 18px;
        }
        .event-details p {
            margin: 3px 0;
            font-size: 16px;
            /* font-weight: 400px; */
            color: #555;
        }
        .event-details p span {
            font-weight: bold;
            color: #333;
        }
        .search-container {
            text-align: center;
            margin: 20px 0;
        }

        .search-container form {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        .search-container input,
        .search-container select,
        .search-container button {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .search-container input {
            width: 250px;
        }
        .search-container button {
            background-color: white;
            color: black;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }
        .search-container button:hover {
            background-color: #417c8c;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['merchant_name']); ?>!</h2>
        <form method="GET" action="" class="search-container">
        <input type="text" name="service_name" placeholder="Search by Service Name" value="<?php echo htmlspecialchars($search_service); ?>">
        <input type="text" name="service_type" placeholder="Search by Service Type" value="<?php echo htmlspecialchars($search_type); ?>">
        <button type="submit">Search</button>
    </form>
    </div>

    <div class="dashboard">
        <div class="card">
            <h3>Total Event / Services</h3>
            <p><?php echo $total_events; ?></p>
        </div>
        <div class="card">
            <h3>Total Bookings</h3>
            <p><?php echo $total_bookings; ?></p>
        </div>
        <div class="card">
            <h3>Upcoming Bookings</h3>
            <p><?php echo $bookings_result->num_rows; ?></p>
        </div>
        <div class="card">
            <h3>Completed Bookings</h3>
            <p><?php echo $completed_events_result->num_rows; ?></p>
        </div>
        <div class="card">
            <h3>Total Revenue</h3>
            <p>₹<?php echo number_format($total_revenue, 2); ?></p>
        </div>
    </div>
    
    <div class="events">
        <h2>Upcoming Booked Services</h2>
        <?php while ($booking = $bookings_result->fetch_assoc()) { ?>
            <div class="event">
                <img src="<?php echo !empty($booking['event_image']) ? htmlspecialchars($booking['event_image']) : 'https://placehold.co/80x80'; ?>" alt="Event Image">
                <div class="event-details">
                    <h4><?php echo htmlspecialchars($booking['service_name']); ?> (<?php echo htmlspecialchars($booking['service_type']); ?>)</h4>
                    <p>Date: <?php echo htmlspecialchars($booking['booking_date']); ?></p>
                    <p>Customer: <?php echo htmlspecialchars($booking['customer_name']); ?></p>
                    <p>Contact: <?php echo htmlspecialchars($booking['customer_email']) . " / " . htmlspecialchars($booking['customer_mobile']); ?></p>
                    <p>Guests: <?php echo htmlspecialchars($booking['guest_count']); ?> | Days: <?php echo htmlspecialchars($booking['num_days']); ?></p>
                    <p>Total Price: ₹<?php echo htmlspecialchars($booking['total_price']); ?></p>
                    <p>Location: <?php echo htmlspecialchars($booking['location']); ?></p>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="events">
        <h2>Completed Events</h2>
        <?php while ($completed_event = $completed_events_result->fetch_assoc()) { ?>
            <div class="event">
                <img src="<?php echo !empty($completed_event['event_image']) ? htmlspecialchars($completed_event['event_image']) : 'https://placehold.co/80x80'; ?>" alt="Event Image">
                <div class="event-details">
                    <h4><?php echo htmlspecialchars($completed_event['service_name']); ?> (<?php echo htmlspecialchars($completed_event['service_type']); ?>)</h4>
                    <p>Date: <?php echo htmlspecialchars($completed_event['booking_date']); ?></p>
                    <p>Customer: <?php echo htmlspecialchars($completed_event['customer_name']); ?></p>
                    <p>Contact: <?php echo htmlspecialchars($completed_event['customer_email']) . " / " . htmlspecialchars($completed_event['customer_mobile']); ?></p>
                    <p>Guests: <?php echo htmlspecialchars($completed_event['guest_count']); ?> | Days: <?php echo htmlspecialchars($completed_event['num_days']); ?></p>
                    <p>Total Price: ₹<?php echo htmlspecialchars($completed_event['total_price']); ?></p>
                    <p>Location: <?php echo htmlspecialchars($completed_event['location']); ?></p>
                </div>
            </div>
        <?php } ?>
    </div>

</body>

</html>