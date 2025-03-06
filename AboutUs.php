<?php
include 'user_navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Hotel Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            color: #333;
        }
        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1, h2, h3 {
            color:rgb(136, 21, 194);
        }
        .section {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        .text {
            flex: 1;
        }
        .image {
            flex: 1;
            text-align: center;
        }
        .image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            padding: 5px 0;
            display: flex;
            align-items: center;
        }
        ul li::before {
            content: '\2713';
            color: green;
            font-weight: bold;
            margin-right: 8px;
        }
        .footer {
            background: url('download1.png') no-repeat center center/cover;
            background-color: #111;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .footer-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .footer-column {
            margin: 20px;
        }
        .footer a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>About Us</h1>
        
        <div class="section">
            <div class="image">
                <img src="who-we-are.jpg" alt="Who We Are">
            </div>
            <div class="text">
                <h2>Who We Are</h2>
                <p>Welcome to <strong>Hotel Management System</strong>, a cutting-edge platform designed to revolutionize the way hotels, resorts, and hospitality businesses operate.</p>
            </div>
        </div>

        <div class="section">
            <div class="text">
                <h2>Our Mission</h2>
                <p>We aim to provide an easy-to-use, efficient, and innovative system to enhance guest experiences and optimize management processes.</p>
            </div>
            <div class="image">
                <img src="download.png" alt="Our Mission">
            </div>
        </div>

        <div class="section">
            <div class="text">
                <h2>What We Offer</h2>
                <ul>
                    <li>Online Booking System</li>
                    <li>Room & Staff Management</li>
                    <li>Payment Integration</li>
                    <li>Guest Profile Management</li>
                    <li>Automated Reports & Analytics</li>
                    <li>Multi-Platform Accessibility</li>
                </ul>
            </div>
        </div>

        <div class="section">
            <div class="text">
                <h2>Why Choose Us?</h2>
                <ul>
                    <li>User-Friendly Interface</li>
                    <li>Scalable & Customizable</li>
                    <li>Data Security & Reliability</li>
                    <li>24/7 Support & Assistance</li>
                </ul>
            </div>
        </div>

        <div class="section">
            <div class="text">
                <h2>Our Vision</h2>
                <p>To be the leading hotel management solution provider, enhancing the hospitality industry with seamless automation and modern technology.</p>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-column">
                <h3>Quick Links</h3>
                <a href="main_home.php">Home</a>
                <a href="about.php">About</a>
                <a href="user_about.php">Venues</a>
                <a href="#">Gallery</a>
                
            </div>
            <div class="footer-column">
                <h3>Services</h3>
                <a href="#">Corporate Events</a>
                <a href="#">Wedding Planner</a>
                <a href="#">Music & Entertainment</a>
                <a href="#">Private Parties</a>
                <a href="#">Destination Wedding</a>
            </div>
            <div class="footer-column">
                <h3>Contact Info</h3>
                <p>OrganizeNow Event Management, bpccs Address</p>
                <p>OrganizeNow Event Management, bpccs Address</p>
                <p>OrganizeNow Event Management, bpccs Address</p>
                <p>📞 +91-850-122-9969</p>
                <p>📧 OrganizeNoweventmanagement@gmail.com</p>
            </div>
        </div>
    </footer>
</body>
</html>
