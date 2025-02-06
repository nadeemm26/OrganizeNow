<?php

include "sidebarmerchant.php";



?>

<!-- Your main content goes here -->

<div class="header">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['merchant_name']); ?>!</h2>
    <hr>
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

</div>
</body>

</html>