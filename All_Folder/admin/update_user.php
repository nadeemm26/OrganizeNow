<?php
// Include database connection
include 'db_config.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    $query = "UPDATE user SET name = ?, email = ?, mobile = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $name, $email, $mobile, $id);

    if ($stmt->execute()) {
        echo "User updated successfully.";
        header("Location: dashboard2.php"); // Redirect to the user list page
    } else {
        echo "Error updating user.";
    }
    $stmt->close();
}
?>
