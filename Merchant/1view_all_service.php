<?php
include 'myevent.php';
include "connection.php";

// Ensure merchant is logged in
if (!isset($_SESSION['merchant_id'])) {
    die("Access denied. Please login first.");
}

$merchant_id = $_SESSION['merchant_id']; // Get merchant ID from session

// Fetch selected service type
$serviceType = isset($_GET['service']) ? $_GET['service'] : 'catering_service';

// Define table names and their respective fields
$services = [
    'catering_service' => ['service_id','service_name','service_type','menu_details','service_capacity', 'price', 'min_order', 'event_image', 'added_on'],
    'decoration_service' => ['service_id','service_name', 'service_type','service_category', 'description', 'custom_decoration', 'price', 'event_image', 'added_on'],
    'entertainment_service' => ['service_id','service_name', 'service_type','service_category', 'performance_duration', 'price', 'event_image', 'added_on'],
    'photography_service' => ['service_id','service_name', 'service_type','service_category', 'videography', 'package_desc', 'coverage_duration', 'num_photographers', 'editing', 'price', 'event_image', 'added_on'],
    'venue_booking' => ['service_id','service_name','service_type','service_category','capacity', 'location', 'price', 'event_image', 'added_on']
];

// Check if selected service exists
if (!array_key_exists($serviceType, $services)) {
    die("Invalid service type");
}

// Pagination settings
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch total records for this merchant
$totalQuery = $conn->query("SELECT COUNT(*) as total FROM $serviceType WHERE merchant_id = $merchant_id");
$totalRecords = $totalQuery->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);

// Fetch data for selected service (only for the logged-in merchant)
$fields = implode(", ", $services[$serviceType]);
$query = "SELECT $fields FROM $serviceType WHERE merchant_id = $merchant_id LIMIT $start, $limit";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View My Services</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
    <script>
        function confirmDelete(serviceType, id) {
            if (confirm("Are you sure you want to delete this service?")) {
                window.location.href = "delete_service.php?service=" + serviceType + "&id=" + id;
            }
        }
    </script>
</head>
<body>
    <h2>My Services</h2>
    <form method="GET">
        <label for="service">Select Service:</label>
        <select name="service" id="service" onchange="this.form.submit()">
            <?php foreach ($services as $key => $value) { ?>
                <option value="<?php echo $key; ?>" <?php echo ($serviceType == $key) ? 'selected' : ''; ?>>
                    <?php echo ucfirst(str_replace('_', ' ', $key)); ?>
                </option>
            <?php } ?>
        </select>
    </form>
    <br>
    <table>
        <tr>
            <?php foreach ($services[$serviceType] as $field) { ?>
                <th><?php echo ucfirst(str_replace('_', ' ', $field)); ?></th>
            <?php } ?>
            <th>Action</th> <!-- New column for delete button -->
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <?php foreach ($services[$serviceType] as $field) { ?>
                    <td>
                        <?php echo ($field == 'event_image') ? '<img src="' . $row[$field] . '" width="100">' : $row[$field]; ?>
                    </td>
                <?php } ?>
                <td>
                    <button onclick="confirmDelete('<?php echo $serviceType; ?>', <?php echo $row['service_id']; ?>)">Delete</button>
                </td>
            </tr>
        <?php } ?>
    </table>
    <br>
    <div>
        <?php if ($page > 1) { ?>
            <a href="?service=<?php echo $serviceType; ?>&page=<?php echo ($page - 1); ?>">Previous</a>
        <?php } ?>
        Page <?php echo $page; ?> of <?php echo $totalPages; ?>
        <?php if ($page < $totalPages) { ?>
            <a href="?service=<?php echo $serviceType; ?>&page=<?php echo ($page + 1); ?>">Next</a>
        <?php } ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
