<?php
include '../OrganizeNow/Admin/connection.php';

// Check if ID & category are passed
if (isset($_GET['id']) && isset($_GET['category'])) {
    $id = intval($_GET['id']);  // Convert ID to integer
    $table = $_GET['category'];

    // Fetch details from the correct table
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Details</title>
    <style>
        .container { width: 60%; margin: auto; text-align: center; }
        .card { border: 1px solid #ddd; border-radius: 10px; padding: 15px; }
        .card img { width: 100%; height: 300px; object-fit: cover; border-radius: 5px; }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <!-- <img src="<?php echo $row["event_image"]; ?>" alt="Service Image"> -->
        <img src="Merchant/<?php echo $row["event_image"]; ?>" alt="Service Image">
        <h2><?php echo $row["name"] ?? $row["venue_name"] ?? 'Service'; ?></h2>

        <?php if ($table == "venue_booking"): ?>
            <p><strong>Type:</strong> <?php echo $row["venue_type"]; ?></p>
            <p><strong>Capacity:</strong> <?php echo $row["capacity"]; ?> People</p>
            <p><strong>Address:</strong> <?php echo $row["address"] . ', ' . $row["city"] . ', ' . $row["pincode"]; ?></p>
            <p><strong>Price Per Day:</strong> ₹<?php echo $row["price_per_day"]; ?></p>
        
        <?php elseif ($table == "decoration_service"): ?>
            <p><strong>Decoration Type:</strong> <?php echo $row["decoration_types"]; ?></p>
            <p><strong>Description:</strong> <?php echo $row["description"]; ?></p>
            <p><strong>Custom Decoration:</strong> <?php echo $row["custom_decoration"]; ?></p>
            <p><strong>Basic Price:</strong> ₹<?php echo $row["price_basic"]; ?></p>
            <p><strong>Premium Price:</strong> ₹<?php echo $row["price_premium"]; ?></p>

        <?php elseif ($table == "entertainment_service"): ?>
            <p><strong>Service Type:</strong> <?php echo $row["service_type"]; ?></p>
            <p><strong>Performance Duration:</strong> <?php echo $row["performance_duration"]; ?></p>
            <p><strong>Basic Price:</strong> ₹<?php echo $row["price_basic"]; ?></p>
            <p><strong>Premium Price:</strong> ₹<?php echo $row["price_premium"]; ?></p>

        <?php elseif ($table == "catering_service"): ?>
            <p><strong>Cuisine Type:</strong> <?php echo $row["cuisine_types"]; ?></p>
            <p><strong>Capacity:</strong> <?php echo $row["capacity"]; ?></p>
            <p><strong>Minimum Order:</strong> <?php echo $row["min_order"]; ?></p>
            <p><strong>Veg Price Per Plate:</strong> ₹<?php echo $row["price_veg"]; ?></p>
            <p><strong>Non-Veg Price Per Plate:</strong> ₹<?php echo $row["price_nonveg"]; ?></p>

        <?php elseif ($table == "photography_service"): ?>
            <p><strong>Service Name:</strong> <?php echo $row["service_name"]; ?></p>
            <p><strong>Photography Type:</strong> <?php echo $row["photography_types"]; ?></p>
            <p><strong>Coverage Duration:</strong> <?php echo $row["coverage_duration"]; ?></p>
            <p><strong>Basic Price:</strong> ₹<?php echo $row["price_basic"]; ?></p>
            <p><strong>Premium Price:</strong> ₹<?php echo $row["price_premium"]; ?></p>
        <?php endif; ?>

        <a href="1.php">Back to Home</a>
    </div>
</div>

</body>
</html>
