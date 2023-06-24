<?php
include '../../database/config.php';
//Beginning the session.
session_start();
if(isset($_POST['add-category'])){
    $category_name=mysqli_real_escape_string($conn,$_POST['category-name']);
    $category_desc=mysqli_real_escape_string($conn,$_POST['category-description']);
    $category_status=$_POST['category-status'];
    $category_updated_id=$_SESSION['admin_id'];


    $sql = "INSERT INTO category(category_name,category_desc,category_status) 
    VALUES ('$category_name','$category_desc','$category_status')";

    $query=mysqli_query($conn,$sql);
    if ($query) {
        // echo "New record created successfully";
        $message=[
            "type"=>"success",
            "title"=>"category Successfully Added",
            "page"=>"category.php",
        ];
    }else{
        $message=[
            "type"=>"error",
            "title"=>"Product Failed To Add please call adminstrator",
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
    header("location:../../sign_in.php");
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add category</title>
    <!-- sweetalert -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css" rel="stylesheet">
    <!-- main css file -->
    <link rel="stylesheet" href="../../css/side_config.css">
    <link rel="stylesheet" href="../../css/admin_style.css">
</head>
<body>
   <div class="dashboard_layout">
    <!-- include header code  -->
    <?php include('../page_parts/admin_header.php'); ?>
    <!-- include sidenav code  -->
    <?php include('../page_parts/admin_sidenav.php'); ?>
    <main class="main" style="padding:10px">
        <div class="main_item category_forms show" data-content="item4">
            <div class="add_form">
                <h3>Add category</h3>
                <form action="" method="post" enctype="multipart/form-data" class="form4">

                    <label for="name">Category Name:</label>
                    <input type="text" id="name" name="category-name" required>

                    <label for="description">category Description:</label>
                    <input type="text" id="description" name="category-description" required>

                    <label for="category">Category status:</label>
                    <select id="category" name="category-status" required>
                    <option value="">Select a category status</option>
                    <option value="available">available</option>
                    <option value="unavailable">unavailable</option>
                    </select>
                    
                    <input type="submit" name="add-category" value="add new category">
                </form>
            </div>
            
        </div>
    </main>
 <?php include('../page_parts/admin_footer.php'); ?>
   </div>
    <!-- main javascript file  -->
    <script src="https://kit.fontawesome.com/9e0e68f55e.js" crossorigin="anonymous"></script>
    <!-- sweetalert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.js"></script>
    <script src="../../js/admin.js"></script>

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