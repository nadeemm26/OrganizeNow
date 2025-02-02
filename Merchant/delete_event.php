<?php
session_start();
include "connection.php";

// Ensure event ID is provided
if (!isset($_GET['id'])) {
    die("Error: Event ID not provided.");
}

$event_id = $_GET['id'];

// Delete event
$sql = "DELETE FROM events WHERE event_id='$event_id'";
if ($conn->query($sql) === TRUE) {
    echo "✅ Event deleted successfully!";
} else {
    echo "❌ Error deleting event: " . $conn->error;
}
?>
<a href="myevent.php">Back</a>