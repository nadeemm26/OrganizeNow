<?php
include 'connection.php';
include 'user_navbar.php';
// session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}



$user_id = $_SESSION['user_id'];
$sql = "SELECT name, email, mobile FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $mobile);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #f4f4f4;
        }
        .profile-card {
            max-width: 400px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .profile-card h3 {
            color: #333;
        }
        .profile-card p {
            color: #555;
            font-size: 16px;
        }
        .btn-edit {
            background: #007bff;
            color: #fff;
            border-radius: 5px;
            padding: 10px 15px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        .btn-edit:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div class="profile-card">
        <h3>User Profile</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Mobile:</strong> <?php echo htmlspecialchars($mobile); ?></p>
        <a href="edit_profile.php" class="btn-edit">Edit Profile</a>
    </div>

</body>
</html>
