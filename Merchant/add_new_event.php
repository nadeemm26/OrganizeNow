<?php
session_start();
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['merchant_id'])) {
        die("Error: Merchant not logged in.");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eventname = $_POST['eventname'];
    $service = $_POST['type'];
    $price = $_POST['price'];
    $description = $_POST['eventdescription'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $merchant_id = $_SESSION['merchant_id'];
    // $created_by = $_SESSION['user_id'];

   // File upload handling
   $target_dir = "uploads/";
   $image_name = basename($_FILES["event_image"]["name"]);
   $target_file = $target_dir . time() . "_" . $image_name; // Unique name

   if (move_uploaded_file($_FILES["event_image"]["tmp_name"], $target_file)) {
       $image_path = $target_file;

       // Insert into database
       $sql = "INSERT INTO events (event_id,eventname, type, price, eventdescription, location, date, event_image,merchant_id) 
               VALUES (null,'$eventname','$service', '$price','$description','$location', '$date','$image_path','$merchant_id')";

       if ($conn->query($sql) === TRUE) {
           echo "Event created successfully!";
       } else {
           echo "Error: " . $conn->error;
       }
   } else {
       echo "File upload failed.";
   }
}
?>
<a href="myevent.php">Go Back</a>
