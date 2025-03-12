<?php

include 'action.php';
// insert Data

$username=$_POST['username'];
$email=$_POST['email'];
$password=password_hash($_POST['password'],PASSWORD_DEFAULT);
$phone=$_POST['phone'];

$table="INSERT INTO users (username,email,password,phone)
VALUES('$username','$email','$password','$phone')";

if($conn->query($table)===TRUE)
{
    header("Location:view.php");
}
else 
{
    echo "error 404";
}





?>