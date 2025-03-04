<?php
session_start();
require('../connection.php');
// require('admin_sidebar.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$admin_id = $_SESSION['admin_id'];

// Fetch Admin Details
$query = $conn->prepare("SELECT * FROM admin WHERE admin_id = ?");
$query->bind_param("i", $admin_id);
$query->execute();
$result = $query->get_result();
$admin = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Profile Image Upload
    if (!empty($_FILES['profile_image']['name'])) {
        $image_name = time() . '_' . $_FILES['profile_image']['name'];
        $image_path = "uploads/" . $image_name;
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $image_path);
    } else {
        $image_name = $admin['profile_image']; // Keep existing image if not updated
    }

    // Update Query
    $update = $conn->prepare("UPDATE admin SET username = ?, password = ?, profile_image = ? WHERE admin_id = ?");
    $update->bind_param("sssi", $username, $password, $image_name, $admin_id);
    if ($update->execute()) {
        $_SESSION['admin_username'] = $username;
        header('Location: dashboard.php'); // Redirect to Dashboard
        exit;
    } else {
        $error = "Failed to update profile!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="edit_profile.css"> <!-- Link to the CSS file -->
</head>
<body>
    <div class="container">
        <h2>Edit Profile</h2>
        <form method="POST" enctype="multipart/form-data">
            <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>

            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" value="<?= htmlspecialchars($admin['username']); ?>" required>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" value="<?= htmlspecialchars($admin['password']); ?>" required>
            </div>

            <div class="form-group">
                <label>Profile Image:</label>
                <input type="file" name="profile_image">
                <?php if (!empty($admin['profile_image'])): ?>
                    <img src="uploads/<?= $admin['profile_image']; ?>" class="profile-img" alt="Profile Image">
                <?php endif; ?>
            </div>

            <button type="submit" class="upload-btn">Update Profile</button>
        </form>
    </div>
</body>
</html>
