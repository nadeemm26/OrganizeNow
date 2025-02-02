<?php
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
?>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organize Now</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* General Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        header.navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #34495e;
            color: #ecf0f1;
            padding: 10px 20px;
            position: fixed;
            width: 100%;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 15px;
            margin-right: 50px;
        }

        .navbar ul li {
            display: inline;
        }

        .navbar ul li a {
            text-decoration: none;
            color: #ecf0f1;
            font-weight: bold;

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

        .dashboard-section {
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            height: 100vh;
            padding: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li a {
            display: block;
            padding: 10px;
            color: white;
            text-decoration: none;
        }

        footer {
            background-color: #222;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        .footer-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .footer-content h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        form input,
        form textarea {
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 100%;
        }

        form button {
            padding: 10px;
            border: none;
            background-color: #ff5722;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #e64a19;
        }

        .footer-bottom {
            margin-top: 20px;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <!-- Main Navigation Bar -->
    <header class="navbar">
        <div class="logo">
            <h1>OrganizeNow</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="#profile" class="admin-link"><?php echo htmlspecialchars($_SESSION['user_name']); ?></a></li>
                <li><a href="?logout=true">Logout</a></li>
            </ul>
        </nav>
    </header>

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

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <footer>
            <div class="footer-container">
                <div class="footer-content">
                    <h3>Contact Us</h3>
                    <form id="contact-form" action="process_form.php" method="POST">
                        <input type="text" name="name" placeholder="Your Name" required>
                        <input type="email" name="email" placeholder="Your Email" required>
                        <textarea name="message" placeholder="Your Message" rows="4" required></textarea>
                        <button type="submit">Send</button>
                    </form>
                </div>
                <div class="footer-bottom">
                    <p>&copy; 2025 OrganizeNow. All rights reserved.</p>
                </div>
            </div>
        </footer>
        <script>
            document.getElementById('contact-form').addEventListener('submit', function(e) {
                const form = e.target;
                const formData = new FormData(form);

                fetch(form.action, {
                        method: form.method,
                        body: formData,
                    })
                    .then(response => {
                        if (response.ok) {
                            alert('Form submitted successfully!');
                            form.reset();
                        } else {
                            alert('Failed to submit form.');
                        }
                    })
                    .catch(error => {
                        alert('An error occurred. Please try again.');
                        console.error(error);
                    });

                e.preventDefault();
            });
        </script>
    </section>
</body>

</html>