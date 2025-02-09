<?php
include '../OrganizeNow/Customer/connection.php';

$tables = [
    "venue_booking" => "Venue",
    "decoration_service" => "Decoration",
    "entertainment_service" => "Entertainment",
    "catering_service" => "Catering",
    "photography_service" => "Photography"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Services</title>
    <style>
        .container { width: 90%; margin: auto; }
        .grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .card { border: 1px solid #ddd; border-radius: 10px; padding: 15px; text-align: center; }
        .card img { width: 100%; height: 200px; object-fit: cover; border-radius: 5px; }
        .view-btn { display: block; margin-top: 10px; padding: 8px 12px; background: blue; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Available Event Services</h2>

    <?php foreach ($tables as $table => $category): ?>
        <h3><?php echo $category; ?> Services</h3>
        <div class="grid">
            <?php
            $sql = "SELECT * FROM $table";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()):
                $id_column = array_keys($row)[0]; // First column is ID
            ?>
                <div class="card">
                    <img src="<?php echo $row["event_image"]; ?>" alt="<?php echo $category; ?> Image">
                    <h5><?php echo $row["name"] ?? $row["venue_name"] ?? ''; ?></h5>
                    <a class="view-btn" href="details.php?id=<?php echo $row[$id_column]; ?>&category=<?php echo $table; ?>">View More</a>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
