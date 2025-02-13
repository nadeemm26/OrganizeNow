<?php include 'connection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <script>
        function toggleFields() {
            let category = document.getElementById("category").value;
            let serviceFields = document.getElementById("serviceFields");
            let eventServices = document.getElementById("eventServices");

            if (category === "Wedding Event" || category === "Engagement Event" || 
                category === "Birthday Event" || category === "Anniversary Event") {
                serviceFields.style.display = "none"; // Hide service fields
                eventServices.style.display = "block"; // Show checkboxes
            } else {
                serviceFields.style.display = "block"; // Show service fields
                eventServices.style.display = "none"; // Hide checkboxes
            }
        }
    </script>
</head>
<body>
    <h2>Create Event</h2>
    <form method="POST" action="">
        <label>Event Type:</label>
        <select name="category" id="category" onchange="toggleFields()" required>
            <option value="">Select</option>
            <optgroup label="Services">
                <option value="Catering Service">Catering Service</option>
                <option value="Venue Service">Venue Service</option>
                <option value="Decoration Service">Decoration Service</option>
                <option value="Photography Service">Photography Service</option>
                <option value="Entertainment Service">Entertainment Service</option>
            </optgroup>
            <optgroup label="Full Events">
                <option value="Wedding Event">Wedding Event</option>
                <option value="Engagement Event">Engagement Event</option>
                <option value="Birthday Event">Birthday Event</option>
                <option value="Anniversary Event">Anniversary Event</option>
            </optgroup>
        </select>

        <!-- Service Fields (Shown only for services) -->
        <div id="serviceFields" style="display: none;">
            <label>Service Details:</label>
            <textarea name="service_details"></textarea>
            <label>Price:</label>
            <input type="number" name="price" step="0.01">
        </div>

        <!-- Checkboxes for Full Events -->
        <div id="eventServices" style="display: none;">
            <label>Select Services Provided:</label><br>
            <input type="checkbox" name="included_services[]" value="Catering"> Catering Service <br>
            <input type="checkbox" name="included_services[]" value="Venue"> Venue Service <br>
            <input type="checkbox" name="included_services[]" value="Decoration"> Decoration Service <br>
            <input type="checkbox" name="included_services[]" value="Photography"> Photography Service <br>
            <input type="checkbox" name="included_services[]" value="Entertainment"> Entertainment Service <br>
        </div>

        <button type="submit" name="submit">Create Event</button>
    </form>

<?php
if (isset($_POST['submit'])) {
    $merchant_id = 1; // Assume merchant is logged in (Replace with session)
    $category = $_POST['category'];
    $service_details = $_POST['service_details'] ?? null;
    $price = $_POST['price'] ?? null;
    $included_services = isset($_POST['included_services']) ? implode(",", $_POST['included_services']) : null;
    $event_type = in_array($category, ['Wedding Event', 'Engagement Event', 'Birthday Event', 'Anniversary Event']) ? "Full Event" : "Service";

    $sql = "INSERT INTO events (merchant_id, event_type, category, service_details, price, included_services) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssds", $merchant_id, $event_type, $category, $service_details, $price, $included_services);

    if ($stmt->execute()) {
        echo "<script>alert('Event Created Successfully!'); window.location='merchant_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error Creating Event');</script>";
    }
}
?>
</body>
</html>
