<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User SignUp</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <form onsubmit="data()" action="usave_process.php" method="POST">
        
 <h2>User Registration Form</h2>


        <br><label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="mobile">Mobile:</label>
        <input type="number" id="mobile" name="mobile" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>


        <input type="checkbox" name="checkboxx" id="checkboxx" required>
        <label for="checkboxx">By Signing up you agree to our Terms and Condition and Privacy Policy</label><br><br>

        <button type="submit">SignUp</button>

        <p>Are you a merchant? <a href="msignup.php">Register as Merchant</a></p>
        <p>Already have an account? <a href="ulogin.php">Login as User</a></p>

    </form>

    <body>
    <!-- <script>
        function data()
        {
            var a=document.getElementById('name').value;
            var b=document.getElementById('email').value;
            var c=document.getElementById('mobile').value;
            var d=document.getElementById('password').value;
            if(a==""||b==""||c==""||d=="")
            {
                alert("Please enter all details");
                return false;
            }
            else if(c.length<10||c.length>10)
            {
                alert("Please Enter Valid Number");
                return false;
            }
            else
            {
                true;
            }
        
        }
    </script> -->

</html>

