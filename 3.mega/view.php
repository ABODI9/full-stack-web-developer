<?php

session_start();
if(!isset($_SESSION['username'])){
    header("Location:login.php");
}
include 'action.php';
include 'header.php';


$sql="SELECT * FROM users";
$result=$conn->query($sql);

if($result->num_rows>0){


    print "<table class='table table-bordered'>";
    print "<tr>
    <th>ID</th>
    <th>username</th>
    <th>email</th>
    <th>phone</th>
     <th>Action</th>
    </tr>";
    while($row=$result->fetch_assoc()){
        print "<tr>";
        print "<td>" .$row["id"]."</td>";
        print "<td>" .$row["username"]."</td>";
        print "<td>" .$row["email"]."</td>";
        print "<td>" .$row["phone"]."</td>";
        print "<td>
        <a href='update.php?id=".$row["id"]."' class='btn btn-warning'>Update</a> 
        <a href='delete.php?id=".$row['id']."' class='btn btn-danger'>Delete</a>
        </td>";
        print"</tr>";
    }
    print "</table>";
} 
else{
    print "No user Found";
}

?>
  
  <h1> Welcome , <?php echo  $_SESSION["username"];?>!</h1> 
  <a href="logout.php">Logout</a>