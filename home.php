<?php
include 'database/config.php';
session_start();


$user_id=$_SESSION['user_id'];
if(!isset($user_id)){
    header("location:sign_in.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- main css file -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    




















    <!-- main javascript file  -->
    <script src="https://kit.fontawesome.com/9e0e68f55e.js" crossorigin="anonymous"></script>
    <!-- <script src="https://apis.google.com/js/platform.js" async defer></script> -->
    <script src="js/main.js"></script>
</body>
</html>