<?php

$servername="localhost";
$username="root";
$password="";
// step-3  Add DataBase to connention
$dbname="magedb";

//step -1 Create Connection
$conn=new mysqli($servername,$username,$password,$dbname);

if($conn->connect_error)
{
    die("connection Failed" .$conn->connect_error);
}
else 
/*
{
    print "Welcome to mrbit System 2025";
}
    */

//step 2 Create DATABASE
/*
$db="CREATE DATABASE magedb"; //Query 

if($conn->query($db)===TRUE)
{
    echo "DATABase Created Successfully";
}
else {
    print "Error Createing DataBase";
}
    */

// step 4 - : CREATE TABLE 
/*
$table="CREATE TABLE users(
id INT(11) AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
phone VARCHAR(255) NOT NULL
)";


if($conn->query($table)===TRUE)
{
    print "TABLE CREATED SUCCESSFULLY";
}
else {
    print "Error Creating Table";
}
*/

//step 5 - Insert DATA

/*
$users="INSERT INTO users(username,email,password,phone) 
               VALUES ('mrbit','info@scramblebit.com','123456789','+90533689933')";

    if($conn->query($users)===TRUE)
    {
        echo "New Record Created Successfuuly";
    }
    else 
    {
        echo "error 404";
    }
        */



?>