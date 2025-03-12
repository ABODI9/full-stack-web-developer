<?php
include 'action.php';
include 'header.php';
// Get the user data to be modified
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $sql="SELECT * FROM users WHERE id = ?";
    $bit=$conn->prepare($sql);
    $bit->bind_param("i",$id);
    $bit->execute();
    $result=$bit->get_result();
    $user=$result->fetch_assoc();
}
if(isset($_POST['update'])){
    $id=$_POST['id'];
    $username=$_POST['username'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];

    $sql="UPDATE users SET username=?,email=?,phone=? WHERE id=?";
    $bit=$conn->prepare($sql);
    $bit->bind_param("sssi",$username,$email,$phone,$id);

    if($bit->execute()){
    header("Location:view.php");

    }
    else{
        print "error 405";
    }

}



?>


<form action="update.php" method="post">
    <input type="hidden" name="id" id="id" value="<?=$user['id']?>">
    <label for="username">username:</label>
    <input type="text" name="username" id="username" class="form-control" placeholder="Enter username ..." value="<?=$user['username']?>">
    <br>
    <label for="email">Email :</label>
    <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" value="<?=$user['email']?>">
    <br>
    
    <label for="phone">phone</label>
    <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter phone ...." value="<?=$user['phone']?>">
    <br>
    <button type="submit" class="btn btn-dark" name="update">Save</button>


</form>