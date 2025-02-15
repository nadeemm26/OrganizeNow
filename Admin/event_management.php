<?php
include "connection.php";
include "admin_sidebar.php";
?>

<h1>Event Management</h1>
<p>Manage all registered Events here.</p>

<?php

$tables = [
    'catering_service' => 'Catering Service',
    'decoration_service' => 'Decoration Service',
    'entertainment_service' => 'Entertainment Service',
    'photography_service' => 'Photography Service',
    'venue_booking' => 'Venue Booking'
];

$selectedTable = isset($_GET['table']) ? $_GET['table'] : 'catering_service';

$tableFields = [
    'catering_service' => ['id', 'catering_name',  'menu_details', 'capacity', 'price', 'min_order', 'merchant_id'],
    'decoration_service' => ['id', 'decoration_types', 'description', 'custom_decoration', 'price', 'merchant_id'],
    'entertainment_service' => ['id', 'service_type', 'performance_duration', 'price', 'merchant_id'],
    'photography_service' => ['id','service_name', 'photography_types','videography', 'package_desc', 'coverage_duration', 'num_photographers', 'editing', 'price', 'merchant_id'],
    'venue_booking' => ['id', 'venue_name', 'service_type', 'venue_type', 'capacity', 'address', 'city', 'pincode', 'price', 'merchant_id']
];

// Handle event deletion
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $deleteTable = $_GET['delete_table'];

    $deleteQuery = "DELETE FROM $deleteTable WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $deleteId);
    
    if ($stmt->execute()) {
        echo "<script>alert('Event deleted successfully!'); window.location.href='event_management.php?table=$deleteTable';</script>";
    } else {
        echo "<script>alert('Error deleting event.');</script>";
    }
    $stmt->close();
}

$query = "SELECT * FROM $selectedTable";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Event Management</title>
    <style>
        form {
            text-align: center;
            margin-bottom: 20px;
        }

        select {
            padding: 8px;
            font-size: 16px;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f8f8f8;
            cursor: pointer;
        }

        th:hover {
            background-color: #e0e0e0;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            background: #e74c3c;
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn:hover {
            background: #c0392b;
        }
    </style>
</head>

<body>

<form method="GET">
    <label for="tableSelect">Select Category:</label>
    <select name="table" id="tableSelect" onchange="this.form.submit()">
        <?php foreach ($tables as $table => $label) { ?>
            <option value="<?php echo $table; ?>" <?php echo ($selectedTable == $table) ? 'selected' : ''; ?>>
                <?php echo $label; ?>
            </option>
        <?php } ?>
    </select>
</form>

<table id="eventTable">
    <thead>
        <tr>
            <?php foreach ($tableFields[$selectedTable] as $field) { ?>
                <th><?php echo ucfirst(str_replace('_', ' ', $field)); ?></th>
            <?php } ?>
            <th>Merchant Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) {
            $merchantQuery = "SELECT name FROM merchant WHERE merchant_id = " . $row['merchant_id'];
            $merchantResult = $conn->query($merchantQuery);
            $merchant = $merchantResult->fetch_assoc();
        ?>
            <tr>
                <?php foreach ($tableFields[$selectedTable] as $field) { ?>
                    <td><?php echo $row[$field]; ?></td>
                <?php } ?>
                <td><?php echo $merchant['name']; ?></td>
                <td>
                    <a href="javascript:void(0);" class="btn" onclick="confirmDelete(<?php echo $row['id']; ?>, '<?php echo $selectedTable; ?>')">Delete Event</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function confirmDelete(eventId, tableName) {
        if (confirm("Are you sure you want to delete this event?")) {
            window.location.href = "event_management.php?delete_id=" + eventId + "&delete_table=" + tableName;
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const table = document.getElementById("eventTable");
        const headers = table.querySelectorAll("th");

        headers.forEach((header, index) => {
            header.addEventListener("click", function() {
                sortTable(index);
            });
        });

        function sortTable(index) {
            const rows = Array.from(table.querySelector("tbody").rows);
            const isNumeric = !isNaN(rows[0].cells[index].innerText);

            rows.sort((rowA, rowB) => {
                let a = rowA.cells[index].innerText;
                let b = rowB.cells[index].innerText;
                return isNumeric ? a - b : a.localeCompare(b);
            });

            rows.forEach(row => table.querySelector("tbody").appendChild(row));
        }
    });
</script>

</body>
</html>

<?php $conn->close(); ?>
