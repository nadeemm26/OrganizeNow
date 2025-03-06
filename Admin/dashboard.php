<?php
include "connection.php";
include "admin_sidebar.php";
?>

<style>
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background: #2c3e50;
        color: white;
        border-radius: 8px;
    }

    .dashboard-header a {
        text-decoration: none;
        color: white;
    }

    .search-bar input {
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .reports-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: #ecf0f1;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .reports-table th,
    .reports-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .reports-table th {
        background: #34495e;
        color: white;
    }

    .chart-container {
        margin-top: 20px;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>

<?php
// Admin ID from session (Assuming admin logged in)
$admin_id = $_SESSION['admin_id'];

// Fetch admin details from database
$query = "SELECT username, profile_image FROM admin WHERE admin_id = '$admin_id'";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

// Default profile image if not set
$profile_image = !empty($admin['profile_image']) ? $admin['profile_image'] : 'default_avatar.png';
?>

<div id="dashboard" class="section">
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <div class="user-info">

            <img src="uploads/<?php echo htmlspecialchars($profile_image); ?>" alt="User Avatar" width="40" height="40" />
            <span><?php echo htmlspecialchars($admin['username']); ?></span>
        </div>
        <a href="edit_profile.php">Edit Profile</a>
    </div>
</div>
<?php

// Fetch total events from all service tables
$total_events_query = "
    (SELECT COUNT(*) AS total FROM catering_service) 
    UNION ALL
    (SELECT COUNT(*) FROM decoration_service)
    UNION ALL
    (SELECT COUNT(*) FROM entertainment_service)
    UNION ALL
    (SELECT COUNT(*) FROM photography_service)
    UNION ALL
    (SELECT COUNT(*) FROM venue_booking)
";

$result = $conn->query($total_events_query);
$total_events = 0;
while ($row = $result->fetch_assoc()) {
    $total_events += $row['total'];
}

// Fetch total bookings count
$total_bookings_query = "SELECT COUNT(*) AS total FROM booking2";
$total_bookings_result = $conn->query($total_bookings_query)->fetch_assoc();
$total_bookings = $total_bookings_result['total'];

// Fetch upcoming accepted bookings
$upcoming_bookings_query = "
    SELECT service_name, service_type, booking_date, customer_name, customer_email, customer_mobile, guest_count, num_days, total_price, event_image 
    FROM booking2 
    WHERE booking_date >= CURDATE() AND status = 'Accepted'
    ORDER BY booking_date ASC
";
$bookings_result = $conn->query($upcoming_bookings_query);

// Fetch past completed events
$completed_events_query = "
    SELECT service_name, service_type, booking_date, customer_name, customer_email, customer_mobile, guest_count, num_days, total_price, event_image 
    FROM booking2 
    WHERE booking_date < CURDATE() AND status = 'Accepted'
    ORDER BY booking_date DESC
";
$completed_events_result = $conn->query($completed_events_query);

// Fetch total revenue from accepted bookings
$revenue_query = "SELECT SUM(total_price) AS total_revenue FROM booking2 WHERE status = 'Accepted'";
$revenue_result = $conn->query($revenue_query)->fetch_assoc();
$total_revenue = $revenue_result['total_revenue'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
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
        }

        .events {
            margin: 20px;
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
            object-fit:fill;
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
    </style>
</head>

<body>

    <div class="dashboard">
        <div class="card">
            <h3>Total Events / Services</h3>
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
                <img src="http://localhost:8080/OrganizeNow/Merchant/uploads/<?php echo basename($booking['event_image']); ?>" alt="Event Image">
                <div class="event-details">
                    <h4><?php echo htmlspecialchars($booking['service_name']); ?> (<?php echo htmlspecialchars($booking['service_type']); ?>)</h4>
                    <p>Date: <?php echo htmlspecialchars($booking['booking_date']); ?></p>
                    <p>Customer: <?php echo htmlspecialchars($booking['customer_name']); ?></p>
                    <p>Contact: <?php echo htmlspecialchars($booking['customer_email']) . " / " . htmlspecialchars($booking['customer_mobile']); ?></p>
                    <p>Guests: <?php echo htmlspecialchars($booking['guest_count']); ?> | Days: <?php echo htmlspecialchars($booking['num_days']); ?></p>
                    <p>Total Price: ₹<?php echo htmlspecialchars($booking['total_price']); ?></p>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="events">
        <h2>Completed Events</h2>
        <?php while ($completed_event = $completed_events_result->fetch_assoc()) { ?>
            <div class="event">
                <img src="<?php echo (!empty($completed_event['event_image'])) ? 'http://localhost:8080/OrganizeNow/Merchant/' . htmlspecialchars($completed_event['event_image']) : 'https://placehold.co/80x80'; ?>" alt="Event Image">
                <div class="event-details">
                    <h4><?php echo htmlspecialchars($completed_event['service_name']); ?> (<?php echo htmlspecialchars($completed_event['service_type']); ?>)</h4>
                    <p>Date: <?php echo htmlspecialchars($completed_event['booking_date']); ?></p>
                    <p>Customer: <?php echo htmlspecialchars($completed_event['customer_name']); ?></p>
                    <p>Contact: <?php echo htmlspecialchars($completed_event['customer_email']) . " / " . htmlspecialchars($completed_event['customer_mobile']); ?></p>
                    <p>Guests: <?php echo htmlspecialchars($completed_event['guest_count']); ?> | Days: <?php echo htmlspecialchars($completed_event['num_days']); ?></p>
                    <p>Total Price: ₹<?php echo htmlspecialchars($completed_event['total_price']); ?></p>
                </div>
            </div>
        <?php } ?>
    </div>

</body>

</html>