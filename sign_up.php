<?php
include 'database/config.php';


if(isset($_POST['submit'])){

$name=mysqli_real_escape_string($conn,$_POST['name']);
$email=mysqli_real_escape_string($conn,$_POST['email']);
$pass=mysqli_real_escape_string($conn, md5 ($_POST['password']));
$cpass=mysqli_real_escape_string($conn, md5 ($_POST['cpassword']));
$hidden_strength=$_POST['strength'];

$user_role="user";
$user_found=mysqli_query($conn,"SELECT * FROM Users WHERE email='$email'");

if(mysqli_num_rows($user_found)>0){
$messages[]="user Already Exist!";
}else{
    if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        $messages[]="this Email invalid.";
    }
    elseif($hidden_strength < 4){
        $messages[]="your password strength is low!";
    }
    elseif ($pass!=$cpass) {
        $messages[]="Password Not Matched!";
    }else{
        $query=mysqli_query($conn,"INSERT INTO Users(user_name,email,user_pass,user_role) VALUES('$name','$email','$pass','$user_role')");
        if($query){
            $messages[]="successflly Registration!";
        }
        header("location:sign_in.php?success=welcome to our website");
    }
}
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="here you can sign up as a new user">

    <!-- main title of page -->
    <title>book-store - signup new user</title>

    <!-- main css file -->
    <link rel="stylesheet" href="css/side_config.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="shape-1"></div>
    <div class="shape-3"></div>
    <div class="form-page">
        <div class="form-container">
            <form action="" method="post" id="form0" name="form0">
                <h3>register now</h3>
            
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

               <input type="text" name="name" id="name" placeholder="Enter Your Name" required class="box">
               <input type="email" name="email" id="email" placeholder="Enter Your email" required class="box">

               <div class="password-container">
                    <input type="password"  name="password" id="password" placeholder="Enter Your password" required class="box">

                    <span class="show-pass" onclick="toggle('password')">
                        <i class="far fa-eye" onclick="show(this)"></i>
                    </span>
                </div>
                <!---------- password strength ------->
                <input type="hidden" id="strength" name="strength">

                <div id="password-strength" 
                    class="progress-bar"
                    name="progress-bar" 
                    role="progressbar" 
                    aria-valuenow="40" 
                    aria-valuemin="0" 
                    aria-valuemax="100" 
                    style="width:0%">
                </div>

                <!---------- this list of the format of password that you have to follow ---------->
                <ul class="pass-format-list">
                    <li class="">
                        <span class="low-upper-case">
                            <i class="fas fa-circle" aria-hidden="true"></i>
                            &nbsp;Lowercase &amp; Uppercase
                        </span>
                    </li>
                    <li class="">
                        <span class="one-number">
                            <i class="fas fa-circle" aria-hidden="true"></i>
                            &nbsp;Number (0-9)
                        </span> 
                    </li>
                    <li class="">
                        <span class="one-special-char">
                            <i class="fas fa-circle" aria-hidden="true"></i>
                            &nbsp;Special Character (!@#$%^&*)
                        </span>
                    </li>
                    <li class="">
                        <span class="eight-character">
                            <i class="fas fa-circle" aria-hidden="true"></i>
                            &nbsp;At least 8 Character
                        </span>
                    </li>
                </ul>

               <!-- <progress max="100" value="0" id="meter"></progress> -->
               <div class="password-container">
                   <input type="password" name="cpassword" id="cpassword" placeholder="confirm Your Password" required class="box" >
                    <span class="show-pass" onclick="toggle('cpassword')">
                        <i class="far fa-eye" onclick="show(this)"></i>
                    </span>
               </div>
               <div class="submit-btn">
                   <input type="submit" name="submit" value="register" class="btn" >
               </div>

            <!-- this is place for other account authorization like google facebook -->
               <!-- <div class="g-signin2" data-onsuccess="onSignIn"></div> -->

               <p>Already have an account?sign in now  <a href="sign_in.php">here <i class="fa-solid fa-arrow-right"></i></a></p>
           </form>
        </div>
    </div>

    <!-- main javascript file  -->
    <script src="https://kit.fontawesome.com/9e0e68f55e.js" crossorigin="anonymous"></script>

    <!-- <script src="https://apis.google.com/js/platform.js" async defer></script> -->
    <script src="js/main.js"></script>
</body>
</html>



