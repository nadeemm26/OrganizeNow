<?php
session_start();
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $merchant_id = $_SESSION['merchant_id']; // Assuming merchant is logged in
    $target_dir = "uploads/"; // Directory to store images

    // Handling file upload
    if (!empty($_FILES["event_image"]["name"])) {
        $image_name = basename($_FILES["event_image"]["name"]);
        $target_file = $target_dir . time() . "_" . $image_name; // Unique name

        if (!move_uploaded_file($_FILES["event_image"]["tmp_name"], $target_file)) {
            die("File upload failed.");
        }
        $event_image = $target_file;
    } else {
        die("Please upload an image.");
    }

    // **Venue Booking Form Submission**
    if (isset($_POST['add_venue'])) {
        $service_type = $_POST['service_type'];
        $venue_name = $_POST['service_name'];
        $venue_type = $_POST['service_category'];
        $capacity = $_POST['capacity'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $pincode = $_POST['pincode'];
        $price = $_POST['price'];

        $sql = "INSERT INTO venue_booking (service_name,service_type,service_category, capacity, address, city, pincode, price, event_image, merchant_id) 
                VALUES ('$venue_name','$service_type', '$venue_type', '$capacity', '$address', '$city', '$pincode', '$price', '$event_image', '$merchant_id')";
    }

    // **Catering Service Submission**
    elseif (isset($_POST['add_catering'])) {
        $catering_name = $_POST['service_name'];
        $cuisine_type = $_POST['service_type'];
        $menu_details = $_POST['menu_details'];
        $capacity = $_POST['service_capacity'];
        $price_veg = $_POST['price'];
        $min_order = $_POST['min_order'];

        $sql = "INSERT INTO catering_service (service_name, service_type, menu_details, service_capacity, price,min_order, event_image, merchant_id) 
                VALUES ('$catering_name', '$cuisine_type', '$menu_details', '$capacity', '$price_veg','$min_order', '$event_image', '$merchant_id')";
    }

    // **Photography Service Submission**
    elseif (isset($_POST['add_photography'])) {
        $service_name = $_POST['service_name'];
        $service_type = $_POST['service_type'];
        $photography_types = $_POST['service_category'];
        $videography = $_POST['videography'];
        $package_desc = $_POST['package_desc'];
        $coverage_duration = $_POST['coverage_duration'];
        $num_photographers = $_POST['num_photographers'];
        $editing = $_POST['editing'];
        $price_basic = $_POST['price'];
        

        $sql = "INSERT INTO photography_service (service_name,service_type, service_category, videography, package_desc, coverage_duration, num_photographers, editing, price, event_image, merchant_id) 
                VALUES ('$service_name','$service_type', '$photography_types', '$videography', '$package_desc', '$coverage_duration', '$num_photographers', '$editing', '$price_basic', '$event_image', '$merchant_id')";
    }

    // **Decoration Service Submission**
    elseif (isset($_POST['add_decoration'])) {
        $service_name = $_POST['service_name'];
        $service_type = $_POST['service_types'];
        $decoration_types = $_POST['service_category'];
        $description = $_POST['description'];
        $custom_decoration = $_POST['custom_decoration'];
        $price_basic = $_POST['price'];
        
    
        $sql = "INSERT INTO decoration_service (service_name,service_types, service_category, description, custom_decoration, price, event_image, merchant_id) 
                VALUES ('$service_name','$service_type','$decoration_types','$description','$custom_decoration','$price_basic','$event_image','$merchant_id')";              
    }
    

    // **Entertainment Service Submission**
    elseif (isset($_POST['add_entertainment'])) {
        $service_name = $_POST['service_name'];
        $service_type = $_POST['service_type'];
        $service_category = $_POST['service_category'];
        $performance_duration = $_POST['performance_duration'];
        $price_basic = $_POST['price'];
        

        $sql = "INSERT INTO entertainment_service (service_name,service_type,service_category, performance_duration, price, event_image, merchant_id) 
                VALUES ('$service_name','$service_type','$service_category', '$performance_duration', '$price_basic','$event_image', '$merchant_id')";
    }

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('✅Service added successful.');</script>";
        header('Location: 1view_all_service.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
