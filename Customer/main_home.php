<?php
include 'user_navbar.php';
include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* Container */
        .container {
            width: 90%;
            max-width: 95%;
            margin: 17px;
        }

        /* Heading */
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Card Layout */
        .row {
            display: flex;
            flex-wrap: wrap;
            /* justify-content: center; */
            gap: 20px;
        }

        .card {
            width: 400px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
            overflow: hidden;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
            text-align: center;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
        }

        p {
            margin: 5px 0;
        }

        /* Button */
        .btn {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn:hover {
            background: #0056b3;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background: white;
            padding: 20px;
            width: 90%;
            max-width: 400px;
            margin: 10% auto;
            border-radius: 10px;
            position: relative;
            text-align: center;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 30px;
            padding-bottom: 20px;
        }

        .modal-header h5 {
            margin: 0;
        }

        .close-btn {
            cursor: pointer;
            font-size: 30px;
            font-weight: bold;
            color: red;
        }

        input {
            width: 90%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn-success {
            background: green;
            color: white;
        }

        .book-now {
            background: #007bff;
            display: inline-block;
            color: white;
            padding: 10px 6px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            width: 97%;
            margin-top: 5px;
        }

        .view-more {
            display: inline-block;
            background: #0056b3;
            color: white;
            padding: 10px 6px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            width: 97%;
            /* padding: 5px; */
            margin-top: 5px;
            /* border-radius: 5px; */
            /* border: 1px solid #ccc; */
        }
    </style>
</head>

<body>
    <h2>Available Services</h2>

    <?php
    // Array of service tables with their display names
    $services = [
        'catering_service' => 'Catering Service',
        'decoration_service' => 'Decoration Service',
        'photography_service' => 'Photography Service',
        'entertainment_service' => 'Entertainment Service',
        'venue_booking' => 'Venue Booking'
    ];

    foreach ($services as $service_table => $service_name) {
        echo "<h3>$service_name</h3>";
        echo "<div class='row'>";


        // Update this section in your existing services listing file
        $query = "SELECT * FROM $service_table";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
    ?>
                <div class="card">
                    <img src="../Merchant/<?php echo $row['event_image']; ?>" alt="Service Image">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $row['service_name']; ?></h4>
                        <!-- <p><strong>Duration:</strong> <?php echo isset($row['performance_duration']) ? $row['performance_duration'] : 'N/A'; ?></p> -->
                        <p><strong>Service Price:</strong> ₹<?php echo number_format($row['price'], 2); ?></p>

                        <!-- Book Now Link (Passing Merchant ID) -->
                        <a href="book_service.php?id=<?php echo $row['service_id']; ?>&type=<?php echo $service_table; ?>&merchant_id=<?php echo $row['merchant_id']; ?>" class="btn book-now">
                            Book Now
                        </a>

                        <!-- View More Link -->
                        <a href="service_details.php?id=<?php echo $row['service_id']; ?>&type=<?php echo $service_table; ?>" class="view-more">
                            View More
                        </a>
                    </div>
                </div>
    <?php
            }
        } else {
            echo "<p class='text-center'>No services available in $service_name.</p>";
        }

        echo "</div>"; // Add a separator between service categories
    }
    ?>




    <!-- Booking Modal -->
    <!-- <div class="modal" id="bookingModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Book Entertainment Service</h5>
                <span class="close-btn">&times;</span>
            </div>

            <form action="process_booking.php" method="POST">
                <input type="hidden" name="service_id" id="service_id">
                <input type="hidden" name="service_type" id="service_type">

                <label>Selected Service</label>
                <input type="text" id="selected_service" disabled>

                <label>Price</label>
                <input type="text" id="price" disabled>

                <label>Select Date</label>
                <input type="date" name="booking_date" required>

                <label>Your Name</label>
                <input type="text" name="customer_name" required>

                <label>Your Email</label>
                <input type="email" name="customer_email" required>

                <label>Your Mobile</label>
                <input type="text" name="customer_mobile" required>

                <button type="submit" class="btn-success">Confirm Booking</button>
            </form>
        </div>
    </div> -->

    <!-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modal = document.getElementById("bookingModal");
            var closeBtn = document.querySelector(".close-btn");
            var buttons = document.querySelectorAll(".open-modal");

            buttons.forEach(function(button) {
                button.addEventListener("click", function() {
                    var serviceId = button.getAttribute("data-service-id");
                    var serviceType = button.getAttribute("data-service-type");
                    var price = button.getAttribute("data-price");

                    document.getElementById("service_id").value = serviceId;
                    document.getElementById("service_type").value = serviceType;
                    document.getElementById("selected_service").value = serviceType;
                    document.getElementById("price").value = "₹" + parseFloat(price).toFixed(2);

                    modal.style.display = "block";
                });
            });

            closeBtn.addEventListener("click", function() {
                modal.style.display = "none";
            });

            window.addEventListener("click", function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            });
        });
    </script> -->
    </div>
</body>

</html>