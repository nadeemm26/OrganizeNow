<?php
session_start();
include 'connection.php';
// include 'user_navbar.php';

// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php"); // Agar user login nahi hai to redirect kar do
//     exit();
// }

$user_id = $_SESSION['user_id'];

// User ka data fetch karna
$sql = "SELECT name, email, mobile FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $mobile);
$stmt->fetch();
$stmt->close();

// Agar form submit ho to update kare
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = trim($_POST['name']);

    if (!empty($new_name)) {
        $sql = "UPDATE user SET name=? WHERE user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_name, $user_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Profile updated successfully!";
            header("Location: profile.php"); // Update ke baad profile page pe redirect
            exit();
        } else {
            $error = "Something went wrong!";
        }
        $stmt->close();
    } else {
        $error = "Name field is required!";
    }
}

$conn->close();
?>
<?php include 'user_navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .edit-profile-card {
            max-width: 380px;
            margin: 50px auto;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .edit-profile-card h3 {
            color: #333;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .input-group label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }
        .input-group input {
            width: 93%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
        }
        .input-group input:disabled {
            background: #e9ecef;
            cursor: not-allowed;
        }
        .btn-save {
            background: #28a745;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-save:hover {
            background: #218838;
        }
        .alert {
            background: #ff4d4d;
            color: white;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
        }
    </style>
</head>
<body>

    <div class="edit-profile-card">
        <h3>Edit Profile</h3>

        <?php if (isset($error)) { echo "<div class='alert'>$error</div>"; } ?>

        <form method="POST">
            <div class="input-group">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="input-group">
                <label>Email:</label>
                <input type="email" value="<?php echo htmlspecialchars($email); ?>" disabled>
            </div>
            <div class="input-group">
                <label>Mobile:</label>
                <input type="text" value="<?php echo htmlspecialchars($mobile); ?>" disabled>
            </div>
            <button type="submit" class="btn-save">Save Changes</button>
        </form>
    </div>

</body>
</html>