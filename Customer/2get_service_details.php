
<?php
include 'connection.php';

if (isset($_GET['id']) && isset($_GET['category'])) {
    $id = intval($_GET['id']);
    $category = $_GET['category'];

    // Table Mapping
    $tables = [
        "Photography" => ["photography_service", "photography_id"],
        "Venue" => ["venue_booking", "venue_id"],
        "Catering" => ["catering_service", "catering_id"],
        "Entertainment" => ["entertainment_service", "entertainment_id"],
        "Decoration" => ["decoration_service", "decoration_id"]
    ];

    if (isset($tables[$category])) {
        $table = $tables[$category][0];
        $primaryKey = $tables[$category][1];

        $sql = "SELECT * FROM $table WHERE $primaryKey = $id";
        $result = $conn->query($sql);

        if ($row = $result->fetch_assoc()) {
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title><?php echo $row[array_keys($row)[1]]; ?> Details</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f8f9fa;
                    }
                    .container {
                        width: 60%;
                        margin: 40px auto;
                        background: white;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                    }
                    img {
                        width: 100%;
                        border-radius: 10px;
                    }
                    h2 {
                        text-align: center;
                    }
                    p {
                        font-size: 16px;
                        margin: 10px 0;
                    }
                    .back-btn {
                        display: block;
                        width: 100px;
                        margin: 20px auto;
                        text-align: center;
                        background: #007bff;
                        color: white;
                        padding: 10px;
                        border-radius: 5px;
                        text-decoration: none;
                    }
                    .back-btn:hover {
                        background: #0056b3;
                    }
                </style>
            </head>
            <body>

            <div class="container">
                <h2><?php echo $row[array_keys($row)[1]]; ?> Details</h2>
                <img src="<?php echo $row['event_image']; ?>" alt="Service Image">
                <p><strong>Category:</strong> <?php echo $category; ?></p>

                <?php if ($category == "Photography") { ?>
                    <p><strong>Photography Type:</strong> <?php echo $row['photography_types']; ?></p>
                    <p><strong>Price:</strong> ₹<?php echo $row['price_basic']; ?> - ₹<?php echo $row['price_premium']; ?></p>
                <?php } elseif ($category == "Venue") { ?>
                    <p><strong>Venue Type:</strong> <?php echo $row['venue_type']; ?></p>
                    <p><strong>Capacity:</strong> <?php echo $row['capacity']; ?> People</p>
                    <p><strong>Price Per Day:</strong> ₹<?php echo $row['price_per_day']; ?></p>
                <?php } elseif ($category == "Catering") { ?>
                    <p><strong>Cuisine Type:</strong> <?php echo $row['cuisine_types']; ?></p>
                    <p><strong>Veg Price:</strong> ₹<?php echo $row['price_veg']; ?></p>
                    <p><strong>Non-Veg Price:</strong> ₹<?php echo $row['price_nonveg']; ?></p>
                <?php } elseif ($category == "Entertainment") { ?>
                    <p><strong>Service Type:</strong> <?php echo $row['service_type']; ?></p>
                    <p><strong>Performance Duration:</strong> <?php echo $row['performance_duration']; ?> Hours</p>
                <?php } elseif ($category == "Decoration") { ?>
                    <p><strong>Decoration Type:</strong> <?php echo $row['decoration_types']; ?></p>
                    <p><strong>Price Range:</strong> ₹<?php echo $row['price_basic']; ?> - ₹<?php echo $row['price_premium']; ?></p>
                <?php } ?>

                <a href="1.php" class="back-btn">Back</a>
            </div>

            </body>
            </html>
            <?php
        } else {
            echo "No details found.";
        }
    } else {
        echo "Invalid category.";
    }
} else {
    echo "Invalid request.";
}
?>
