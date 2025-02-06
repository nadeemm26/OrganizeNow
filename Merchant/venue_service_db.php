<?php
session_start();
include "connection.php";

// Handle venue form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $venue_name = $_POST['venue_name'];
    $venue_type = $_POST['venue_type'];
    $capacity = $_POST['capacity'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $price = $_POST['price'];
    $merchant_id = $_SESSION['merchant_id'];
    // $event_image = $_FILES['event_image']['name'];

    // Handle file upload
    $target_dir = "uploads/";
   $image_name = basename($_FILES["event_image"]["name"]);
   $target_file = $target_dir . time() . "_" . $image_name; // Unique name

   if (move_uploaded_file($_FILES["event_image"]["tmp_name"], $target_file)) {
    $image_path = $target_file;

    $sql = "INSERT INTO venue_booking (id,venue_name, venue_type, capacity, address, city, pincode, price_per_day, event_image , merchant_id)
            VALUES (null,'$venue_name', '$venue_type', '$capacity', '$address', '$city', '$pincode', '$price','$image_path','$merchant_id')";

    if ($conn->query($sql) === TRUE) {
        echo "New venue added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}else{
    echo "File upload failed.";
}
}

$conn->close();
?>
<a href="myevent.php">Go Back</a>