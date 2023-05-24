<?php
include '../database/config.php';
//Beginning the session.
session_start();
if(isset($_GET['update_id'])){
    $prod_id=$_GET['update_id'];
    $query="SELECT * FROM products WHERE prod_id='$prod_id'";
    $result=mysqli_query($conn,$query);
    $row=mysqli_fetch_array($result);
}


if(isset($_POST['update-product'])){
    $book_name=mysqli_real_escape_string($conn,$_POST['pro-name']);
    $book_desc=$_POST['pro-description'];
    $book_amount=$_POST['pro-amount'];
    $book_price=$_POST['pro-price'];
    $status="available";
    $book_category_id=$_POST['pro-category'];
    $book_update_id=$_SESSION['admin_id'];
    $book_stock_id=$_POST['pro-stock'];

    if($_FILES["pro-image"]["error"] == UPLOAD_ERR_OK){
        // Specify the directory where you want to save the uploaded image
        $targetDir = "../uploaded_img/";
        $filename = uniqid() . "_" . $_FILES["pro-image"]["name"];  // Generate a unique filename for the uploaded image
        $prod_image_url = $targetDir . $filename; // Create the full path to the target directory
    } else {
       $message=[
        "type"=>"error",
        "title"=>"Error: " . $_FILES["pro-image"]["error"],
        "page"=>"same_window",
       ];
    }



    // Move the uploaded file to the target path
    if(move_uploaded_file($_FILES["pro-image"]["tmp_name"], $prod_image_url)){
        // delete image
        unlink($row['prod_imag_url']);
        $sql = "UPDATE products SET prod_name='$book_name' ,prod_desc='$book_desc' ,prod_quant='$book_amount' ,price='$book_price' 
        ,status='$status' ,category_id='$book_category_id' ,user_id='$book_update_id' ,stock_id='$book_stock_id' ,prod_imag_url='$prod_image_url' 
        WHERE prod_id='$prod_id'";
        $query=mysqli_query($conn,$sql);
        if ($query) {
            // echo "New record created successfully";
            $message=[
                "type"=>"success",
                "title"=>"Product Successfully updated",
                "page"=>"Books.php",
            ];
        }else{
            $message=[
                "type"=>"error",
                "title"=>"Product Failed To update please call adminstrator",
                "page"=>"same_window",
            ];
        }
    }

}



//Checking if the user is logged in, if not then redirect him to login page.
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
    <title>update book</title>
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
        <div class="main_item book_forms show" data-content="item3">
            <div class="update_form">
                <h3>update Product ID:# <?php echo $prod_id ?></h3>
                <form action="" method="post" enctype="multipart/form-data" class="form2">

                    <label for="name">Product Name:</label>
                    <input type="text" id="name" name="pro-name" required value='<?php echo $row['prod_name']?>'>

                    <label for="amount">Quantity:</label>
                    <input type="number" id="amount" name="pro-amount" required placeholder="quantity" value='<?php echo $row['prod_quant']?>' >

                    <label for="price">Price:</label>
                    <input type="number" id="price" name="pro-price" required placeholder="price" value='<?php echo $row['price']?>'>

                    <label for="image">upload Image:</label>
                    <input type="file" id="image" name="pro-image" required accept="image/*" value='<?php echo $row['prod_imag_url']?>'> 
                    <!-- (accept="image/*")-> this prevent file input to select unexpected files -->

                    <label for="description">Description:</label>
                    <input type="text" id="description" name="pro-description" required value='<?php echo $row['prod_desc']?>'>

                    
                    
                    <label for="category">Category:</label>
                    <select id="category" name="pro-category" required>
                    <option value="">Select a category</option>
                    <?php
                    $query_0_categ=mysqli_query($conn,"SELECT * FROM `category` ORDER BY category_name");
                    if(mysqli_num_rows($query_0_categ) > 0){
                        
                        while($row_0_categ=mysqli_fetch_assoc($query_0_categ)){
                            $cat_value=$row_0_categ["category_id"];
                            $cat_name=$row_0_categ["category_name"];
                            echo "<option value='{$cat_value}'>{$cat_name}</option>";
                        }
                    }
                    ?>
                    </select>

                    <label for="stock">stock name:</label>
                    <select id="stock" name="pro-stock" required >
                    <option value="">Select a stock</option>

                    <?php
                    $query_0_stock=mysqli_query($conn,"SELECT * FROM stock ORDER BY stock_name");
                    if(mysqli_num_rows($query_0_stock) > 0){
                        while($row_0_stock=mysqli_fetch_assoc($query_0_stock)){
                            $stock_value=$row_0_stock["stock_id"];
                            $stock_name=$row_0_stock["stock_name"];
                            echo "<option value='{$stock_value}'>{$stock_name}</option>";
                        }
                    }
                    ?>
                    </select>
                    
                    <input type="submit" name="update-product" value="update Product">
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