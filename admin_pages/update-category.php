<?php
include '../database/config.php';
//Beginning the session.
session_start();
if(isset($_GET['update_id'])){
    $category_id=$_GET['update_id'];
    $query="SELECT * FROM category WHERE category_id='$category_id'";
    $result=mysqli_query($conn,$query);
    $row=mysqli_fetch_array($result);
};


if(isset($_POST['update-category'])){
    $category_name=mysqli_real_escape_string($conn,$_POST['category-name']);
    $category_desc=mysqli_real_escape_string($conn,$_POST['category-description']);
    $category_status=$_POST['category-status'];
    
    $category_update_id=$_SESSION['admin_id'];   
    $sql = "UPDATE category SET category_name='$category_name' ,category_desc='$category_desc'
    ,category_status='$category_status' WHERE category_id ='$category_id'";
    $query=mysqli_query($conn,$sql);
    if ($query) {
        // echo "New record created successfully";
        $message=[
            "type"=>"success",
            "title"=>"category Successfully updated",
            "page"=>"category.php",
        ];
    }else{
        $message=[
            "type"=>"error",
            "title"=>"Product Failed To update please call adminstrator",
            "page"=>"same_window",
        ];
    };
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
    <title>update category</title>
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
        <div class="main_item category_forms show" data-content="item4">
            <div class="update_form">
                <h3>update category ID:# <?php echo $category_id ?></h3>
                <form action="" method="post" enctype="multipart/form-data" class="form4">

                    <label for="name">Category Name:</label>
                    <input type="text" id="name" name="category-name" required value='<?php echo $row['category_name']?>'>

                    <label for="description">category Description:</label>
                    <input type="text" id="description" name="category-description" required value='<?php echo $row['category_desc']?>'>

                    <label for="category">Category status:</label>
                    <select id="category" name="category-status" required>
                    <option value="">Select a category status</option>
                    <option value="available">available</option>
                    <option value="unavailable">unavailable</option>
                    </select>
                    
                    <input type="submit" name="update-category" value="update category">
                </form>
            </div>
            
        </div>
    </main>

 <?php include('admin_footer.php'); ?>

   </div>
   <script>
     
    </script>
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