<?php
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table_name = $_POST['table_name'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    // Define table columns based on selection
    switch ($table_name) {
        case "user":
            $query = "SELECT user_id AS 'User ID', name AS 'User Name', email AS 'User Email', mobile AS 'User Mobile', created_at AS 'Created At' FROM user WHERE created_at BETWEEN '$from_date' AND '$to_date'";
            break;

        case "merchant":
            $query = "SELECT merchant_id AS 'Merchant ID', name AS 'Merchant Name', email AS 'Merchant Email', mobile AS 'Merchant Mobile', created_at AS 'Created At' FROM merchant WHERE created_at BETWEEN '$from_date' AND '$to_date'";
            break;

        case "booking2":
            $query = "SELECT id AS ID, user_id AS 'User ID', merchant_id AS 'Merchant ID', service_name AS 'Service Name', service_type AS 'Type', booking_date AS 'Date', num_days AS 'Days', location AS 'Location', payment_status AS 'Payment Status', total_price AS Amount, created_at AS 'Created At' FROM booking2 WHERE created_at BETWEEN '$from_date' AND '$to_date'";
            break;

        case "payments":
            $query = "SELECT id AS ID, user_id AS 'User ID', merchant_id AS 'Merchant ID', payment_id AS 'Payment id', order_id AS 'Order ID', amount_paid AS 'Amount Paid', payment_status AS 'Payment Status', created_at AS 'Created At' FROM payments WHERE created_at BETWEEN '$from_date' AND '$to_date'";
            break;

        default:
            echo "<p style='color: red;'>Invalid table selected.</p>";
            exit();
    }

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<h4>" . ucfirst($table_name) . " Report</h4>";
        echo "<table border='1'><tr>";

        // Fetch column names dynamically
        $columns = array_keys(mysqli_fetch_assoc($result));
        foreach ($columns as $col) {
            echo "<th>$col</th>";
        }
        echo "</tr>";

        // Reset pointer and fetch data
        mysqli_data_seek($result, 0);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: red;'>No data found for the selected table and date range.</p>";
    }
}
?>
