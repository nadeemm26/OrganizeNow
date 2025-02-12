<?php
include 'user_navbar.php';
include "connection.php";
?>
<?php

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
    <style>
        .container {
            width: 90%;
            margin: auto;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }

        .book-btn,
        .view-btn {
            display: block;
            margin: 10px auto;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            color: white;
        }

        .book-btn {
            background: green;
        }

        .view-btn {
            background: blue;
        }
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
                        <!-- <img src="<?php echo $row["event_image"]; ?>" alt="<?php echo $category; ?> Image"> -->
                        <img src="Merchant/<?php echo $row["event_image"]; ?>" alt="<?php echo $category; ?> Image">
                        <h5><?php echo $row["name"] ?? $row["venue_name"] ?? ''; ?></h5>
                        <h5><?php echo $row["name"] ?? $row["decoration_types"] ?? ''; ?></h5>
                        <h5><?php echo $row["name"] ?? $row["catering_name"] ?? ''; ?></h5>
                        <h5><?php echo $row["name"] ?? $row["service_type"] ?? ''; ?></h5>
                        <h5><?php echo $row["name"] ?? $row["service_name"] ?? ''; ?></h5>

                        <a class="book-btn" href="book.php?id=<?php echo $row[$id_column]; ?>&category=<?php echo $table; ?>">Book Now</a>
                        <a class="view-btn" href="view_more.php?id=<?php echo $row[$id_column]; ?>&category=<?php echo $table; ?>">View More</a>

                    </div>
                <?php endwhile; ?>
            </div>
        <?php endforeach; ?>
    </div>

</body>

</html>