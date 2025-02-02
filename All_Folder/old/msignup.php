<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merchant SignUp</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <form action="msave_process.php" method="POST">

        <h2>Merchant Registration Form</h2>


        <label for="businessname">Business Name:</label>
        <input type="text" id="businessname" name="businessname"><br><br>

        <label>Business Type:</label>
        <input type="radio" name="type" id="catring" value="catring">
        <label for="catring">Catring</label>
        <input type="radio" name="type" id="decoration" value="decoration">
        <label for="decoration">decoration</label>
        <input type="radio" name="type" id="photo" value="photo">
        <label for="photo">photo</label>
        <input type="radio" name="type" id="venue" value="venue">
        <label for="venue">venue</label>
        <input type="radio" name="type" id="other" value="other">
        <label for="other">other</label><br><br>

        <label for="businessdetails">Business Details:</label>
        <input type="text" id="businessdetails" name="businessdetails"><br><br>

        <label for="email">Business Email:</label>
        <input type="email" id="email" name="email"><br><br>

        <label for="merchantmobile">Mobile:</label>
        <input type="number" id="merchantmobile" name="merchantmobile" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>

        <input type="checkbox" name="checkboxx" id="checkboxx" required>
        <label for="checkboxx">By Signing up you agree to our Terms and Condition and Privacy Policy</label><br><br>

        <button type="submit">SignUp</button>

        <p>Are you a user? <a href="usignup.php">Register as User</a></p>
        <p>Already have an account? <a href="mlogin.php">Login as Merchant</a></p>

    </form>

    <body>

</html>