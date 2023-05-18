<?php
include '../database/config.php';
//Beginning the session.
session_start();
if(isset($_POST['add-product'])){
    
    $book_name=mysqli_real_escape_string($conn,$_POST['pro-name']);
    $book_desc=$_POST['pro-description'];
    $book_amount=$_POST['pro-amount'];
    $book_price=$_POST['pro-price'];
    $status="available";
    $book_category_id=$_POST['pro-category'];
    $book_added_id=$_SESSION['admin_id'];
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
       ];
    }

    $sql = "INSERT INTO products(prod_name,prod_desc,prod_quant,price,status,category_id,user_id,stock_id,prod_imag_url) 
    VALUES ('$book_name','$book_desc','$book_amount','$book_price','$status','$book_category_id','$book_added_id','$book_stock_id','$prod_image_url')";
    $query=mysqli_query($conn,$sql);
    if ($query) {
        // echo "New record created successfully";
        $message=[
            "type"=>"success",
            "title"=>"Product Successfully Added",
        ];
        // Move the uploaded file to the target path 
        move_uploaded_file($_FILES["pro-image"]["tmp_name"], $prod_image_url);
    }else{
        $message=[
            "type"=>"error",
            "title"=>"Product Failed To Add please call adminstrator",
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

    <main class="main" style="padding:0px">
        <div class="buttons">
            <a href="add_book.php" class="btn">Add New Book</a>
        </div>
        <div class="main_item all_books show">
            <div class="table">
                <h3> Display All Books</h3>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Book Name</th>
                            <th>Book Category</th>
                            <th>Book quantity</th>
                            <th>Book Price</th>
                            <th>status</th>
                            <th>Book Image</th>
                            <th>update</th>
                            <th>delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query_2_products=mysqli_query($conn,"SELECT p.* ,c.category_name FROM products p INNER JOIN category c ON p.category_id=c.category_id");
                        if(mysqli_num_rows($query_2_products)>0){
                            
                            while($row_2_products=mysqli_fetch_assoc($query_2_products)){
                                $i=1;
                                echo 
                            "<tr>
                                <td>$i</td>
                                <td>{$row_2_products['prod_name']}</td>
                                <td>{$row_2_products['category_name']}</td>
                                <td>{$row_2_products['prod_quant']}</td>
                                <td>{$row_2_products['price']}</td>
                                <td>{$row_2_products['status']}</td>
                                <td>{$row_2_products['prod_imag_url']}</td>
                                <td>update</td>
                                <td>delete</td>
                            </tr>";
                            $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="table_pagnetion">
                <a href="#">&lt;privious</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">6</a>
                <a href="#">7</a>
                <a href="#">next&gt;</a>
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