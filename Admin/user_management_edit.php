<?php
include "connection.php";
include "admin_sidebar.php";


// Fetch user details
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM `user` WHERE user_id='$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}

// Update user details
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    $updateQuery = "UPDATE `user` SET name='$name', email='$email', mobile='$mobile' WHERE user_id='$id'";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('✅ User updated successfully'); window.location.href='user_management.php';</script>";
    } else {
        echo "<script>alert('❌ Error updating user');</script>";
    }
}
?>

<h1>Edit User</h1>
<form method="POST">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
    </div>
    <div class="form-group">
        <label for="mobile">Phone:</label>
        <input type="text" name="mobile" value="<?php echo $row['mobile']; ?>" required>
    </div>
    <div class="form-group">
        <button type="submit" name="update">Update</button>
        <a href="user_management.php"><button type="button">Cancel</button></a>
    </div>
</form>

</body>

</html>