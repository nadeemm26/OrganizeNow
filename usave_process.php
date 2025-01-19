<?php

$name=$_POST['name'];
$email=$_POST['email'];
$mobile=$_POST['mobile'];
$password=$_POST['password'];

$cnn=mysqli_connect('localhost','root','','um');
mysqli_query($cnn,"INSERT INTO user VALUES(null,'$name','$email','$mobile','$password')");
header("location:ulogin.php");

?>