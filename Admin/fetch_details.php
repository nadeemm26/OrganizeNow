<?php
include "connection.php";

if(isset($_POST['id']) && isset($_POST['type'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $type = $_POST['type'];

    if($type == "user") {
        $query = "SELECT * FROM user WHERE user_id = '$id'";
    } elseif($type == "merchant") {
        $query = "SELECT * FROM merchant WHERE merchant_id = '$id'";
    } elseif($type == "booking") {
        $query = "SELECT * FROM booking2 WHERE id = '$id'";
    } else {
        echo "Invalid Request!";
        exit;
    }

    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        echo "<table border='1'>";
        foreach($data as $key => $value) {
            echo "<tr><th>".ucwords(str_replace("_", " ", $key))."</th><td>$value</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No data found!";
    }
} else {
    echo "Invalid request!";
}
?>
