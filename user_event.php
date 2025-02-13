<?php
include 'db.php';

$sql = "SELECT * FROM merchant_events_services";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Listing</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>

<table id="eventTable">
    <thead>
        <tr>
            <th>Event Name</th>
            <th>Catering Price</th>
            <th>Venue Price</th>
            <th>Decoration Price</th>
            <th>Photography Price</th>
            <th>Entertainment Price</th>
            <th>Details</th>
            <th>Book</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row["event_name"] ?></td>
                <td><?= $row["catering_price"] ?></td>
                <td><?= $row["venue_price"] ?></td>
                <td><?= $row["decoration_price"] ?></td>
                <td><?= $row["photography_price"] ?></td>
                <td><?= $row["entertainment_price"] ?></td>
                <td><?= $row["details"] ?></td>
                <td><a href="book_event.php?event_id=<?= $row['id'] ?>">Book</a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
        $('#eventTable').DataTable();
    });
</script>

</body>
</html>
