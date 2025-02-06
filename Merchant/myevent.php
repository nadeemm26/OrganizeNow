<?php

include "sidebarmerchant.php";
include "connection.php";

// Ensure merchant is logged in
if (!isset($_SESSION['merchant_id'])) {
    die("Error: Merchant not logged in.");
}

?>
<div class="header">
    <h1>My Events</h1>
    <hr>
</div>
<!-- event 3 button -->
<div class="event-button">
    <div class="add-event">
        <button><a href="1add_new_event.php">Add New Event</a></button>
    </div>
    <div class="add-service">
        <button><a href="1add_new_service.php">Add New Service</a></button>
    </div>
    <div class="view-event">
        <button><a href="1view_all_event.php">View All Event</a></button>
    </div>
    <div class="view-service">
        <button><a href="1view_all_service.php">View All Service</a></button>
    </div>
</div>