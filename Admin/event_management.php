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
    'catering_service' => ['service_id', 'service_name', 'service_type', 'menu_details', 'service_capacity', 'price', 'min_order', 'merchant_id'],
    'decoration_service' => ['service_id', 'service_name', 'service_type', 'service_category', 'description', 'custom_decoration', 'price', 'merchant_id'],
    'entertainment_service' => ['service_id', 'service_name', 'service_type', 'service_category', 'performance_duration', 'price', 'merchant_id'],
    'photography_service' => ['service_id', 'service_name', 'service_type', 'service_category', 'videography', 'package_desc', 'coverage_duration', 'num_photographers', 'editing', 'price', 'merchant_id'],
    'venue_booking' => ['service_id', 'service_name', 'service_type', 'service_category', 'capacity', 'location','price', 'merchant_id']
];

// Handle event deletion
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $deleteTable = $_GET['delete_table'];

    $deleteQuery = "DELETE FROM $deleteTable WHERE service_id = ?";
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
        h1 {
            color: #333;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        label {
            
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        

        p {
            font-size: 18px;
            color: #555;
        }

        button {
            background: linear-gradient(to bottom, #4CAF50, #2E7D32);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0px 4px #1B5E20;
            transition: all 0.2s ease-in-out;
        }

        button:hover {
            background: linear-gradient(to bottom, #66BB6A, #388E3C);
            transform: translateY(-2px);
            box-shadow: 0px 6px #1B5E20;
        }

        button:active {
            transform: translateY(2px);
            box-shadow: 0px 2px #1B5E20;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        select {
            padding: 10px;
            border: none;
            border-radius: 8px;
            /* box-shadow: inset 3px 3px 6px #b8b8b8, inset -3px -3px 6px #ffffff; */
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            
        }
        select:focus {
            outline: none;
            box-shadow: inset 2px 2px 5px #a8a8a8, inset -2px -2px 5px #ffffff;
        }

        table {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        thead {
            background: #388E3C;
            color: rgb(0, 0, 0);
        }

        th,
        td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        tr:hover {
            background: #c8e6c9;
            transition: 0.3s ease-in-out;
        }

        .action-buttons a {
            text-decoration: none;
            color: white;
        }

        .action-buttons .delete {
            background: linear-gradient(to bottom, #D32F2F, #B71C1C);
            box-shadow: 0px 4px #880E4F;
        }

        .action-buttons .delete:hover {
            background: linear-gradient(to bottom, #E57373, #C62828);
            transform: translateY(-2px);
            box-shadow: 0px 6px #880E4F;
        }
    </style>

</head>



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
                <td class="action-buttons">
                    <button class="delete"><a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['service_id']; ?>, '<?php echo $selectedTable; ?>')">Delete Event</a></button>
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