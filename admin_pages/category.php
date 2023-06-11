<?php
include '../database/config.php';
//Beginning the session.
session_start();

if(isset($_REQUEST['delete_id'])){
    $id=$_REQUEST['delete_id'];
    $query_3_category=mysqli_query($conn,"SELECT * FROM category where category_id=$id");
    if(mysqli_num_rows($query_3_category)){
        $row = mysqli_fetch_assoc($query_3_category);
        $query=mysqli_query($conn,"DELETE FROM category WHERE category_id = $id");
        if ($query) {
            $message=[
                "type"=>"success",
                "title"=>"category Successfully Deleted",
                "page"=>"same_window",
            ];
        }

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
    <title>category</title>
    <!-- sweetalert -->
        <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css
    " rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    <main class="main" style="padding:0px" >
        <div class="button">
            <a href="add_category.php" class="btn">Add New category</a>
        </div>
        <div class="main_item all_category basic_table show" data-content="item4">
            <div class="table_head">
                <h3> Display All categories</h3>
            </div>
            <div class="table">  
                <div class="search">
                    <input type="text" id="searchValue" placeholder="search by category id&desc&status" onkeyup="category_fill(page=1,search_value=this.value);">
                </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>category Name</th>
                        <th>category description</th>
                        <th>category status</th>
                        <th>Num Books</th>
                        <th>update</th>
                        <th>delete</th>
                    </tr>
                </thead>
                <tbody id="category_table">
                    
                </tbody>
            </table>
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
    <script src="../js/ajax_category_search.js"></script>
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