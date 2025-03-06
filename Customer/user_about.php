<?php
include 'user_navbar.php';
include "connection.php";
?>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Organize Now - About Us</title>
    <!-- <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/> -->
    <style>
        /* Global Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #ece9e6, #ffffff);
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Header Styling */
        h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2c3e50;
            text-transform: uppercase;
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
        }

        h2::after {
            content: '';
            width: 50%;
            height: 4px;
            background: #3498db;
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        /* Section Styling */
        section {
            padding: 80px 10%;
        }

        /* About Section */
        .about-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
        }

        .about-image img {
            width: 100%;
            max-width: 600px;
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }

        .about-image img:hover {
            transform: scale(1.05);
        }

        .about-text {
            max-width: 600px;
        }

        .about-text h3 {
            font-size: 2rem;
            font-weight: bold;
            color: #e74c3c;
        }

        .about-text p {
            font-size: 1.2rem;
            line-height: 1.8;
            margin: 20px 0;
        }

        /* Card Styling */
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .card {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card h3 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #34495e;
        }

        .card p {
            font-size: 1.1rem;
            margin-top: 10px;
            color: #7f8c8d;
        }

        /* Newsletter Section */
        .newsletter {
            background: #3498db;
            color: white;
            padding: 50px 10%;
            text-align: center;
            border-radius: 15px;
        }

        .newsletter input {
            width: 40%;
            padding: 15px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
        }

        .newsletter button {
            padding: 15px 25px;
            border: none;
            background: #2c3e50;
            color: white;
            font-size: 1.1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }

        .newsletter button:hover {
            background: #1a252f;
        }

        /* Footer */
        footer {
            background: #2c3e50;
            color: white;
            padding: 40px 10%;
            text-align: center;
        }

        footer p {
            font-size: 1rem;
            color: #bdc3c7;
        }

        .hover-underline-animation {
            display: inline-block;
            position: relative;
            color: #fff;
        }

        .hover-underline-animation:after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #fff;
            transform-origin: bottom right;
            transition: transform 0.25s ease-out;
        }

        .hover-underline-animation:hover:after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">
    <!-- About Us Section -->
    <!-- <section class="py-16 bg-white"> -->
    <!-- <div class="container mx-auto px-4"> -->
    <div class="text-center ">
        <h2 class="text-4xl font-bold text-blue-800">About Us</h2>
    </div>
    <div class="flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 p-4">
            <img alt="Team working on event planning" class="rounded-lg shadow-lg" height="400" src="https://storage.googleapis.com/a1aa/image/nFkpNIsoLcgCMi2cNNEulmqwdNgrTvdGfTVKpyMuwsY.jpg" width="600" />
        </div>
        <div class="md:w-1/2 p-4">
            <h3 class="text-2xl font-bold mb-4">About Organize Now</h3>
            <p class="mb-4">Organize Now is a recognized and trusted Event Management Company actively working in every field of event organization.</p>
            <p class="mb-4">Organize Now is known as a powerful hotspot, the standard base of the events in media event planning and styling. From hair to publicity, as a new, exclusive and influential organization. Through the span of the most recent couple of years, it worked on planning more than 1,000 events for a group of more than 1 million clients that have profited from their excellent services.</p>
            <p class="mb-4">We ensure that our events are done with excellence, and are thought of as the best. We make sure that our work stands out in the industry and is different from everybody. Creating, discussing and planning in precise and clear terms works.</p>
            <p class="mb-4">Our team has extensive experience in every field of event planning. We are an amalgamation of designers and creators who have a clear inclination for a large-scale event.</p>
        </div>
    </div>
    <!-- </div> -->
    <!-- </section> -->
    <!-- What We Do Section -->
    <!-- <section class="py-16 bg-gray-100"> -->
    <!-- <div class="container mx-auto px-4"> -->
    <div class="text-center">
        <h2 class="text-4xl font-bold text-blue-800">What We Do</h2>
    </div>
    <!-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8"> -->
    <div class="bg-white p-8 shadow-lg hover:shadow-2xl transition-shadow duration-300">
        <h3 class="text-xl font-bold mb-4">Wedding Events</h3>
        <p>We provide every detail for your wedding, destination and weekend events. If you are thinking big, then we will fulfill all the dreams that you have seen for this day. We have many event planning experts who are highly experienced.</p>
    </div>
    <div class="bg-white p-8 shadow-lg hover:shadow-2xl transition-shadow duration-300">
        <h3 class="text-xl font-bold mb-4">Engagement Events</h3>
        <p>We specialize in creating memorable engagement events that reflect your unique love story. From intimate gatherings to grand celebrations, we ensure every detail is perfect.</p>
    </div>
    <div class="bg-white p-8 shadow-lg hover:shadow-2xl transition-shadow duration-300">
        <h3 class="text-xl font-bold mb-4">Anniversary Events</h3>
        <p>Celebrate your milestones with us. We plan and execute anniversary events that are as special as the love you share. Let us make your day unforgettable.</p>
    </div>
    <div class="bg-white p-8 shadow-lg hover:shadow-2xl transition-shadow duration-300">
        <h3 class="text-xl font-bold mb-4">Birthday Events</h3>
        <p>From children's parties to milestone birthdays, we create fun and memorable birthday events. Our team ensures that every birthday is a celebration to remember.</p>
    </div>
    </div>
    </div>
    <!-- </section> -->
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <!-- <div class="container mx-auto px-4"> -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">About Organize Now</h3>
                <p>We are a recognized and trusted Event Management Company actively working in every field of event organization. We ensure that our events are done with excellence, and are thought of as the best.</p>
            </div>
            <!-- <div>
                    <h3 class="text-xl font-bold mb-4">Our Services</h3>
                    <ul>
                        <li><a href="#" class="hover-underline-animation">Brand Promotion</a></li>
                        <li><a href="#" class="hover-underline-animation">Event Planning</a></li>
                        <li><a href="#" class="hover-underline-animation">Wedding Planning</a></li>
                        <li><a href="#" class="hover-underline-animation">Corporate Events</a></li>
                    </ul>
                </div> -->
            <div>
                <h3 class="text-xl font-bold mb-4">Support Team</h3>
                <p><a href="tel:+919871009235" class="hover-underline-animation">+91 - 98710 09235</a></p>
            </div>
        </div>
        <!-- </div> -->
    </footer>
</body>

</html>
