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
        $venue_name = $_POST['venue_name'];
        $venue_type = $_POST['venue_type'];
        $capacity = $_POST['capacity'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $pincode = $_POST['pincode'];
        $price = $_POST['price'];

        $sql = "INSERT INTO venue_booking (venue_name, venue_type, capacity, address, city, pincode, price_per_day, event_image, merchant_id) 
                VALUES ('$venue_name', '$venue_type', '$capacity', '$address', '$city', '$pincode', '$price', '$event_image', '$merchant_id')";
    }

    // **Catering Service Submission**
    elseif (isset($_POST['add_catering'])) {
        $catering_name = $_POST['catering_name'];
        $cuisine_type = implode(',',$_POST['cuisine_types']) ;// Convert array to string
        $menu_details = $_POST['menu_details'];
        $capacity = $_POST['capacity'];
        $price_veg = $_POST['price_veg'];
        $price_nonveg = $_POST['price_nonveg'];
        $min_order = $_POST['min_order'];

        $sql = "INSERT INTO catering_service (catering_name, cuisine_type, menu_details, capacity, price_veg, price_nonveg, min_order, event_image, merchant_id) 
                VALUES ('$catering_name', '$cuisine_type', '$menu_details', '$capacity', '$price_veg', '$price_nonveg', '$min_order', '$event_image', '$merchant_id')";
    }

    // **Photography Service Submission**
    elseif (isset($_POST['add_photography'])) {
        $service_name = $_POST['service_name'];
        $photography_types = implode(',', $_POST['photography_types']); // Convert array to string
        $videography = $_POST['videography'];
        $package_desc = $_POST['package_desc'];
        $coverage_duration = $_POST['coverage_duration'];
        $num_photographers = $_POST['num_photographers'];
        $editing = $_POST['editing'];
        $price_basic = $_POST['price_basic'];
        $price_premium = $_POST['price_premium'];

        $sql = "INSERT INTO photography_service (service_name, photography_types, videography, package_desc, coverage_duration, num_photographers, editing, price_basic, price_premium, event_image, merchant_id) 
                VALUES ('$service_name', '$photography_types', '$videography', '$package_desc', '$coverage_duration', '$num_photographers', '$editing', '$price_basic', '$price_premium', '$event_image', '$merchant_id')";
    }

    // **Decoration Service Submission**
    elseif (isset($_POST['add_decoration'])) {
        $decoration_types = isset($_POST['decoration_types']) ? implode(',', $_POST['decoration_types']) : ''; // Fix array to string conversion
        $description = $_POST['description'];
        $custom_decoration = $_POST['custom_decoration'];
        $price_basic = $_POST['price_basic'];
        $price_premium = $_POST['price_premium'];
    
        $sql = "INSERT INTO decoration_service (decoration_types, description, custom_decoration, price_basic, price_premium, event_image, merchant_id) 
                VALUES ('$decoration_types', '$description', '$custom_decoration', '$price_basic', '$price_premium', '$event_image', '$merchant_id')";              
    }
    

    // **Entertainment Service Submission**
    elseif (isset($_POST['add_entertainment'])) {
        $service_type = $_POST['service_type'];
        $performance_duration = $_POST['performance_duration'];
        $price_basic = $_POST['price_basic'];
        $price_premium = $_POST['price_premium'];

        $sql = "INSERT INTO entertainment_service (service_type, performance_duration, price_basic, price_premium, event_image, merchant_id) 
                VALUES ('$service_type', '$performance_duration', '$price_basic', '$price_premium', '$event_image', '$merchant_id')";
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
