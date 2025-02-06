<?php

include "sidebarmerchant.php";
include "connection.php";

// Ensure merchant is logged in
if (!isset($_SESSION['merchant_id'])) {
    die("Error: Merchant not logged in.");
}

$merchant_id = $_SESSION['merchant_id'];

// Fetch all events created by this merchant
$sql = "SELECT * FROM events WHERE merchant_id = '$merchant_id'";
$result = $conn->query($sql);
?>

<div class="header">
    <h1>My Events</h1>
    <hr>
</div>
<!-- event 3 button -->
<div class="event-button">
    <div class="add-event">
        <button onclick="showForm('addEventForm')">Add New Event</button>
    </div>
    <div class="add-service">
        <button onclick="showForm('addServiceForm')">Add New Service</button>
    </div>
    <div class="view-event">
        <button onclick="showForm('viewEventForm')">View All Event</button>
    </div>
</div>

<!-- Add New Event Form -->
<div id="addEventForm" class="form-container">
    <h2>Add New Event</h2>
    <!-- <form action="add_new_event.php" method="post" enctype="multipart/form-data"> -->
    <form action="create_event.php" method="POST" enctype="multipart/form-data">

        <label for="eventname">Event Name</label>
        <input type="text" name="eventname" required>

        <label>Event Type:</label>
        <select name="eventype" required>
            <option value="Wedding">Wedding</option>
            <option value="Engagement">Engagement</option>
            <option value="Anniversary">Anniversary</option>
            <option value="Birthday">Birthday</option>
            <option value="Other">Other Event</option>
        </select>

        <label>Description:</label>
        <textarea name="eventdescription" required></textarea>

        <!-- <label>Date:</label>
        <input type="date" name="date" required> -->

        <label>Location:</label>
        <input type="text" name="location" required>

        <label>Price:</label>
        <input type="text" name="price" required>

        <label>Upload Event Image:</label>
        <input type="file" name="event_image" required>

        <h3>Select Services Provided:</h3>
        <!-- checkbox for venue Booking -->
        <div>
            <input type="checkbox" id="venue" name="services[]" value="Venue" onclick="toggleServiceDetails('venue')">
            <label for="venue">Venue</label>
            <div id="venue_details" style="display: none;">
                <form method="POST">
                    <input type="text" name="venue_name" placeholder="Venue Name">
                    <select name="venue_type" required>
                        <option>Select Venue Type</option>
                        <option value="Banquet Hall">Banquet Hall</option>
                        <option value="Lawn">Lawn</option>
                        <option value="Hotel">Hotel</option>
                        <option value="Resort">Resort</option>
                    </select>
                    <input type="number" name="capacity" placeholder="Capacity:" required>
                    <textarea name="venue_desc" placeholder="Venue Details"></textarea>
                    <input type="number" name="price" placeholder="Price (Per Day)" required>
                </form>
            </div>
        </div>
        <!-- checkbox for Catering Service -->
        <div>
            <input type="checkbox" id="catering" name="services[]" value="Catering Service" onclick="toggleServiceDetails('catering')">
            <label for="catering">Catering Service</label>
            <div id="catering_details" style="display: none;">
                <form method="POST">

                    <input type="text" name="catering_name" placeholder="Catering Name:" required>

                    <select name="cuisine_types[]" multiple required>
                        <option>Select Cuisine Type: </option>
                        <option value="Indian">Indian</option>
                        <option value="Chinese">Chinese</option>
                        <option value="Continental">Continental</option>
                        <option value="Italian">Italian</option>
                    </select>

                    <!-- <label>Menu Details:</label> -->
                    <textarea name="menu_details" placeholder="Add your menu details here..." required></textarea>

                    <!-- <label>Capacity (Max People Served):</label> -->
                    <input type="number" name="capacity" placeholder="Capacity (Max People Served):" required>

                    <!-- <label>Price Per Plate (Veg):</label> -->
                    <input type="number" name="price_veg" placeholder="Price Per Plate (Veg):" required>

                    <!-- <label>Price Per Plate (Non-Veg):</label> -->
                    <input type="number" name="price_nonveg" placeholder="Price Per Plate (Non-Veg):" required>

                    <!-- <label>Minimum Order Quantity:</label> -->
                    <input type="number" name="min_order" placeholder="Minimum Order Quantity:" required>

                </form>
            </div>
        </div>
        <!-- checkbox for Photography & Videography -->
        <div>
            <input type="checkbox" id="photography" name="services[]" value="Photography" onclick="toggleServiceDetails('photography')">
            <label for="photography">Photography & Videography</label>
            <div id="photography_details" style="display: none;">
                <form method="POST">

                    <textarea name="package_desc" placeholder="Package Description"></textarea>

                    <input type="number" name="num_photographers" placeholder="Number of Photographers/Videographers">

                    <input type="number" name="price_basic" placeholder="Basic Package Price (₹):">

                    <input type="number" name="price_premium" placeholder="Premium Package Price (₹):">
                    <!-- <input type="text" name="photography_price" placeholder="Photography Price"> -->
                </form>
            </div>
        </div>
        <!-- checkbox for Decoration Booking -->
        <div>
            <input type="checkbox" id="decoration" name="services[]" value="Decoration" onclick="toggleServiceDetails('decoration')">
            <label for="decoration">Decoration</label>
            <div id="decoration_details" style="display: none;">
                <form method="POST">
                    <textarea name="description" placeholder="Decoration Description"></textarea>

                    <input type="number" name="price_basic" placeholder="Basic Package Price (₹)">

                    <input type="number" name="price_premium" placeholder="Premium Package Price (₹)">
                </form>
            </div>
        </div>
        <!-- checkbox for Entertainment -->
        <div>
            <input type="checkbox" id="entertainment" name="services[]" value="Entertainment" onclick="toggleServiceDetails('entertainment')">
            <label for="entertainment">Entertainment</label>
            <div id="entertainment_details" style="display: none;">
                <form method="POST">
                    <select name="service_type" required>
                        <option>Service Type:</option>
                        <option value="Music">Music</option>
                        <option value="Dance">Dance</option>
                        <option value="Comedy">Comedy</option>
                        <option value="Magic Show">Magic Show</option>
                    </select>
                    <textarea name="description" placeholder="entertainment Description"></textarea>
                    <input type="number" name="price_basic" placeholder="Basic Package Price (₹)">
                    <input type="number" name="price_premium" placeholder="Premium Package Price (₹)">
                </form>
            </div>
        </div>

        <button type="submit">Create Event</button>
    </form>
    <!-- script for switch checkboxes -->
    <script>
        function toggleServiceDetails(service) {
            var details = document.getElementById(service + "_details");
            if (document.getElementById(service).checked) {
                details.style.display = "block";
            } else {
                details.style.display = "none";
            }
        }
    </script>
