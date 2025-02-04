<?php

include "sidebarmerchant.php";

?>
<?php
    // session_start();
    include "connection.php";

    // Ensure merchant is logged in
    if (!isset($_SESSION['merchant_id'])) {
        die("Error: Merchant not logged in.");
    }

    $merchant_id = $_SESSION['merchant_id'];

    // Fetch all events created by this merchant
    $sql = "SELECT * FROM events WHERE merchant_id = '$merchant_id'";
    $result = $conn->query($sql);
    ?>

<div class="header">
    <h1>All My Events</h1>
    <hr>
</div>
<div class="event-button">
    <div class="add-event">
        <button onclick="showForm('addEventForm')">Add New Event</button>
    </div>
    <div class="view-event">
        <button onclick="showForm('viewEventForm')">View All Event</button>
    </div>
</div>

<!-- Add New Event Form -->
<div id="addEventForm" class="form-container">
    <h2>Add New Event</h2>
    <form action="add_new_event.php" method="post" enctype="multipart/form-data">
        <input type="text" name="eventname" placeholder="Event Name" required>
        <!-- <label for="type">Service Type:</label> -->
        <select name="type" id="type" required>
            <option name="" value="">Select Your Service Type</option>
            <option name="type" value="catering">Catering</option>
            <option name="type" value="decoration">Decoration</option>
            <option name="type" value="photo">Photo</option>
            <option name="type" value="venue">Venue</option>
            <option name="type" value="other">Other</option>
        </select>
        <input type="number" name="price" placeholder="Ticket Price" required />
        <input type="text" name="eventdescription" placeholder="Event Description" required>
        <input type="text" name="location" placeholder="Event Location" required>
        <input type="date" name="date" placeholder="Event Date" required>

        <label for="image">Event Image:</label>
        <input type="file" name="event_image" accept="image/*" required />

        <button type="submit">Submit</button>
    </form>
</div>

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

<script>
    // JavaScript to show/hide forms
    function showForm(formId) {
        // Hide all forms
        document.querySelectorAll('.form-container').forEach(form => {
            form.style.display = 'none';
        });

        // Show the selected form
        document.getElementById(formId).style.display = 'block';
    }
</script>
</body>

</html>