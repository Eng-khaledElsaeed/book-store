<?php
include '../database/config.php';
//Beginning the session.
session_start();
if(isset($_POST['add-admin'])){
    $admin_name=mysqli_real_escape_string($conn,$_POST['admin-name']);
    $admin_phone=$_POST['admin-phone'];
    $admin_email=$_POST['admin-email'];
    $admin_password=$_POST['admin-pass'];
    $user_role="admin";

    if($_FILES["admin-image"]["error"] == UPLOAD_ERR_OK){
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

    $sql = "INSERT INTO users(user_name,image,phone,email,user_pass,user_role) 
    VALUES ('$admin_name','$user_image_url','$admin_phone','$admin_email','$admin_password','$user_role')";
    $query=mysqli_query($conn,$sql);
    if ($query) {
        // echo "New record created successfully";
        $message=[
            "type"=>"success",
            "title"=>"Admin Successfully Added",
            "page"=>"admin_accounts.php",
        ];
        // Move the uploaded file to the target path 
        move_uploaded_file($_FILES["admin-image"]["tmp_name"], $admin_image_url);
    }else{
        $message=[
            "type"=>"error",
            "title"=>"admin Failed To Add please call adminstrator",
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
    <title>add admin</title>
    <!-- sweetalert -->
        <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css
    " rel="stylesheet">
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
        <div class="main_item book_forms show" data-content="item9">
            <div class="add_form">
                <h3>Add admin</h3>
                <form action="" method="post" enctype="multipart/form-data" class="form2">
                 
                    <label for="name">admin Name :</label>
                    <input type="text" id="name" name="admin-name" required placeholder="Admin Name...">

                    <label for="admin_pass">Admin Password : </label>
                    <input type="password" name="admin-pass" id="admin_pass" required placeholder="admin password...">

                    <label for="phone">phone :</label>
                    <input type="text" id="phone" name="admin-phone" placeholder="Enter phone...">

                    <label for="email">Email :</label>
                    <input type="email" id="email" name="admin-email" required placeholder="Entaer Email...">

                    <label for="image">upload Image:</label>
                    <input type="file" id="image" name="admin-image" accept="image/*"> 
                    <!-- (accept="image/*")-> this prevent file input to select unexpected files -->
                    </select>
                    <input type="submit" name="add-admin" value="Add Admin">
                </form>
            </div>
            
        </div>
    </main>
 <?php include('admin_footer.php'); ?>
   </div>
    <!-- main javascript file  -->
    <script src="https://kit.fontawesome.com/9e0e68f55e.js" crossorigin="anonymous"></script>
    <!-- sweetalert -->
    <script src="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js
    "></script>
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