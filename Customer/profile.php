<?php
include 'user_navbar.php';
?>
<?php
// Assuming you have a session or user ID to fetch profile info
// session_start();
$user_id = $_SESSION['user_id']; // Get user ID from session

// Database connection
include('connection.php');
$query = "SELECT * FROM user WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<head>
    <style>
        /* User Profile Page */
        .profile {
            width: 100%;
            max-width: 900px;
            margin: 25px auto;
            padding: 30px;
            background-color: #efefef;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 14px;
        }

        .profile h1 {
            text-align: center;
            color: #4CAF50;
        }

        .profile p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .profile .profile-label {
            font-weight: bold;
            color: #555;
        }

        .profile .profile-data {
            color: #333;
        }

        /* Responsive Layout for Mobile */
        @media (max-width: 768px) {
            .profile {
                padding: 15px;
            }

            .profile h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<!-- User Profile Page -->
<div class="profile">
    <h1>Your Profile</h1>
    <p><span class="profile-label">Name:</span> <span class="profile-data"><?php echo $user['name']; ?></span></p>
    <p><span class="profile-label">Email:</span> <span class="profile-data"><?php echo $user['email']; ?></span></p>
    <p><span class="profile-label">Mobile:</span> <span class="profile-data"><?php echo $user['mobile']; ?></span></p>
</div>