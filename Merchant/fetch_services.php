<?php
include "connection.php";

if (isset($_POST['service'])) {
    $service = $_POST['service'];
    $query = "";

    if ($service == "all") {
        $query = "
            (SELECT venue_name AS name, price_per_day AS price, event_image, merchant_id FROM venue_booking)
            UNION ALL
            (SELECT catering_name AS name, price_veg AS price, event_image, merchant_id FROM catering_service)
            UNION ALL
            (SELECT service_name AS name, price_basic AS price, event_image, merchant_id FROM photography_service)
            UNION ALL
            (SELECT decoration_types AS name, price_basic AS price, event_image, merchant_id FROM decoration_service)
            UNION ALL
            (SELECT service_type AS name, price_basic AS price, event_image, merchant_id FROM entertainment_service)";
    } else {
        if ($service == "venue_booking") {
            $query = "SELECT venue_name AS name, price_per_day AS price, event_image, merchant_id FROM venue_booking";
        } elseif ($service == "catering_service") {
            $query = "SELECT catering_name AS name, price_veg AS price, event_image, merchant_id FROM catering_service";
        } elseif ($service == "photography_service") {
            $query = "SELECT service_name AS name, price_basic AS price, event_image, merchant_id FROM photography_service";
        } elseif ($service == "decoration_service") {
            $query = "SELECT decoration_types AS name, price_basic AS price, event_image, merchant_id FROM decoration_service";
        } elseif ($service == "entertainment_service") {
            $query = "SELECT service_type AS name, price_basic AS price, event_image, merchant_id FROM entertainment_service";
        }
    }

    if ($query != "") {
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td>₹' . $row['price'] . '</td>';
                echo '<td><img src="' . $row['event_image'] . '" alt="Image"></td>';
                echo '<td>' . $row['merchant_id'] . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="4">No records found.</td></tr>';
        }
    }
}
?>
