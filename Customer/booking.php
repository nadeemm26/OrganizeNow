<?php
include 'connection.php';
$service_id = $_GET['service_id'];
$service_type = $_GET['service_type'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book Entertainment Service</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Book <?php echo $service_type; ?></h2>
    <form action="process_booking.php" method="POST">
        <input type="hidden" name="service_id" value="<?php echo $service_id; ?>">
        <input type="hidden" name="service_type" value="<?php echo $service_type; ?>">
        
        <div class="mb-3">
            <label for="booking_date" class="form-label">Select Date</label>
            <input type="date" class="form-control" name="booking_date" required>
        </div>

        <div class="mb-3">
            <label for="customer_name" class="form-label">Your Name</label>
            <input type="text" class="form-control" name="customer_name" required>
        </div>

        <button type="submit" class="btn btn-success">Confirm Booking</button>
    </form>
</div>
</body>
</html>
