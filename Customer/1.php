<!-- <?php
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Services</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            width: 90%;
            margin: 20px auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 15px;
            text-align: center;
        }
        .card img {
            width: 100%;
            height: 180px;
            border-radius: 10px;
        }
        .card h5 {
            margin: 10px 0;
        }
        .view-btn {
            background: #007bff;
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .view-btn:hover {
            background: #0056b3;
        }

        /* Modal CSS */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }
        .modal-content {
            background: white;
            width: 50%;
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            text-align: left;
        }
        .close-btn {
            float: right;
            cursor: pointer;
            font-size: 22px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Available Event Services</h2>
    <div class="grid-container">
        <?php
        // Fetching all services from different tables
        $queries = [
            "SELECT photography_id as id, service_name as name, event_image, 'Photography' as category FROM photography_service",
            "SELECT venue_id as id, venue_name as name, event_image, 'Venue' as category FROM venue_booking",
            "SELECT catering_id as id, catering_name as name, event_image, 'Catering' as category FROM catering_service",
            "SELECT entertainment_id as id, service_type as name, event_image, 'Entertainment' as category FROM entertainment_service",
            "SELECT decoration_id as id, decoration_types as name, event_image, 'Decoration' as category FROM decoration_service"
        ];

        foreach ($queries as $sql) {
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">
                        <img src="'.$row["event_image"].'" alt="'.$row["category"].' Image">
                        <h5>'.$row["name"].'</h5>
                        <p><strong>Category:</strong> '.$row["category"].'</p>
                        <button class="view-btn" onclick="openModal(\''.$row["id"].'\', \''.$row["category"].'\')">View</button>
                      </div>';
            }
        }
        ?>
    </div>
</div>

Modal Popup 
<div id="serviceModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3 id="modal-title"></h3>
        <img id="modal-image" src="" width="100%">
        <p id="modal-description"></p>
    </div>
</div>

<script>
    function openModal(serviceId, category) {
        fetch('2get_service_details.php?id=' + serviceId + '&category=' + category)
            .then(response => response.json())
            .then(data => {
                document.getElementById("modal-title").innerText = data.name;
                document.getElementById("modal-image").src = data.event_image;
                document.getElementById("modal-description").innerHTML = data.details;
                document.getElementById("serviceModal").style.display = "block";
            });
    }

    function closeModal() {
        document.getElementById("serviceModal").style.display = "none";
    }
</script>

</body>
</html>
<?php
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Services</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            width: 90%;
            margin: 20px auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 15px;
            text-align: center;
        }
        .card img {
            width: 100%;
            height: 180px;
            border-radius: 10px;
        }
        .card h5 {
            margin: 10px 0;
        }
        .view-btn {
            background: #007bff;
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .view-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Available Event Services</h2>
    <div class="grid-container">
        <?php
        // Fetching all services from different tables
        $queries = [
            "SELECT photography_id as id, service_name as name, event_image, 'Photography' as category FROM photography_service",
            "SELECT venue_id as id, venue_name as name, event_image, 'Venue' as category FROM venue_booking",
            "SELECT catering_id as id, catering_name as name, event_image, 'Catering' as category FROM catering_service",
            "SELECT entertainment_id as id, service_type as name, event_image, 'Entertainment' as category FROM entertainment_service",
            "SELECT decoration_id as id, decoration_types as name, event_image, 'Decoration' as category FROM decoration_service"
        ];

        foreach ($queries as $sql) {
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">
                        <img src="'.$row["event_image"].'" alt="'.$row["category"].' Image">
                        <h5>'.$row["name"].'</h5>
                        <p><strong>Category:</strong> '.$row["category"].'</p>
                        <a class="view-btn" href="details.php?id='.$row["id"].'&category='.$row["category"].'">View</a>
                      </div>';
            }
        }
        ?>
    </div>
</div>

</body>
</html> -->
<?php
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Services</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            width: 90%;
            margin: 20px auto;
        }
        h2 {
            text-align: center;
        }
        .grid-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            width: 30%;
            background: white;
            padding: 15px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card img {
            width: 100%;
            height: 180px;
            border-radius: 10px;
        }
        .card h5 {
            margin: 10px 0;
        }
        .view-btn {
            background: #007bff;
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .view-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Available Event Services</h2>
    <div class="grid-container">
        <?php
        $tables = [
            "photography_service" => "Photography",
            "venue_booking" => "Venue",
            "catering_service" => "Catering",
            "entertainment_service" => "Entertainment",
            "decoration_service" => "Decoration"
        ];

        foreach ($tables as $table => $category) {
            $sql = "SELECT * FROM $table";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                // Correct ID column name according to the table
                $id_column = array_keys($row)[0]; // First column is usually ID
        
                echo '<div class="card">
                        <img src="'.$row["event_image"].'" alt="'.$category.' Image">
                      
                        <p><strong>Category:</strong> '.$category.'</p>
                        <a class="view-btn" href="details.php?id='.$row[$id_column].'&category='.$category.'">View</a>
                      </div>';
            }
        }
        
        ?>
    </div>
</div>

</body>
</html>
