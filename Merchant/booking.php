<?php
include 'sidebarmerchant.php';
include 'connection.php';
?>

<div class="header">
    <h1>Bookings</h1>
    <hr>
</div>
<!-- event 3 button -->
<div class="event-button">
    <div class="add-event">
        <button><a href="pending_bookings.php">Pending Bookings</a></button>
    </div>
    <div class="add-service">
        <button ><a href="accepted_bookings.php">Accepted Bookings</a></button>
    </div>
    <div class="view-event">
        <button><a href="rejected_bookings.php">Rejected Bookings</a></button>
    </div>
</div>