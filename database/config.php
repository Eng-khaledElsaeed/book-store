<?php
$host="localhost";
$username="root";
$password="";
$DBname="Book_Store";

// Setting up connection with database Geeks
$conn = mysqli_connect($host,$username,$password,$DBname) or die("Couldn't connect to database");


// mysqli_query($conn,"INSERT INTO Users(user_name,email,user_pass,user_role) VALUES('khaled elsaeed abdelfattah','admin.khaled1@gmail.com',md5('Admin@Khaled@010'),'admin')");

?>