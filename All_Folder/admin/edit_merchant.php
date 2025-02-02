<?php
// Include database connection
include 'db_config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM merchant WHERE id = $id"; // Adjust table name
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $merchant = $result->fetch_assoc();
    } else {
        echo "Merchant not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Merchant</title>
    <style>
        form {
            display: flex;
            flex-direction: column;
            font-size: larger;

            /* align-items: stretch; */
            margin-left: 105px;
            padding-left: 203px;
        }

        form input,
        button {
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
    <h1>Edit Merchant</h1>

    <form action="update_merchant.php" method="post">
        <input type="hidden" name="id" value="<?php echo $merchant['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $merchant['name']; ?>">
        <label for="type">Type:</label>
        <input type="text" name="type" value="<?php echo $merchant['type']; ?>">
        <label for="details">Details:</label>
        <textarea name="details"><?php echo $merchant['details']; ?></textarea>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $merchant['email']; ?>">
        <label for="mobile">Mobile:</label>
        <input type="text" name="mobile" value="<?php echo $merchant['mobile']; ?>">
        <button type="submit">Update</button>
    </form>

</body>

</html>