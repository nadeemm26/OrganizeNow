<form action="create_event.php" method="POST" enctype="multipart/form-data">
    <label>Event Name:</label>
    <select name="eventname" required>
        <option value="Wedding">Wedding</option>
        <option value="Engagement">Engagement</option>
        <option value="Anniversary">Anniversary</option>
        <option value="Birthday">Birthday</option>
        <option value="Other">Other Event</option>
    </select><br><br>

    <label>Description:</label>
    <textarea name="eventdescription" required></textarea><br><br>

    <label>Date:</label>
    <input type="date" name="date" required><br><br>

    <label>Location:</label>
    <input type="text" name="location" required><br><br>

    <label>Price:</label>
    <input type="text" name="price" required><br><br>

    <label>Upload Event Image:</label>
    <input type="file" name="event_image" required><br><br>

    <h3>Select Services Provided:</h3>

    <div>
        <input type="checkbox" id="venue" name="services[]" value="Venue Booking" onclick="toggleServiceDetails('venue')">
        <label for="venue">Venue Booking</label>
        <div id="venue_details" style="display: none;">
            <input type="text" name="venue_price" placeholder="Venue Price">
            <textarea name="venue_desc" placeholder="Venue Details"></textarea>
        </div>
    </div>

    <div>
        <input type="checkbox" id="catering" name="services[]" value="Catering Service" onclick="toggleServiceDetails('catering')">
        <label for="catering">Catering Service</label>
        <div id="catering_details" style="display: none;">
            <input type="text" name="catering_price" placeholder="Catering Price">
            <textarea name="catering_desc" placeholder="Catering Details"></textarea>
        </div>
    </div>

    <div>
        <input type="checkbox" id="photography" name="services[]" value="Photography" onclick="toggleServiceDetails('photography')">
        <label for="photography">Photography</label>
        <div id="photography_details" style="display: none;">
            <input type="text" name="photography_price" placeholder="Photography Price">
            <textarea name="photography_desc" placeholder="Photography Details"></textarea>
        </div>
    </div>

    <div>
        <input type="checkbox" id="decoration" name="services[]" value="Decoration" onclick="toggleServiceDetails('decoration')">
        <label for="decoration">Decoration</label>
        <div id="decoration_details" style="display: none;">
            <input type="text" name="decoration_price" placeholder="Decoration Price">
            <textarea name="decoration_desc" placeholder="Decoration Details"></textarea>
        </div>
    </div>

    <div>
        <input type="checkbox" id="entertainment" name="services[]" value="Entertainment" onclick="toggleServiceDetails('entertainment')">
        <label for="entertainment">Entertainment</label>
        <div id="entertainment_details" style="display: none;">
            <input type="text" name="entertainment_price" placeholder="Entertainment Price">
            <textarea name="entertainment_desc" placeholder="Entertainment Details"></textarea>
        </div>
    </div>

    <button type="submit">Create Event</button>
</form>

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
