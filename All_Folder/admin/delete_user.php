<?php
// Include database connection
include 'db_config.php';


if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

   
    $sql = "DELETE FROM user WHERE id = ?";
    
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Record deleted successfully
        echo "<script>alert('Record deleted successfully!');</script>";
    } else {
        // Error occurred
        echo "<script>alert('Error deleting record: " . $conn->error . "');</script>";
    }

    // Redirect back to the main page
    echo "<script>window.location.href = 'dashboard2.php';</script>";
} else {
    echo "<script>alert('Invalid request.');</script>";
    echo "<script>window.location.href = 'dashboard2.php';</script>";
}

// Close the connection
$conn->close();
?>
