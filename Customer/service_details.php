<?php
include 'user_navbar.php';
include 'connection.php';
// session_start();

if (!isset($_GET['id']) || !isset($_GET['type'])) {
    echo "<script>alert('Invalid request.'); window.location='services.php';</script>";
    exit();
}

$service_id = $_GET['id'];
$service_type = $_GET['type'];  // Table name

// Fetch service details dynamically from the correct table
$query = "SELECT * FROM $service_type WHERE service_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $service_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $service = $result->fetch_assoc();
} else {
    echo "<script>alert('Service not found.'); window.location='services.php';</script>";
    exit();
}

// Get merchant details
$merchant_id = $service['merchant_id'];
$merchant_query = "SELECT name, email, mobile FROM merchant WHERE merchant_id = ?";
$stmt = $conn->prepare($merchant_query);
$stmt->bind_param("i", $merchant_id);
$stmt->execute();
$merchant_result = $stmt->get_result();
$merchant = $merchant_result->fetch_assoc();

// Define table-specific fields
$fields = [
    "catering_service" => ["menu_details","service_capacity","price","min_order"],
    "venue_booking" => ["service_category","capacity","address","city","pincode","price"],
    "decoration_service" => ["service_category","description","custom_decoration","price"],
    "photography_service" => ["service_category","videography","package_desc","coverage_duration","num_photographers","editing","price"],
    "entertainment_service" => ["service_category","performance_duration","price"]
];

// Get the specific fields for the selected table
$table_fields = $fields[$service_type] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        /* .container {
            /* width: 80%;
            margin: auto;
            padding: 20px;
            background: #f9f9f9; ///////
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: fit-content;////
        } */
        .details {
            display: flex;
            gap: 20px;
        }
        .image-container img {
            width: 100%;
            height: 60%;
            ;
            border-radius: 10px;
        }
        .info {
            flex-grow: 1;
        }
        .info h2 {
            color: #333;
        }
        .info p {
            font-size: 16px;
            margin: 5px 0;
        }
        .btn {
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            border-radius: 5px;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="details">
        <div class="image-container">
            <img src="../Merchant/<?php echo $service['event_image']; ?>" alt="Service Image">
        </div>
        <div class="info">
            <h2><?php echo $service['service_name'] ?? 'Service Name Not Found'; ?></h2>
            <p><strong>Service Type:</strong> <?php echo ucfirst(str_replace('_', ' ', $service_type)); ?></p>
            
            <?php
            // Display dynamic fields
            foreach ($table_fields as $field) {
                if (isset($service[$field])) {
                    echo "<p><strong>" . ucfirst(str_replace('_', ' ', $field)) . ":</strong> " . $service[$field] . "</p>";
                }
            }
            ?>

            <h3>Merchant Details</h3>
            <p><strong>Name:</strong> <?php echo $merchant['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $merchant['email']; ?></p>
            <p><strong>Mobile:</strong> <?php echo $merchant['mobile']; ?></p>

            <a href="book_service.php?id=<?php echo $service_id; ?>&type=<?php echo $service_type; ?>&merchant_id=<?php echo $merchant_id; ?>" class="btn">
                Book This Service
            </a>
            <a href="main_home.php" class="btn"> Back</a>
        </div>
    </div>
</div>

</body>
</html>
