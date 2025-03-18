<?php
include 'action.php';
session_start();

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $username=$_POST['username'];
    $password=$_POST['password'];

    $sql="SELECT id , password FROM users WHERE username=?";
    $bit=$conn->prepare($sql);
    $bit->bind_param("s",$username);
    $bit->execute();
    $bit->store_result();

    if($bit->num_rows>0){
        $bit->bind_result($id,$hashed_password);
        $bit->fetch();

        if(password_verify($password,$hashed_password)){
            $_SESSION['username']=$username;
            header("Location:view.php");

        }
        else {
            echo "Invalid Password";
        }
    }else {
        header("Location:register.php");
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<form action="Login.php" method="post">
    <label for="username">UserName:</label>
    <input type="text" name="username" id="username" placeholder="Enter username" class="form-control" required>
    <br>
  
    <label for="password" >Password :</label>
    <input type="password" name="password" id="password" placeholder="Enter password" class="form-control" required>
<br>
    <button type="submit" class="btn btn-dark">Login ...</button>
    <a href="register.php" class="btn btn-primary">Register</a>
</form>
</body>
</html>