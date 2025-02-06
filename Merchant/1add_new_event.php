<?php

include 'myevent.php';

?>

<div class="form-container">
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