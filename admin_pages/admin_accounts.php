<?php
include '../database/config.php';
//Beginning the session.
session_start();

if(isset($_REQUEST['delete_id'])){
    $id=$_REQUEST['delete_id'];
    $query_5_users=mysqli_query($conn,"SELECT * FROM users where user_id=$id");
    if(mysqli_num_rows($query_5_users)){
        $row = mysqli_fetch_assoc($query_5_users);
        if (file_exists($row['image'])) {
            unlink($row['image']);
        }
        $query=mysqli_query($conn,"DELETE FROM users WHERE user_id=$id");
        if ($query) {
            $message=[
                "type"=>"success",
                "title"=>"Admin Successfully Deleted",
                "page"=>"same_window",
            ];
        }else{
            $message=[
                "type"=>"error",
                "title"=>"Admin unable Delete",
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
};


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin accounts</title>
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

    <main class="main" style="padding:0px;">

        <div class="main_item pending_accounts basic_table show" data-content="item9" style="margin:30px auto;">
            <div class="table_head">
                <h3>Admin Accounts</h3>
            </div>
            <div class="table">    
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>accound model</th>
                        <th>city</th>
                        <th>update</th>
                        <th>delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Records per page is set to 10
                        $pagesize = 10;      
                        $start_rec =0;

                        $user_query = mysqli_query($conn, "SELECT COUNT(*) as users_count FROM users WHERE user_role='admin'");


                        while ($count_users=mysqli_fetch_assoc($user_query)){
                            $all_users=$count_users['users_count'];
                        };

                        // calculate number of pages
                        $num_pages = ceil($all_users/$pagesize);
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
                        };

                        $privious_page=$curr_page-1;
                        $next_page=$curr_page+1;
                        // Calculating the starting record number
                        $start_rec = (($curr_page-1) * $pagesize);
                        // Content of the table
                        $slno = $start_rec + 1; 
                           
                        $query_4_users=mysqli_query($conn,"SELECT * FROM users WHERE user_role='admin' LIMIT $start_rec, $pagesize ");
                        if(mysqli_num_rows($query_4_users)>0){
                            while($row_4_users=mysqli_fetch_assoc($query_4_users)){
                                $user_id=$row_4_users['user_id'];
                                echo 
                                "<tr id='row-$user_id'>
                                    <td>$slno</td>
                                    <td>{$row_4_users['user_name']}</td>
                                    <td>{$row_4_users['phone']}</td>
                                    <td>{$row_4_users['email']}</td>
                                    <td>{$row_4_users['user_role']}</td>
                                    <td>{$row_4_users['city']}</td>
                                    <td><button type='button' id='update_btn-$user_id' class='update_btn' data-value='User' data-id='$user_id'>update</button></td>
                                    <td><button type='button' id='delete_btn-$user_id' class='delete_btn' data-value='User' data-id='$user_id'>delete</button></td>
                                </tr>";
                                $slno++;
                            }
                        }else{
                            echo "<p style='text-align: center;'>No Data Found</p>";
                        };
                    ?>
                    <div class="table_pagnetion">
                        <div></div>
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
                                    $page_link = "?page=" . $i . "&per-pages=" . $num_pages;
                                    $active_class = ($i == $curr_page) ? 'active' : '';
                                    if ($i == $curr_page) {
                                        echo "<span style='color:white;background: #878787;padding: 5px;border-radius: 50%;font-size: 17px;'>$i</span>";
                                    } else {
                                        echo "<a href='$page_link' class='page-link'>$i</a>";
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