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

        /* Navbar Styling */
        .navbar {
            background-color: white;
            width: 100%;
            padding: 15px 30px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .container {
            padding: 80px;
        }

        /* Logo and Links */
        .navbar .logo a {
            text-decoration: none;
            color: #333;
            font-size: 22px;
            font-weight: 700;
        }

        .nav-links {
            /* margin-top: 10px; */
            width: 475px;
            margin: 0 15px;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            margin: 0 11px;
            font-weight: 700;
            transition: 0.3s;
            /* padding: 5px 5px; */
            border-radius: 5px;
        }

        .nav-links a:hover {
            color: #007bff;
        }

        .nav-links a.active {
            /* background-color: #007bff; */
            color: #007bff;
            border-radius: 5px;
            transition: 0.3s;
        }

        /* Centered Search Bar */
        .search-container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
        }

        #search {
            width: 60%;
            max-width: 400px;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 20px;
            border: 2px solid #ccc;
            outline: none;
            transition: 0.3s ease-in-out;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
        }

        #search:focus {
            border-color: #007bff;
            box-shadow: 2px 2px 12px rgba(0, 123, 255, 0.5);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 15px;
            }

            .search-container {
                margin-top: 10px;
                width: 100%;
                justify-content: center;
            }

            #search {
                width: 80%;
            }

            .nav-links {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .nav-links a {
                display: block;
                width: 100%;
                text-align: center;
                padding: 10px;
            }

        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navLinks = document.querySelectorAll(".nav-links a");

            // Get current URL path
            let currentPage = window.location.pathname.split("/").pop();

            navLinks.forEach(link => {
                let linkPage = link.getAttribute("href").split("/").pop();
                if (linkPage === currentPage) {
                    link.classList.add("active");
                }
            });

            // Click event se active class update karna
            navLinks.forEach(link => {
                link.addEventListener("click", function() {
                    navLinks.forEach(nav => nav.classList.remove("active"));
                    this.classList.add("active");
                });
            });
        });
    </script>
</head>

<body>
    <div class="navbar">
        <div class="logo">
            <a href="main_home.php"> Organize Now </a>
        </div>
        <div class="search-container">
            <input type="text" id="search" placeholder="Search for services..." onkeyup="searchService()">
        </div>
        <div class="nav-links">
            <a href="main_home.php">Home</a>
            <a href="user_about.php">About Us</a>
            <a href="user_event.php">My Events</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Log Out</a>
        </div>
    </div>
    <div class="container">