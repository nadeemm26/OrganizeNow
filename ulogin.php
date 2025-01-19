<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USer Login Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <form action="ulogin_process.php" method="POST">
        <h2>User Login</h2>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Login</button>
        <p>Don't have an account? <a href="usignup.php">Register as User</a> or <a href="msignup.php">Register as Merchant</a></p>
        <p>have an account? <a href="mlogin.php">Login as Merchant</a></p>
    </form>

</body>
</html>