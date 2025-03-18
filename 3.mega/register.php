<?php
include 'action.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
    $phone=$_POST['phone'];

    //check if username already exists
    $sql ="SELECT id FROM users WHERE username=?";
    $bit=$conn->prepare($sql);
    $bit->bind_param("s",$username);
    $bit->execute();
    $bit->store_result();

    if($bit->num_rows>0){
        header("Location:login.php");
    }
    else{
        // Insert new user 
        $sql ="INSERT INTO users(username,email,password,phone) VALUES(?,?,?,?)";
        $bit=$conn->prepare($sql);
        $bit->bind_param("ssss",$username,$email,$password,$phone);

        if($bit->execute()){
            header("Location:login.php");
        }
        else{
            echo "error 480";
        }
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<form action="register.php" method="post">
    <label for="username">UserName:</label>
    <input type="text" name="username" id="username" placeholder="Enter username" class="form-control" required>
    <br>
    <label for="email">Email</label>
    <input type="email" name="email" id="email" placeholder="info@scramblebit.com" class="form-control" required>
    <br>
    <label for="password" >Password :</label>
    <input type="password" name="password" id="password" placeholder="Enter password" class="form-control" required>
    <br>
    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" placeholder="Enter phone Number" class="form-control"  required>
<br>
    <button type="submit" class="btn btn-dark">Register ...</button>
    <a href="login.php" class="btn btn-warning">Login</a>
</form>
</body>
</html>
