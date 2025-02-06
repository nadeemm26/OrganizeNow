<?php
    include 'user_navbar.php';
?>
<?php
include "connection.php";

// Search Functionality
$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

// Query for all services with search filter
$queries = [
    "SELECT 'Catering' AS category, catering_name AS name, cuisine_types AS type, price_veg AS price, event_image AS image FROM catering_service WHERE catering_name LIKE '%$search%' OR cuisine_types LIKE '%$search%'",
    "SELECT 'Decoration' AS category, decoration_types AS name, description AS type, price_basic AS price, event_image AS image FROM decoration_service WHERE decoration_types LIKE '%$search%'",
    "SELECT 'Entertainment' AS category, service_type AS name, performance_duration AS type, price_basic AS price, event_image AS image FROM entertainment_service WHERE service_type LIKE '%$search%'",
    "SELECT 'Photography' AS category, service_name AS name, photography_types AS type, price_basic AS price, event_image AS image FROM photography_service WHERE service_name LIKE '%$search%'",
    "SELECT 'Venue' AS category, venue_name AS name, venue_type AS type, price_per_day AS price, event_image AS image FROM venue_booking WHERE venue_name LIKE '%$search%'"
];

$services = [];
foreach ($queries as $query) {
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .search-container {
            text-align: center;
            margin: 20px 0;
        }
        .search-container input {
            width: 50%;
            padding: 10px;
            font-size: 16px;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .service-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
        }
        .service-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }
        .service-card h3 {
            margin: 10px 0;
        }
        .service-card p {
            color: #555;
        }
        .book-btn {
            display: inline-block;
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .book-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="search-container">
        <form method="GET">
            <input type="text" name="search" placeholder="Search by service name or category..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="grid-container">
        <?php if (!empty($services)): ?>
            <?php foreach ($services as $service): ?>
                <div class="service-card">
                    <img src="<?= $service['image'] ?>" alt="Service Image">
                    <h3><?= $service['name'] ?></h3>
                    <p><strong>Category:</strong> <?= $service['category'] ?></p>
                    <p><strong>Type:</strong> <?= $service['type'] ?></p>
                    <p><strong>Price:</strong> ₹<?= $service['price'] ?></p>
                    <a href="booking_form.php?name=<?= urlencode($service['name']) ?>" class="book-btn">Book Now</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center;">No results found.</p>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
// session_start();
include "connection.php";

// Fetch all services from different tables
$services = [];

// Catering Services
$sql = "SELECT catering_id AS id, catering_name AS name, menu_details AS details, price_veg AS price, event_image AS image, 'catering' AS category FROM catering_service";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}

// Decoration Services
$sql = "SELECT decoration_id AS id, decoration_types AS name, description AS details, price_basic AS price, event_image AS image, 'decoration' AS category FROM decoration_service";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}

// Entertainment Services
$sql = "SELECT entertainment_id AS id, service_type AS name, performance_duration AS details, price_basic AS price, event_image AS image, 'entertainment' AS category FROM entertainment_service";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}

// Photography Services
$sql = "SELECT photography_id AS id, service_name AS name, package_desc AS details, price_basic AS price, event_image AS image, 'photography' AS category FROM photography_service";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}

// Venue Booking
$sql = "SELECT venue_id AS id, venue_name AS name, venue_type AS details, price_per_day AS price, event_image AS image, 'venue' AS category FROM venue_booking";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Services</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .grid-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; padding: 20px; }
        .service-card { background: white; padding: 15px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .service-card img { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; }
        .service-card h3 { margin: 10px 0; }
        .service-card p { color: #555; }
        .service-card button { background: #007bff; color: white; border: none; padding: 10px; cursor: pointer; width: 100%; border-radius: 5px; }
        .service-card button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Available Services</h2>
    <div class="grid-container">
        <?php foreach ($services as $service) { ?>
            <div class="service-card">
                <img src="<?php echo $service['image']; ?>" alt="<?php echo $service['name']; ?>">
                <h3><?php echo $service['name']; ?></h3>
                <p><strong>Category:</strong> <?php echo ucfirst($service['category']); ?></p>
                <p><?php echo $service['details']; ?></p>
                <p><strong>Price:</strong> ₹<?php echo $service['price']; ?></p>
                <button onclick="bookService('<?php echo $service['id']; ?>', '<?php echo $service['category']; ?>')">Book Now</button>
            </div>
        <?php } ?>
    </div>

    <script>
        function bookService(id, category) {
            window.location.href = 'book_service.php?id=' + id + '&category=' + category;
        }
    </script>
</body>
</html>
