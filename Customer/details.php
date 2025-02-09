<?php
include 'connection.php';

if (isset($_GET['id']) && isset($_GET['category'])) {
    $id = intval($_GET['id']);
    $category = $_GET['category'];

    $tableMapping = [
        "Photography" => "photography_service",
        "Venue" => "venue_booking",
        "Catering" => "catering_service",
        "Entertainment" => "entertainment_service",
        "Decoration" => "decoration_service"
    ];

    if (array_key_exists($category, $tableMapping)) {
        $table = $tableMapping[$category];
        $primaryKey = strtolower($category) . "_id";

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
                <p><strong>Details:</strong></p>
                <pre><?php echo json_encode($row, JSON_PRETTY_PRINT); ?></pre>
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
