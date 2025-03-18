<?php
include 'action.php';

$username = $_POST ["username"];
$password = password_hash ($_POST['password'], PASSWORD_DEFAULT);
$email = $_POST ["email"];  
$phone = $_POST ["phone"];

$table = "INSERT INTO user (username, password, email, phone)
VALUES ('$useranme','$password','$email','$phone')";






?>