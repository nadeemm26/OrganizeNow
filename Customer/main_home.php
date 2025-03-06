<?php
include 'user_navbar.php';
include "../connection.php";
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

        #search-results {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        /* Slider Container */
        .slider-container {
            width: 100%;
            max-width: 1700px;
            margin: 20px auto;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }

        /* Swiper Wrapper */
        .swiper {
            width: 100%;
            height: 500px;
        }

        /* Swiper Slide */
        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Navigation Buttons */
        .swiper-button-next,
        .swiper-button-prev {
            color: white;
        }

        /* Pagination Dots */
        .swiper-pagination-bullet {
            background: white;
            opacity: 0.8;
        }

        .swiper-pagination-bullet-active {
            background: #007bff;
        }
    </style>
    <!-- Swiper.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>


<!-- 🏠 Home Page Slider -->
<div class="slider-container">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="../1.jpg" alt="Wedding Event">
            </div>
            <div class="swiper-slide">
                <img src="../2.jpg" alt="Birthday Event">
            </div>
            <div class="swiper-slide">
                <img src="../3.jpg" alt="Concert Event">
            </div>
            <div class="swiper-slide">
                <img src="../4.jpg" alt="Corporate Event">
            </div>
            <div class="swiper-slide">
                <img src="../5.jpg" alt="Corporate Event">
            </div>
            <!-- <div class="swiper-slide">
                    <img src="" alt="Concert Event">
                </div>
                <div class="swiper-slide">
                    <img src="" alt="Birthday Party">
                </div>
                <div class="swiper-slide">
                    <img src="" alt="Wedding Event">
                </div> -->
        </div>
        <!-- Pagination (Dots) -->
        <div class="swiper-pagination"></div>
        <!-- Navigation Buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

<!-- search bar -->
<div id="search-results"></div>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Services Grid</title>
    <style>
        /* Google Font */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        .title1 {
            font-size: 36px;
            color: #333;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .grid-container1 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            justify-content: center;
            padding: 20px;
            max-width: 1700px;
            margin: auto;
        }

        .card1 {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .card1 img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
        }

        .card1 h3 {
            margin-top: 15px;
            font-size: 18px;
            font-weight: 600;
            color: #555;
        }

        /* Hover Effect */
        .card1:hover {
            transform: translateY(-10px) rotateX(10deg) rotateY(5deg);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
    <h2 class="title1">Our Services & Events</h2>
    <div class="grid-container1">
        <div class="card1">
            <img src="../1.jpg" alt="Catering">
            <h3>Catering Service</h3>
        </div>

        <div class="card1">
            <img src="../2.jpg" alt="Venue">
            <h3>Venue Service</h3>
        </div>

        <div class="card1">
            <img src="../3.jpg" alt="Decoration">
            <h3>Decoration Service</h3>
        </div>

        <div class="card1">
            <img src="../4.jpg" alt="Photography">
            <h3>Photography Service</h3>
        </div>

        <div class="card1">
            <img src="../1.jpg" alt="Entertainment">
            <h3>Entertainment Service</h3>
        </div>

        <div class="card1">
            <img src="../2.jpg" alt="Wedding">
            <h3>Wedding Event</h3>
        </div>

        <div class="card1">
            <img src="../3.jpg" alt="Birthday">
            <h3>Birthday Party</h3>
        </div>

        <div class="card1">
            <img src="../4.jpg" alt="Anniversary">
            <h3>Anniversary Event</h3>
        </div>

        <div class="card1">
            <img src="../1.jpg" alt="Engagement">
            <h3>Engagement Event</h3>
        </div>

        <div class="card1">
            <img src="../2.jpg" alt="Other">
            <h3>Other Events</h3>
        </div>
    </div>
</body>

</html>

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
                    <h2 class="card-title"><?php echo $row['service_type']; ?></h2>
                    <p><strong>Service Price:</strong> ₹<?php echo number_format($row['price'], 2); ?></p>

                    <!-- Book Now(Passing Merchant ID) -->
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


</div>
<script>
    function searchService() {
        let searchText = document.getElementById("search").value;

        if (searchText.length > 1) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "search_service.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("search-results").innerHTML = xhr.responseText;
                }
            };
            xhr.send("query=" + searchText);
        } else {
            document.getElementById("search-results").innerHTML = "";
        }
    }
</script>
<!-- Swiper.js Script -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>

</body>

</html>