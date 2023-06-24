<?php
include '../database/config.php';
//Beginning the session.
session_start();
if(isset($_POST['add-user'])){
    $user_name=mysqli_real_escape_string($conn,$_POST['user-name']);
    $user_phone=$_POST['user-phone'];
    $user_city=$_POST['user-city'];
    $user_email=$_POST['user-email'];
    $user_password=$_POST['user-pass'];
    $user_role="user";

    if($_FILES["user-image"]["error"] == UPLOAD_ERR_OK){
        // Specify the directory where you want to save the uploaded image
        $targetDir = "../uploaded_img/";
        $filename = uniqid() . "_" . $_FILES["user-image"]["name"];  // Generate a unique filename for the uploaded image
        $user_image_url = $targetDir . $filename; // Create the full path to the target directory
    } else {
       $message=[
        "type"=>"error",
        "title"=>"Error: " . $_FILES["user-image"]["error"],
        "page"=>"same_window",
       ];
    }

    $sql = "INSERT INTO users(user_name,image,phone,email,user_pass,user_role,city) 
    VALUES ('$user_name','$user_image_url','$user_phone','$user_email','$user_password','$user_role','$user_city')";
    $query=mysqli_query($conn,$sql);
    if ($query) {
        // echo "New record created successfully";
        $message=[
            "type"=>"success",
            "title"=>"user Successfully Added",
            "page"=>"accounts.php",
        ];
        // Move the uploaded file to the target path 
        move_uploaded_file($_FILES["user-image"]["tmp_name"], $user_image_url);
    }else{
        $message=[
            "type"=>"error",
            "title"=>"user Failed To Add please call adminstrator",
            "page"=>"same_window",
        ];
    }
};

//Checking if the user is logged in, if not then redirect him to login page.
$admin_id=$_SESSION['admin_id'];
if(isset($_GET['timeout']) || !isset($admin_id)){
    mysqli_query($conn, "UPDATE `users` SET connection_status = 'offline' WHERE  user_id='".$admin_id."' LIMIT 1");
    session_unset();
    session_destroy(); 
    header("location:../sign_in.php");
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add user</title>
    <!-- sweetalert -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css" rel="stylesheet">
    <!-- main css file -->
    <link rel="stylesheet" href="../css/side_config.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
   <div class="dashboard_layout">
    <!-- include header code  -->
    <?php include('admin_header.php'); ?>
    <!-- include sidenav code  -->
    <?php include('admin_sidenav.php'); ?>

    <main class="main" style="padding:10px">
        <div class="main_item book_forms show" data-content="item2">
            <div class="add_form">
                <h3>Add user</h3>
                <form action="" method="post" enctype="multipart/form-data" class="form2">
                 
                    <label for="name">User Name :</label>
                    <input type="text" id="name" name="user-name" required placeholder="user Name...">

                    <label for="user_pass">user Password : </label>
                    <input type="password" name="user-pass" id="user_pass" required placeholder="user password...">

                    <label for="phone">phone :</label>
                    <input type="text" id="phone" name="user-phone" placeholder="Enter phone...">

                    <label for="city">city :</label>
                    <input type="text" id="city" name="user-city" placeholder="Enter city...">

                    <label for="email">Email :</label>
                    <input type="email" id="email" name="user-email" required placeholder="Entaer Email...">

                    <label for="image">upload Image:</label>
                    <input type="file" id="image" name="user-image" accept="image/*"> 
                    <!-- (accept="image/*")-> this prevent file input to select unexpected files -->
                    </select>
                    <input type="submit" name="add-user" value="Add user">
                </form>
            </div>
            
        </div>
    </main>
 <?php include('admin_footer.php'); ?>
   </div>
    <!-- main javascript file  -->
    <script src="https://kit.fontawesome.com/9e0e68f55e.js" crossorigin="anonymous"></script>

    <!-- sweetalert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.js"></script>
    
    <script src="../js/admin.js"></script>

<!-- pase all page messages to javascript-->
    <?php
    if(isset($message)){
        $msg=json_encode($message);
        echo "<script>
        CRUD_message($msg)
        </script>";
    }
    ?>
</body>
</html>