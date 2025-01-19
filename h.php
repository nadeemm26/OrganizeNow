<?php

session_start();
// echo "This is our home page for organizenow online event book website";

?>
<!-- <h1>Welcome,<?php echo $_SESSION['email'];  ?></h1> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrganizeNow - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f8f9fa;
        }

        /* Navbar */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            padding: 10px 50px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin: 0 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: black;
            font-weight: 600;
        }

        nav ul li a:hover {
            color: #007bff;
        }

        .logo {
            font-weight: bold;
            font-size: 1.5em;
        }

        /* Hero Section */
        .hero {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 100px 50px;
        }

        .hero-text {
            text-align: center;
        }

        .hero-text h1 {
            font-size: 3em;
            color: #333;
        }

        .hero-text p {
            font-size: 1.2em;
            color: #666;
        }

        .hero-text button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1em;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .hero-text button:hover {
            background-color: #0056b3;
        }

        .hero-image {
            max-width: 150%;
        }

        .hero-image img {
            width: 200%;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .banner {
            background: url('banner.jpg') no-repeat center center/cover;
            color: rgb(68, 46, 46);
            text-align: center;
            padding: 100px 20px;
        }

        .services {
            padding: 50px 20px;
            background-color: #ecf0f1;
            text-align: center;
        }

        .service-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .service-item {
            background: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            width: 300px;
        }
    </style>
</head>

<body>

    <nav>
        <div class="logo">Company Logo</div>
        <ul>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact Us</a></li>
            <li><a href="#pricing">Pricing</a></li>
            <li><a href="#resources">Resources</a></li>
            <!-- <li> <?php echo $_SESSION['name'];  ?><li> -->
            <li><a href="ulogin.php">login</a></li>
            <li><a href="logout.php">logout</a></li>

        </ul>

    </nav>

    <section class="hero">
        <div class="hero-text">
            <h1>OrganizeNow</h1>
            <p>"From Concepts To Celebrations"</p>
            <button>Get Started</button>
        </div>
        <div class="hero-image">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQaOlukoq6HUzp7k9oGt6fmNZJSA-GAqWk-qw&s" alt="Event Image">
        </div>
    </section>
    <!-- Banner Section -->
    <section id="home" class="banner">
        <h2>Your Event, Our Expertise</h2>
        <p>Plan your perfect event with Showtime Events.</p>
        <button>Book Now</button>
    </section>

    <!-- Services Section -->
    <section id="services" class="services">
        <h2>Our Services</h2>
        <div class="service-container">
            <div class="service-item">
                <i class="fa fa-calendar"></i>
                <h3>Event Planning</h3>
                <p>Customized solutions for your perfect event.</p>
            </div>
            <div class="service-item">
                <i class="fa fa-cutlery"></i>
                <h3>Catering</h3>
                <p>Delicious menus for every occasion.</p>
            </div>
            <div class="service-item">
                <i class="fa fa-map-marker"></i>
                <h3>Venue Booking</h3>
                <p>Find the perfect venue for your event.</p>
            </div>
        </div>
    </section>

</body>

</html>