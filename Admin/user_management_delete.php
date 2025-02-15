<?php
// Include database connection
include 'connection.php';


if (isset($_GET['id'])) {
    $user = intval($_GET['id']); 

   
    $sql = "DELETE FROM user WHERE user_id = ?";
    
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user);

    if ($stmt->execute()) {
        // Record deleted successfully
        echo "<script>alert('✅ Record deleted successfully!');</script>";
    } else {
        // Error occurred
        echo "<script>alert('❌Error deleting record: " . $conn->error . "');</script>";
    }

    // Redirect back to the main page
    echo "<script>window.location.href = 'user_management.php';</script>";
} else {
    echo "<script>alert('❌Invalid request.');</script>";
    echo "<script>window.location.href = 'user_management.php';</script>";
}

// Close the connection
$conn->close();
?>
