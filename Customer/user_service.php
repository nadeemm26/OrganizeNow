<?php
include 'user_navbar.php';
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 93%;
            margin: 4px 20px;
            padding: 45px 33px;

        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Tabs Navigation */
        .tab-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            background: #007bff;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            transition: 0.3s;
        }

        .tab:hover {
            background: #0056b3;
        }

        .tab.active {
            background: #004080;
        }

        /* Service Grid */
        .service-container {
            display: none;
            /* Hidden by default */
        }

        .service-container.active {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            /* Har row me sirf 3 items */
            gap: 20px;
            justify-content: center;
        }

        @media (max-width: 900px) {
            .service-container.active {
                grid-template-columns: repeat(2, 1fr);
                /* Small screens: 2 items per row */
            }
        }

        @media (max-width: 600px) {
            .service-container.active {
                grid-template-columns: repeat(1, 1fr);
                /* Mobile screens: 1 item per row */
            }
        }

        /* Service Cards */
        .card {
            background: #bbcceb75;
            ;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            padding: 15px;
            text-align: center;
            transition: 0.06s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 5px;
        }

        .card h3 {
            margin-top: 10px;
            color: #333;
        }

        .card p {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }
        .book-btn {
            display: inline-block;
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .book-btn:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Available Event Services</h2>

        <!-- Navigation Tabs -->
        <div class="tab-container">
            <div class="tab active" onclick="showService('venue')">Venue Booking</div>
            <div class="tab" onclick="showService('decoration')">Decoration Booking</div>
            <div class="tab" onclick="showService('catering')">Catering Booking</div>
            <div class="tab" onclick="showService('photography')">Photography Booking</div>
            <div class="tab" onclick="showService('entertainment')">Entertainment Booking</div>
        </div>

        <!-- Services Grid -->
        <!-- venue -->
        <div id="venue" class="service-container active">
            <?php
            $sql = "SELECT * FROM venue_booking";
            $result = $conn->query($sql);
            
            while ($row = $result->fetch_assoc()) {
                $venue_id = array_keys($row)[0];
                echo '<div class="card">
                <img src="' . $row["event_image"] . '" class="card-img-top" alt="Venue Image">
                <div class="card-body">
                    <h3 class="card-title">' . $row["venue_name"] . '</h3>
                    <p><strong>Type: </strong>' . $row["venue_type"] . '</p>
                    <p><strong>Capacity: </strong>' . $row["capacity"] . ' People</p>
                    <p><strong>Address: </strong>' . $row["address"] . ' <strong>City: </strong>' . $row["city"] . '  <strong>Pincode: </strong>' . $row["pincode"] . '</p>
                    <p><strong>Price Per Day: </strong>₹' . $row["price_per_day"] . '</p>
                    <a href="" class="book-btn">Book Now</a>
                    <a href="view_more.php?id=<?php echo '.$row[$venue_id].'; ?>" class="book-btn">View More</a>                    
                </div>
                </div>';
            }
            ?>
        </div>
        <!-- decoration -->
        <div id="decoration" class="service-container">
            <?php
            $sql = "SELECT * FROM decoration_service";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">
                <img src="' . $row["event_image"] . '" class="card-img-top" alt="Decoration Image">
                <div class="card-body">
                    <h3 class="card-title">' . $row["decoration_types"] . ' Decoration</h3>
                    <p class="card-text"><strong>Description: </strong>' . $row["description"] . '</p>
                    <p><strong>Custom Decoration: </strong>' . $row["custom_decoration"] . '</p>
                    <p><strong>Basic Price: </strong>₹' . $row["price_basic"] . '</p>
                    <p><strong>Premium Price: </strong>₹' . $row["price_premium"] . '</p>
                    <a href="" class="book-btn">Book Now</a>
                </div>
                </div>';
            }
            ?>
        </div>
        <!-- entertainment -->
        <div id="entertainment" class="service-container">
            <?php
            $sql = "SELECT * FROM entertainment_service";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">
                <img src="' . $row["event_image"] . '" class="card-img-top" alt="Entertainment Image">
                <div class="card-body">
                    <h3 class="card-title">' . $row["service_type"] . '</h3>
                    <p><strong>Duration: </strong>' . $row["performance_duration"] . '</p>
                    <p><strong>Basic Price: </strong>₹' . $row["price_basic"] . '</p>
                    <p><strong>Premium Price: </strong>₹' . $row["price_premium"] . '</p>
                    <a href="" class="book-btn">Book Now</a>
                </div>
                </div>';
            }
            ?>
        </div>
        <!-- catering -->
        <div id="catering" class="service-container">
            <?php
            $sql = "SELECT * FROM catering_service";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">
                <img src="' . $row["event_image"] . '" class="card-img-top" alt="Catering Image">
                <div class="card-body">
                    <h3 class="card-title">' . $row["catering_name"] . '</h3>
                    <p><strong>Cuisine Type: </strong>' . $row["cuisine_types"] . '</p>
                    <p><strong>Capacity: </strong>' . $row["capacity"] . '</p>
                    <p><strong>Minimum Order: </strong>' . $row["min_order"] . '</p>
                    <p><strong>Menu Details: </strong>' . $row["menu_details"] . '</p> 
                    <p><strong>Veg Price Per Plat: </strong>₹' . $row["price_veg"] . '</p>
                    <p><strong>Nonveg Price Per Plat: </strong>₹' . $row["price_nonveg"] . '</p>
                    <a href="" class="book-btn">Book Now</a>
                </div>
                </div>';
            }
            ?>
        </div>
        <!-- photography -->
        <div id="photography" class="service-container">
            <?php
            $sql = "SELECT * FROM photography_service";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">
                <img src="' . $row["event_image"] . '" class="card-img-top" alt="Photography Image">
                <div class="card-body">
                    <h3 class="card-title">' . $row["service_name"] . '</h3>
                    <p><strong>Photography Type: </strong>' . $row["photography_types"] . '</p>
                    <p><strong>Videohraphy: </strong>' . $row["videography"] . '<strong> Editing: </strong>' . $row["editing"] . '</p>
                    <p><strong>Shooter: </strong>' . $row["num_photographers"] . '</p>
                    <p><strong>Details: </strong>' . $row["package_desc"] . '</p> 
                    <p><strong>Coverage Duration: </strong>' . $row["coverage_duration"] . '</p>
                    <p><strong>Basic Price: </strong>₹' . $row["price_basic"] . '</p>
                    <p><strong>Premium Price: </strong>₹' . $row["price_premium"] . '</p>
                    <a href="" class="book-btn">Book Now</a>
                </div>';
            }
            ?>
        </div>
    </div>

    <script>
        function showService(serviceId) {
            // Hide all service containers
            document.querySelectorAll('.service-container').forEach(el => el.classList.remove('active'));

            // Show the selected service container
            document.getElementById(serviceId).classList.add('active');

            // Update tab styles
            document.querySelectorAll('.tab').forEach(el => el.classList.remove('active'));
            event.target.classList.add('active');
        }
    </script>

</body>

</html>