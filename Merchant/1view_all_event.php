<?php

include 'myevent.php';
$merchant_id = $_SESSION['merchant_id'];

// Fetch all events created by this merchant
$sql = "SELECT * FROM events WHERE merchant_id = '$merchant_id'";
$result = $conn->query($sql);
?>


<!-- View Event Form -->
<div id="viewEventForm" class="form-container">
    <h2>View All Events</h2>
    <p>Here you can view all your events.</p>
    <!-- Add a table or list to display events dynamically -->

    <div class="event-container">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="event-card">
                <img src="<?php echo $row['event_image']; ?>" alt="Event Image">
                <h3><?php echo $row['eventname']; ?></h3>
                <p><?php echo $row['eventdescription']; ?></p>
                <p><strong>Price:</strong> ₹<?php echo $row['price']; ?></p>
                <p><strong>Location:</strong> <?php echo $row['location']; ?></p>
                <p><strong>Date:</strong> <?php echo $row['date']; ?></p>
                <a href="edit_event.php?id=<?php echo $row['event_id']; ?>" class="btn">Edit</a>
                <a href="delete_event.php?id=<?php echo $row['event_id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
            </div>
        <?php } ?>
    </div>
</div>