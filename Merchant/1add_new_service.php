<?php

include 'myevent.php';

?>
<!-- Add Service Form -->
<div class="form-container">
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