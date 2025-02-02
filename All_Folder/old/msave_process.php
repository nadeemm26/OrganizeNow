<?php

$name=$_POST['businessname'];
$type=$_POST['type'];
$details=$_POST['businessdetails'];
$email=$_POST['email'];
$mobile=$_POST['merchantmobile'];
$password=$_POST['password'];

$cnn=mysqli_connect('localhost','root','','um');
mysqli_query($cnn,"INSERT INTO merchant VALUES(null,'$name','$type','$details','$email','$mobile','$password')");
header("location:mlogin.php");

?>