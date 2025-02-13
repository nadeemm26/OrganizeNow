<?php
include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $merchant_id = 1; // Assuming logged-in merchant
    $event_name = $_POST["event_name"];
    $catering_price = $_POST["catering_price"] ?: NULL;
    $venue_price = $_POST["venue_price"] ?: NULL;
    $decoration_price = $_POST["decoration_price"] ?: NULL;
    $photography_price = $_POST["photography_price"] ?: NULL;
    $entertainment_price = $_POST["entertainment_price"] ?: NULL;
    $details = $_POST["details"];

    $sql = "INSERT INTO merchant_events_services 
            (merchant_id, event_name, catering_price, venue_price, decoration_price, photography_price, entertainment_price, details) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssss", $merchant_id, $event_name, $catering_price, $venue_price, $decoration_price, $photography_price, $entertainment_price, $details);

    if ($stmt->execute()) {
        echo "Event Added Successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<form method="POST">
    <label>Event Name:</label>
    <select name="event_name" required>
        <option value="Wedding">Wedding</option>
        <option value="Birthday">Birthday</option>
        <option value="Engagement">Engagement</option>
        <option value="Anniversary">Anniversary</option>
    </select>

    <label>Catering Price:</label> <input type="number" name="catering_price"><br>
    <label>Venue Price:</label> <input type="number" name="venue_price"><br>
    <label>Decoration Price:</label> <input type="number" name="decoration_price"><br>
    <label>Photography Price:</label> <input type="number" name="photography_price"><br>
    <label>Entertainment Price:</label> <input type="number" name="entertainment_price"><br>

    <label>Details:</label> <textarea name="details"></textarea><br>
    <button type="submit">Add Event</button>
</form>



<?php
include 'db.php';

$sql = "SELECT bookings.id, users.name, events.event_name, bookings.status 
        FROM bookings 
        JOIN users ON bookings.user_id = users.id 
        JOIN merchant_events_services events ON bookings.event_id = events.id 
        WHERE events.merchant_id = 1"; // Assuming logged-in merchant

$result = $conn->query($sql);
?>

<table>
    <tr>
        <th>User</th>
        <th>Event</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row["name"] ?></td>
            <td><?= $row["event_name"] ?></td>
            <td><?= $row["status"] ?></td>
            <td>
                <a href="approve_booking.php?id=<?= $row['id'] ?>&status=Accepted">Accept</a>
                <a href="approve_booking.php?id=<?= $row['id'] ?>&status=Rejected">Reject</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
