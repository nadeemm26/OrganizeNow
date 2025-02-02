<?php
// Include database connection
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $details = $_POST['details'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    $query = "UPDATE merchant SET 
        name = '$name',
        type = '$type',
        details = '$details',
        email = '$email',
        mobile = '$mobile'
        WHERE id = $id";

    if ($conn->query($query) === TRUE) {
        echo "Merchant updated successfully.";
        header('Location: dashboard2.php'); // Redirect to the list page
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
