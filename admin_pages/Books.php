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
        "page"=>"same_window",
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
            "page"=>"Book.php",
        ];
        // Move the uploaded file to the target path 
        move_uploaded_file($_FILES["pro-image"]["tmp_name"], $prod_image_url);
    }else{
        $message=[
            "type"=>"error",
            "title"=>"Product Failed To Add please call adminstrator",
            "page"=>"same_window",
        ];
    }
};


if(isset($_REQUEST['delete_prod_id'])){
    $id=$_REQUEST['delete_prod_id'];
    
    $query_3_product=mysqli_query($conn,"SELECT * FROM products where prod_id=$id");
    if(mysqli_num_rows($query_3_product)){
        $row = mysqli_fetch_assoc($query_3_product);
        if (file_exists($row['prod_imag_url'])) {
            unlink($row['prod_imag_url']);
        }
        $query=mysqli_query($conn,"DELETE FROM products WHERE prod_id = $id");
        if ($query) {
            $message=[
                "type"=>"success",
                "title"=>"Product Successfully Deleted",
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
        <div class="button">
            <a href="add_book.php" class="btn">Add New Book</a>
        </div>
        <div class="main_item all_books show">
            <div class="table_head">
                <h3> Display All Books</h3>
            </div>
            <div class="table">
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
                        // Records per page is set to 5
                        $pagesize = 10;      
                        $start_rec =0;
                        // calculate number of pages
                        $books_query=mysqli_query($conn,"SELECT COUNT(*) as books_count FROM products");
                        while ($count_books=mysqli_fetch_assoc($books_query)){
                            $all_books=$count_books['books_count'];
                        }
                        $num_pages = ceil($all_books/$pagesize);

                        // if the page is greater than the number of pages, display the last page
                        $next_page_disable=false;
                        $privious_page_disable=false;
                        
                        if(isset($_REQUEST['page'])){
                            if($_REQUEST['page']>=$num_pages ){
                                $curr_page=$num_pages;
                                $next_page_disable=true;
                            }elseif($_REQUEST['page']<=1){
                                $curr_page=1;
                                $privious_page_disable=true;
                            }else{
                                $curr_page = $_REQUEST['page'];
                            }
                        }
                        else{
                            $curr_page = 1;
                        }
                        $privious_page=$curr_page-1;
                        $next_page=$curr_page+1;


                        // Calculating the starting record number
                        $start_rec = (($curr_page-1) * $pagesize) ;


                            
                        // Content of the table
                        $slno = $start_rec + 1;       
                        $query_2_products=mysqli_query($conn,"SELECT p.* ,c.category_name FROM products p INNER JOIN category c ON p.category_id=c.category_id LIMIT $start_rec, $pagesize");
                        if(mysqli_num_rows($query_2_products)>0){
                            
                            
                            while($row_2_products=mysqli_fetch_assoc($query_2_products)){
                               $prod_id=$row_2_products['prod_id'];
                                echo 
                                "<tr id='row-$prod_id'>
                                    <td>$slno</td>
                                    <td>{$row_2_products['prod_name']}</td>
                                    <td>{$row_2_products['category_name']}</td>
                                    <td>{$row_2_products['prod_quant']}</td>
                                    <td>{$row_2_products['price']}</td>
                                    <td>{$row_2_products['status']}</td>
                                    <td><img src='{$row_2_products['prod_imag_url']}' alt=''></td>
                                    <td><button type='button' id='update_btn-$prod_id' class='update_btn' data-product-id='$prod_id'>update</button></td>
                                    <td><button type='button' id='delete_btn-$prod_id' class='delete_btn' data-product-id='$prod_id'>delete</button></td>
                                </tr>";
                                $slno++;
                            }

                        }else{
                            echo "<p style='text-align: center;'>No Data Found</p>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="table_pagnetion">
                <div>

                </div>
                <div class="paginations_controles">
                    <?php
                        $start = max(1, $curr_page - 5);
                        $end = min($num_pages, $curr_page + 5);

                        if ($privious_page_disable) {
                            echo "<span style='color: #878787;cursor: auto;'>&lt; previous</span>";
                        } else {
                            echo "<a href='?page=$privious_page&per-pages=$num_pages'>&lt; previous</a>";
                        };

                        for ($i = $start; $i <= $end; $i++) {
                            if ($i == $curr_page) {
                                echo "<span style='color:white;background: #878787;padding: 5px;border-radius: 50%;font-size: 17px;'>$i</span>";
                            } else {
                                echo "<a href='?page=$i&per-pages=$num_pages'>$i</a>";
                            }
                        };

                        if ($next_page_disable) {
                            echo "<span style='color: #878787;cursor: auto;'>next &gt;</span>";
                        } else {
                            echo "<a href='?page=$next_page&per-pages=$num_pages'>next&gt;</a>";
                        };
                    ?>
                </div>
                <div class="numper_of_pages">
                    <span> <?php echo "NO pages: ".$num_pages; ?></span>
                </div>
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