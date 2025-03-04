<?php
session_start();
require('../connection.php');

// Check if admin is already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php'); // Redirect to the admin dashboard
    exit;
}

// Process the login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    // Validate input fields
    if (empty($username) || empty($password)) {
        $error = '❌Please Enter Both Username and Password.';
    } else {
        // Query the database
        $stmt = $conn->prepare('SELECT * FROM admin WHERE username = ? LIMIT 1');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();

            // Verify password
            if ($password === $admin['password']) { // Direct comparison without hashing
                // Set session variables
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['admin_id'];  // ✅ Add this line
                $_SESSION['admin_username'] = $admin['username'];
            
                header('Location: dashboard.php'); // Redirect to the admin dashboard
                exit;
            }
             else {
                $error = '❌ Invalid Password. Please try again.';
            }
        } else {
            $error = '❌ No account found with that username.';
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- <link rel="stylesheet" href="form.css"> -->
    <style>
        body {
            font-family: Arial, sans-serif;
            /* background-color: #8687ae; */
            background-image: url(admin_login.jpg);
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        form {
            background-color: rgb(255, 255, 255);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        label {
            font-size: 1rem;
            color: #555;
            /* display: block; */
            margin-bottom: 2px;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"],
        button {
            width: 95%;
            padding: 5px;
            margin: 8px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        input {
            width: 4%;
            padding: 10px;
            margin: 2px 0px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        input[type="radio"] {
            margin-right: 2px;
        }

        label input[type="radio"] {
            display: inline;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            form {
                padding: 15px;
                max-width: 95%;
            }

            input[type="text"],
            input[type="email"],
            input[type="number"],
            input[type="password"],
            button {
                font-size: 0.9rem;
                padding: 8px;
            }
        }

        .error {
            color: red;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <form method="POST" action="">
            <?php if (isset($error)): ?>
                <div class="error"> <?= htmlspecialchars($error) ?> </div>
            <?php endif; ?>
            <h2>Admin Login</h2>
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>