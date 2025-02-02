<?php

include "sidebarmerchant.php";

session_start();
if (!isset($_SESSION['merchant_id'])) {
    header('Location: merchant_login.php');
    exit;
}
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: merchant_login.php');
    exit;
}
?>

<!-- Your main content goes here -->

<div class="header">
    <!-- <h1>
        Welcome, Merchant
    </h1> -->
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['merchant_name']); ?>!</h2>
    <div class="profile">
        <img alt="Profile picture of the merchant" src="https://placehold.co/40x40" />
        <span>
            Merchant Name
        </span>
    </div>
</div>
<div class="dashboard">
    <div class="card">
        <h3>
            Total Events
        </h3>
        <p>
            15
        </p>
    </div>
    <div class="card">
        <h3>
            Upcoming Events
        </h3>
        <p>
            5
        </p>
    </div>
    <div class="card">
        <h3>
            Clients
        </h3>
        <p>
            20
        </p>
    </div>
    <div class="card">
        <h3>
            Revenue
        </h3>
        <p>
            $5000
        </p>
    </div>
</div>
<div class="events">
    <h2>
        Upcoming Events
    </h2>
    <div class="event">
        <img alt="Image of a wedding event with decorations and guests" src="https://placehold.co/100x100" />
        <div class="event-details">
            <h4>
                Wedding Event
            </h4>
            <p>
                Date: 2023-10-15
            </p>
            <p>
                Location: Central Park
            </p>
        </div>
    </div>
    <div class="event">
        <img alt="Image of a corporate event with a stage and audience" src="https://placehold.co/100x100" />
        <div class="event-details">
            <h4>
                Corporate Meeting
            </h4>
            <p>
                Date: 2023-10-20
            </p>
            <p>
                Location: Downtown Conference Center
            </p>
        </div>
    </div>
    <div class="event">
        <img alt="Image of a birthday party with balloons and cake" src="https://placehold.co/100x100" />
        <div class="event-details">
            <h4>
                Birthday Party
            </h4>
            <p>
                Date: 2023-10-25
            </p>
            <p>
                Location: Riverside Club
            </p>
        </div>
    </div>
    <div class="event">
        <img alt="Image of a music concert with a band performing on stage"
            src="https://placehold.co/100x100" />
        <div class="event-details">
            <h4>
                Music Concert
            </h4>
            <p>
                Date: 2023-10-30
            </p>
            <p>
                Location: City Arena
            </p>
        </div>
    </div>
    <div class="event">
        <img alt="Image of a charity event with people donating and volunteering"
            src="https://placehold.co/100x100" />
        <div class="event-details">
            <h4>
                Charity Event
            </h4>
            <p>
                Date: 2023-11-05
            </p>
            <p>
                Location: Community Hall
            </p>
        </div>
    </div>
</div>
<div class="news">
    <h2>
        Latest News
    </h2>
    <div class="news-item">
        <img alt="Image of a news article about event management trends" src="https://placehold.co/100x100" />
        <div class="news-details">
            <h4>
                Event Management Trends 2023
            </h4>
            <p>
                Stay updated with the latest trends in event management for 2023.
            </p>
        </div>
    </div>
    <div class="news-item">
        <img alt="Image of a news article about a successful event" src="https://placehold.co/100x100" />
        <div class="news-details">
            <h4>
                Successful Corporate Event
            </h4>
            <p>
                Read about our recent successful corporate event held in Downtown.
            </p>
        </div>
    </div>
    <div class="news-item">
        <img alt="Image of a news article about new event venues" src="https://placehold.co/100x100" />
        <div class="news-details">
            <h4>
                New Event Venues
            </h4>
            <p>
                Discover new event venues available for booking in 2023.
            </p>
        </div>
    </div>
</div>


        <h2>Welcome to the Merchant Dashboard</h2>
        <p>This is where you can manage your events, bookings, and payments.</p>
    </div>
</body>
</html>