</div>

<!-- Add Service Form -->
<div id="addServiceForm" class="form-container">
    <h2>Select a Service</h2>
    <select id="serviceDropdown" onchange="showFormm()">
        <option value="">Select Service</option>
        <option value="venue">Venue Booking</option>
        <option value="catering">Catering Service</option>
        <option value="photography">Photography & Videography</option>
        <option value="decoration">Decoration</option>
        <option value="entertainment">Entertainment</option>
    </select>

    <!-- Venue Booking Form -->
    <div id="venueForm" class="service-form-container">
        <!-- <form method="post" action="venue_service_db.php" enctype="multipart/form-data"> -->
        <form method="POST" action="submit_service.php" enctype="multipart/form-data">

        <input type="text" name="venue_name" placeholder="Venue Name">
            <select name="venue_type">
                <option>Venue Type</option>
                <option value="Banquet Hall">Banquet Hall</option>
                <option value="Lawn">Lawn</option>
                <option value="Hotel">Hotel</option>
                <option value="Resort">Resort</option>
            </select>
            <input type="number" name="capacity" placeholder="Capacity:">
            <input type="text" name="address" placeholder="Address">
            <input type="text" name="city" placeholder="City">
            <input type="text" name="pincode" placeholder="Pincode">
            <input type="number" name="price" placeholder="Price (Per Day)">
            <label>Upload Event Image:</label>
            <input type="file" name="event_image" required>
            <button type="submit" name="add_venue">Add Venue</button>
        </form>
    </div>

    <!-- Catering Service Form -->
    <div id="cateringForm" class="service-form-container">
        <form method="POST" action="submit_service.php" enctype="multipart/form-data">

            <label>Catering Name:</label>
            <input type="text" name="catering_name" required>

            <label>Cuisine Type:</label>
            <select name="cuisine_types[]" required>
                <option value="Indian">Indian</option>
                <option value="Chinese">Chinese</option>
                <option value="Continental">Continental</option>
                <option value="Italian">Italian</option>
            </select>

            <label>Menu Details:</label>
            <textarea name="menu_details" placeholder="Add your menu details here..." required></textarea>

            <label>Capacity (Max People Served):</label>
            <input type="number" name="capacity" required>

            <label>Price Per Plate (Veg):</label>
            <input type="number" name="price_veg" required>

            <label>Price Per Plate (Non-Veg):</label>
            <input type="number" name="price_nonveg" required>

            <label>Minimum Order Quantity:</label>
            <input type="number" name="min_order" required>

            <label>Upload Event Image:</label>
            <input type="file" name="event_image" required>

            <button type="submit" name="add_catering">Add Catering</button>
        </form>
    </div>

    <!-- Photography Form -->
    <div id="photographyForm" class="service-form-container">
    <form method="POST" action="submit_service.php" enctype="multipart/form-data">

            <label>Service Name:</label>
            <input type="text" name="service_name" required>

            <label>Photography Type:</label>
            <select name="photography_types[]" multiple required>
                <option value="Wedding">Wedding</option>
                <option value="Birthday">Birthday</option>
                <option value="Corporate">Corporate</option>
                <option value="Fashion">Fashion</option>
            </select>

            <label>Videography Available?</label>
            <select name="videography">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>

            <label>Package Description:</label>
            <textarea name="package_desc" required></textarea>

            <label>Coverage Duration:</label>
            <select name="coverage_duration">
                <option value="2 Hours">2 Hours</option>
                <option value="4 Hours">4 Hours</option>
                <option value="Full Day">Full Day</option>
            </select>

            <label>Number of Photographers/Videographers:</label>
            <input type="number" name="num_photographers" required>

            <label>Editing Included?</label>
            <select name="editing">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>

            <label>Basic Package Price (₹):</label>
            <input type="number" name="price_basic" required>

            <label>Premium Package Price (₹):</label>
            <input type="number" name="price_premium" required>

            <label>Upload Event Image:</label>
            <input type="file" name="event_image" required>

            <button type="submit" name="add_photography">Add Photography Service</button>
        </form>
    </div>

    <!-- Decoration Form -->
    <div id="decorationForm" class="service-form-container">
    <form method="POST" action="submit_service.php" enctype="multipart/form-data">


            <label>Decoration Type:</label>
            <select name="decoration_types[]" required>
                <option value="Wedding">Wedding</option>
                <option value="Birthday">Birthday</option>
                <option value="Corporate">Corporate</option>
                <option value="Festival">Festival</option>
            </select>

            <label>Decoration Description:</label>
            <textarea name="description" required></textarea>

            <label>Custom Decoration Available?</label>
            <select name="custom_decoration">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>

            <label>Basic Package Price (₹):</label>
            <input type="number" name="price_basic" required>

            <label>Premium Package Price (₹):</label>
            <input type="number" name="price_premium" required>

            <label>Upload Event Image:</label>
            <input type="file" name="event_image" required>

            <button type="submit" name="add_decoration">Add Decoration Service</button>
        </form>
    </div>

    <!-- Entertainment Form -->
    <div id="entertainmentForm" class="service-form-container">
    <form method="POST" action="submit_service.php" enctype="multipart/form-data">

            <label>Service Type:</label>
            <select name="service_type" required>
                <option value="Music">Music</option>
                <option value="Dance">Dance</option>
                <option value="Comedy">Comedy</option>
                <option value="Magic Show">Magic Show</option>
            </select>

            <label>Performance Duration:</label>
            <input type="text" name="performance_duration" placeholder="e.g., 1 hour, 2 hours" required>

            <label>Basic Package Price (₹):</label>
            <input type="number" name="price_basic" required>

            <label>Premium Package Price (₹):</label>
            <input type="number" name="price_premium" required>


            <label>Upload Event Image:</label>
            <input type="file" name="event_image" required>

            <button type="submit" name="add_entertainment">Add Entertainment Service</button>
        </form>
    </div>

    <script>
        function showFormm() {
            // Hide all forms
            document.getElementById('venueForm').style.display = 'none';
            document.getElementById('cateringForm').style.display = 'none';
            document.getElementById('photographyForm').style.display = 'none';
            document.getElementById('decorationForm').style.display = 'none';
            document.getElementById('entertainmentForm').style.display = 'none';

            // Get selected service
            var service = document.getElementById('serviceDropdown').value;

            // Show form based on selected service
            if (service == 'venue') {
                document.getElementById('venueForm').style.display = 'block';
            } else if (service == 'catering') {
                document.getElementById('cateringForm').style.display = 'block';
            } else if (service == 'photography') {
                document.getElementById('photographyForm').style.display = 'block';
            } else if (service == 'decoration') {
                document.getElementById('decorationForm').style.display = 'block';
            } else if (service == 'entertainment') {
                document.getElementById('entertainmentForm').style.display = 'block';
            }
        }
    </script>
</div>


<!-- View Event Form -->
<div id="viewEventForm" class="form-container">
    <h2>View All Events</h2>
    <p>Here you can view all your events.</p>
    <!-- Add a table or list to display events dynamically -->

    <div class="event-container">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="event-card">
                <img src="<?php echo $row['event_image']; ?>" alt="Event Image">
                <h3><?php echo $row['eventname']; ?></h3>
                <p><?php echo $row['eventdescription']; ?></p>
                <p><strong>Price:</strong> ₹<?php echo $row['price']; ?></p>
                <p><strong>Location:</strong> <?php echo $row['location']; ?></p>
                <p><strong>Date:</strong> <?php echo $row['date']; ?></p>
                <a href="edit_event.php?id=<?php echo $row['event_id']; ?>" class="btn">Edit</a>
                <a href="delete_event.php?id=<?php echo $row['event_id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
            </div>
        <?php } ?>
    </div>
</div>

<script>
    // JavaScript to show/hide forms
    function showForm(formId) {
        // Hide all forms
        document.querySelectorAll('.form-container').forEach(form => {
            form.style.display = 'none';
        });

        // Show the selected form
        document.getElementById(formId).style.display = 'block';
    }
</script>
</body>

</html>