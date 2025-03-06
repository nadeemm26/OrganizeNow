<?php
session_start();
include "connection.php";

// Ensure event ID is provided
if (!isset($_GET['id'])) {
    die("Error: Event ID not provided.");
}

$event_id = $_GET['id'];

// Fetch event details
$sql = "SELECT * FROM events WHERE event_id = '$event_id'";
$result = $conn->query($sql);
$event = $result->fetch_assoc();

// If form is submitted, update event
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eventname = $_POST['eventname'];
    $price = $_POST['price'];
    $description = $_POST['eventdescription'];
    $location = $_POST['location'];
    $date = $_POST['date'];

    $update_sql = "UPDATE events SET 
                   eventname='$eventname', price='$price', eventdescription='$description', 
                   location='$location', date='$date' 
                   WHERE event_id='$event_id'";

    if ($conn->query($update_sql) === TRUE) {
        echo "✅ Event updated successfully!";
    } else {
        echo "❌ Error updating event: " . $conn->error;
    }
}
?>

<form method="POST">
    <input type="text" name="eventname" value="<?php echo $event['eventname']; ?>" required><br><br>
    <input type="text" name="price" value="<?php echo $event['price']; ?>" required><br><br>
    <textarea name="eventdescription"><?php echo $event['eventdescription']; ?></textarea><br><br>
    <input type="text" name="location" value="<?php echo $event['location']; ?>" required><br><br>
    <input type="date" name="date" value="<?php echo $event['date']; ?>" required><br><br>
    <button type="submit">Update Event</button>
</form>
<a href="myevent.php">Back</a>
