<form action="create_service.php" method="POST" enctype="multipart/form-data">
    <label>Service Name:</label>
    <select name="servicename" required>
        <option value="Venue Booking">Venue Booking</option>
        <option value="Catering Service">Catering Service</option>
        <option value="Photography">Photography</option>
        <option value="Decoration">Decoration</option>
        <option value="Entertainment">Entertainment</option>
    </select><br><br>

    <label>Description:</label>
    <textarea name="servicedescription" required></textarea><br><br>

    <label>Price:</label>
    <input type="text" name="price" required><br><br>

    <label>Location:</label>
    <input type="text" name="location" required><br><br>

    <label>Upload Service Image:</label>
    <input type="file" name="service_image" required><br><br>

    <button type="submit">Create Service</button>
</form>
