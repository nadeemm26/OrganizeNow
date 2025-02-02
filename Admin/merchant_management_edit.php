<?php
include "connection.php";
include "admin.php";

// Fetch merchant details
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM `merchant` WHERE id='$id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
}

// Update merchant details
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $details = $_POST['details'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    $updateQuery = "UPDATE `merchant` SET name='$name', type='$type', details='$details', email='$email', mobile='$mobile' WHERE id='$id'";

    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('Merchant updated successfully!'); window.location.href='merchant_management.php';</script>";
    } else {
        echo "<script>alert('Error updating merchant');</script>";
    }
}
?>

<h1>Edit Merchant</h1>
<form method="POST">
    <div class="form-group">
    <label for="name">Name:</label>
    <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
    </div>
    <div class="form-group">
    <label for="type">Type:</label>
    <select name="type" required>
        <option value="catering" <?php if ($row['type'] == 'catering') echo 'selected'; ?>>Catering</option>
        <option value="decoration" <?php if ($row['type'] == 'decoration') echo 'selected'; ?>>Decoration</option>
        <option value="photo" <?php if ($row['type'] == 'photo') echo 'selected'; ?>>Photo</option>
        <option value="venue" <?php if ($row['type'] == 'venue') echo 'selected'; ?>>Venue</option>
        <option value="other" <?php if ($row['type'] == 'other') echo 'selected'; ?>>Other</option>
    </select>
    </div>
    <div class="form-group">
    <label for="details">Details:</label>
    <textarea name="details" required><?php echo $row['details']; ?></textarea>
    </div>
    <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
    </div>
    <div class="form-group">
    <label for="mobile">Mobile:</label>
    <input type="number" name="mobile" value="<?php echo $row['mobile']; ?>" required>
    </div>
    <div class="form-group">
    <button type="submit" name="update">Update</button>
    <a href="merchant_management.php"><button type="button">Cancel</button></a>
    </div>
</form>

</body>
</html>
