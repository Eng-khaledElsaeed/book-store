<?php
include '../../database/config.php';
//Beginning the session.
session_start();

if(isset($_REQUEST['delete_id'])){
    $id=$_REQUEST['delete_id'];
    
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
                "title"=>"Book Successfully Deleted",
                "page"=>"same_window",
            ];
        }else{
            $message=[
                "type"=>"error",
                "title"=>"book unable Delete",
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
    header("location:../../sign_in.php");
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
    <main class="main" style="padding:0px">
        <div class="button">
            <a href="add_book.php" class="btn">Add New Book</a>
        </div>
        <div class="main_item all_books basic_table show" data-content="item3">
            <div class="table_head">
                <h3> Display All Books</h3>
            </div>
            <div class="table">
                <div class="search">
                    <input type="text" id="searchValue" placeholder="search by category id&desc&status" onkeyup="book_fill(page=1,search_value=this.value);">
                </div>
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
                    <tbody id="books_table">
                       
                    </tbody>
                </table>
            </div>
            
        </div>
        
    </main>

    <?php include('../page_parts/admin_footer.php'); ?>

   </div>
    <!-- main javascript file  -->
    <script src="https://kit.fontawesome.com/9e0e68f55e.js" crossorigin="anonymous"></script>
    
  <!-- sweetalert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.js"></script>
    
    <script src="ajax_books_search.js"></script>
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