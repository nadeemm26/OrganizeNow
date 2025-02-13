<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = 1; // Assuming logged-in user
    $event_id = $_POST["event_id"];
    
    $sql = "INSERT INTO bookings (user_id, event_id, status) VALUES (?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $event_id);

    if ($stmt->execute()) {
        echo "Booking Request Sent!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

?>

<form method="POST">
    <input type="hidden" name="event_id" value="<?= $_GET['event_id'] ?>">
    <button type="submit">Confirm Booking</button>
</form>
