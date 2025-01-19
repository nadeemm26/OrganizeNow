<?php

$email=$_POST['email'];
$password=$_POST['password'];

$cnn=mysqli_connect('localhost','root','','um');
$data=mysqli_query($cnn,"SELECT * FROM merchant where email='$email' and password='$password'");
$check=mysqli_num_rows($data);
print_r($check);
if($check==1)
{
    session_start();
    $_SESSION['name']=$name;
    $_SESSION['email']=$email;
    header("location:h.php");
}
else{
    header('location:mlogin.php');
}

?>