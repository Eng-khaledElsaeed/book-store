<?php
include 'database/config.php';
session_start();

if(substr(($_SERVER['REQUEST_URI']),strpos(($_SERVER['REQUEST_URI']),'?')) > 0){
    $messages[]=$_GET['success'];
}

if(isset($_POST['submit'])){

$email=mysqli_real_escape_string($conn,$_POST['email']);
$pass=mysqli_real_escape_string($conn, md5 ($_POST['password']));

$user_Login=mysqli_query($conn,"SELECT * FROM Users WHERE email='$email' && user_pass='$pass'");

if(mysqli_num_rows($user_Login)>0){
    $row=mysqli_fetch_assoc($user_Login);
    if($row['user_role']=='admin'){
        $_SESSION['admin_name']=$row['user_name'];
        $_SESSION['admin_email']=$row['email'];
        $_SESSION['admin_id']=$row['user_id'];
        header("location:admin_pages/dashboard/dashboard.php");
    }elseif($row['user_role']=='user'){
        $_SESSION['user_name']=$row['user_name'];
        $_SESSION['user_email']=$row['email'];
        $_SESSION['user_id']=$row['user_id'];
        header("location:home.php");
    }
    mysqli_query($conn,"UPDATE users set connection_status='online' , last_seen=now() where user_id='".$row['user_id']."'");
}else{
    $messages[]="incorect email or password!";
}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>book-store - signin user</title>
    <!-- main css file -->
    <link rel="stylesheet" href="css/side_config.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="shape-1"></div>
    <div class="shape-3"></div>
    <div class="form-page">
        <div class="form-container">
            <form action="" method="post" id="form1" name="form1">
               <h3>login now</h3>
               <?php
               if(isset($messages)){
                
                foreach($messages as $message){
                    echo '<div class="message">
                            <span>'.$message.'</span>
                            <i class="fa fa-times" onclick="this.parentElement.remove();"></i>
                          </div>';
                }
               }
               ?>
               <input type="email" name="email" id="email" placeholder="Enter Your email" required class="box">
               <div class="password-container">
                    <input type="password" name="password" id="password" placeholder="Enter Your password" required class="box">
                    <span class="show-pass" onclick="toggle('password')">
                        <i class="far fa-eye" onclick="show(this)"></i>
                    </span>
                </div>

               <div class="submit-btn">
                   <input type="submit" name="submit" value="login" class="btn" >
               </div>

              <!-- this is place for other account authorization like google facebook -->
               <!-- <div class="g-signin2" data-onsuccess="onSignIn"></div> -->
               
               <p>i need account? sign up now  <a href="sign_up.php">here <i class="fa-solid fa-arrow-right"></i></a></p>
           </form>
        </div>
    </div>

    <!-- main javascript file  -->
    <script src="https://kit.fontawesome.com/9e0e68f55e.js" crossorigin="anonymous"></script>
    <!-- <script src="https://apis.google.com/js/platform.js" async defer></script> -->
    <script src="js/main.js"></script>
</body>
</html>