<!-- <?php
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: user_login.php');
            exit;
        }

        // Logout functionality
        if (isset($_GET['logout'])) {
            session_destroy();
            header('Location: user_login.php');
            exit;
        }
        ?> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrganizeNow-User</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
        }

        .navbar {
            background-color: white;
            width: auto;
            padding: 25px 80px;
            box-shadow: 0 10px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 94%;
            top: 0;
            z-index: 1000;
        }

        .navbar a {
            text-decoration: none;
            color: #333;
            margin: 0px 25px;
            font-weight: 700;
        }

        .navbar a:hover {
            color: #007bff;
        }

        .container {
            padding: 80px;

        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="logo">
            <a href="main_home.php">User Dashboard</a>
        </div>
        <div class="nav-links">
            <a href="main_home.php">Home</a>
            <a href="user_about.php">About Us</a>
            <a href="user_service.php">Services</a>
            <a href="user_event.php">My Events</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Log Out</a>
        </div>
    </div>
    <div class="container">