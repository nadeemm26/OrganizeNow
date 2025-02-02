<?php
// Include database connection
include 'db_config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM user WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        form {
            display: flex;
            flex-direction: column;
            font-size: larger;
            
            /* align-items: stretch; */
            margin-left: 105px;
            padding-left: 203px;
        }
        form input , button{
            height: 30px;
            
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            position: fixed;
            height: 100%;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar img {
            display: block;
            margin: 0 auto 20px;
            border-radius: 50%;
        }

        .sidebar h2 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: #ecf0f1;
            text-decoration: none;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        .sidebar a.active {
            background-color: #16a085;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <img alt="Event Management Logo" height="50" src="https://storage.googleapis.com/a1aa/image/lVCW4JSGXNpeEqSD67RZn3Gu7QmvDyhmjWDeAqe4rVcfR5DQB.jpg" width="50" />
        <h2>OrganizeNow</h2>
        <a href="#dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="#user"><i class="fas fa-users"></i> User Management</a>
        <a href="#merchant-management"><i class="fas fa-store"></i> Merchant Management</a>
        <a href="#payment-management"><i class="fas fa-credit-card"></i> Payment Management</a>
        <a href="#settings"><i class="fas fa-cogs"></i> Settings</a>

    </div>
    <h1>Edit User</h1>
    <?php if ($user): ?>
        <form action="update_user.php" method="post">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $user['name']; ?>" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>" required>
            <br>
            <label for="mobile">Phone:</label>
            <input type="text" name="mobile" id="mobile" value="<?php echo $user['mobile']; ?>" required>
            <br>
            <button type="submit" name="update">Update</button>
        </form>
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>
</body>

</html>