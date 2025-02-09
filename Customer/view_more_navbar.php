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
            <div class="tab" >Venue Booking</div>
            <div class="tab" >Decoration Booking</div>
            <div class="tab" >Catering Booking</div>
            <div class="tab" >Photography Booking</div>
            <div class="tab" >Entertainment Booking</div>
        </div>