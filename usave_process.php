<?php
$cnn=mysqli_connect('localhost','root','','um');

$name=$_POST['name'];
$email=$_POST['email'];
$mobile=$_POST['mobile'];
$password=$_POST['password'];


mysqli_query($cnn,"INSERT INTO user VALUES(null,'$name','$email','$mobile','$password')");
header("location:ulogin.php");



// if (empty($name) || empty($email) || empty($mobile) || empty($password)) {
//     header('location:usignup.php?error=emptyfields');
//     exit();
// }

// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//     header('location:usignup.php?error=invalidemail');
//     exit();
// }

// if (strlen($mobile) !== 10 || !is_numeric($mobile)) {
//     header('location:usignup.php?error=invalidmobile');
//     exit();
// }

// // Hash the password before storing it
// $passwordHash = password_hash($password, PASSWORD_DEFAULT);
// mysqli_query($cnn, "INSERT INTO user VALUES(null,'$name','$email','$mobile','$passwordHash')");
// header("location:ulogin.php");



// if(isset($_POST['editbtn']))
// {
//     $id = $_POST['edit'];
//     echo $id;
// }

?>