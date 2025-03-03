<?php
include "connection.php";

if (isset($_POST['query'])) {
    $search = $_POST['query'];
    
    $tables = ['catering_service', 'decoration_service', 'photography_service', 'entertainment_service', 'venue_booking'];
    $results = "";

    foreach ($tables as $table) {
        $query = "SELECT * FROM $table WHERE service_name LIKE '%$search%' OR service_type LIKE '%$search%'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $results .= "
                    <div class='card'>
                        <img src='../Merchant/{$row['event_image']}' alt='Service Image'>
                        <div class='card-body'>
                            <h4 class='card-title'>{$row['service_name']}</h4>
                            <h2 class='card-title'>{$row['service_type']}</h2>
                            <p><strong>Service Price:</strong> ₹" . number_format($row['price'], 2) . "</p>
                            <a href='book_service.php?id={$row['service_id']}&type={$table}&merchant_id={$row['merchant_id']}' class='btn book-now'>Book Now</a>
                            <a href='service_details.php?id={$row['service_id']}&type={$table}' class='view-more'>View More</a>
                        </div>
                    </div>
                ";
            }
        }
    }

    echo $results ?: "<p class='text-center'>No matching services found.</p>";
}
?>
