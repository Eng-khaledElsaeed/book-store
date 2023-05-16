<?php
include '../database/config.php';
//Beginning the session.
session_start();

$admin_id=$_SESSION['admin_id'];
if(isset($_GET['timeout']) || !isset($admin_id)){
    mysqli_query($conn, "UPDATE `users` SET connection_status = 'offline' WHERE  user_id='".$admin_id."' LIMIT 1");
    session_unset();
    session_destroy(); 
    header("location:../sign_in.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>books</title>
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



    <main class="main" style="background: #fff;padding:0px">
        <div class="main_item products show">
            <div class="add_products_form">
                <h3>Add Products</h3>
                <form action="" method="post" enctype="multipart/form-data"class="form2">
            
                    <label for="name">Product Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="amount">Amount:</label>
                    <input type="number" id="amount" name="amount" required>

                    <label for="price">Price:</label>
                    <input type="text" id="price" name="price" required>

                    <label for="image">upload Image:</label>
                    <input type="file" id="image" name="image" required>

                    <label for="description">Description:</label>
                    <input type="text" id="description" name="description" required>
                
                    <label for="category">Category:</label>
                    <select id="category" name="category" required>
                    <option value="">Select a category</option>
                    <option value="electronics">Electronics</option>
                    <option value="clothing">Clothing</option>
                    <option value="home">Home</option>
                    </select>
                    
                    <input type="submit" value="Add Product">
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
</body>
</html>