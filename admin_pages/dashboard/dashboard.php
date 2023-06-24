<?php
include '../../database/config.php';
//Beginning the session.
session_start();

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
    <title>dashboard</title>
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

    <main class="main">
        <div class="main_item dashboart show" data-content="item1">

            <div class="main-header">
                <div class="main-header__heading">Hello User</div>
                <div class="main-header__updates">Recent Items</div>
            </div>

            <div class="box_container">
                <div class="pending_orders_cart box">
                    <?php
                    $query_0_orders=mysqli_query($conn,"SELECT * FROM orders WHERE `order status`='pending'")  or die("something wrong occur!");
                    if(mysqli_num_rows($query_0_orders) > 0){
                        $row_0_orders=mysqli_fetch_assoc($query_0_orders);
                    }
                    $pending_orders=isset($row_0_orders)? count([$row_0_orders]): 0;
                    ?>
                    <p>pending orders</p>
                    <span><?php echo $pending_orders;?></span>
                </div>
                <div class="pending_products_cart box">
                    <?php
                        $query_0_products=mysqli_query($conn,"SELECT * FROM products WHERE `status`='unavailable'");
                        if(mysqli_num_rows( $query_0_products) >0){
                            $row_0_products=mysqli_fetch_assoc( $query_0_products);
                        }
                        $pending_products=isset( $row_0_products)? count([$row_0_products]): 0;
                    ?>
                    <p>pending products</p>
                    <span><?php echo $pending_products;?></span>
                </div>
                <div class="uncomplete_orders_cart box">
                    <?php
                        $query_1_orders=mysqli_query($conn,"SELECT * FROM orders WHERE `payment_status`='uncompleted'")  or die("something wrong occur!");
                        if(mysqli_num_rows($query_1_orders) > 0){
                            $row_1_orders=mysqli_fetch_assoc($query_1_orders);
                        }
                        $uncomplete_orders=isset($row_1_orders) ? count([$row_1_orders]): 0;
                    ?>
                    <p>uncomplete orders</p>
                    <span><?php echo $uncomplete_orders;?></span>
                </div>
                <div class="complete_orders_cart box">
                    <?php
                    $total_revenu=0;
                        $query_2_orders=mysqli_query($conn,"SELECT payment_status,total_price FROM orders WHERE `payment_status`='completed'")  or die("something wrong occur!");
                        if(mysqli_num_rows($query_2_orders) > 0){
                            $row_2_orders=mysqli_fetch_assoc($query_2_orders);
                        }
                        $complete_orders=isset($row_2_orders) ? count([$row_2_orders]): 0;
                        $total_revenu=isset($row_2_orders) ? $total_revenu+$row_2_orders['total_price'] : 0;
                    ?>
                    <p>complete orders</p>
                    <span><?php echo $complete_orders;?></span>
                </div>
                <div class="revenu_complete_orders_cart box">
                    <p>revenu of orders</p>
                    <span><?php echo $total_revenu;?></span>
                </div>
                <div class="total_admins_cart box">
                    <?php
        
                        $query_1_users=mysqli_query($conn,"SELECT * FROM users WHERE `user_role`='admin'")  or die("something wrong occur!");
                        if(mysqli_num_rows( $query_1_users) > 0){
                            $row_1_users=mysqli_fetch_assoc($query_1_users);
                        }
                        $total_admins=isset($row_1_users) ? count([$row_1_users]): 0;
                    ?>
                    <p>total admins</p>
                    <span><?php echo $total_admins;?></span>
                </div>
                <div class="total_users_cart box">
                    <?php
                    $query_2_users=mysqli_query($conn,"SELECT * FROM users WHERE `user_role`='user'")  or die("something wrong occur!");
                    if($user_count=mysqli_num_rows( $query_2_users) > 0){
                        $num_users=$user_count;
                    }else{
                        $num_users=0;
                    }
                    ?>
                    <p>unmber of users</p>
                    <span><?php echo $num_users;?></span>
                </div>
                <div class="unm_products_cart box">
                    <?php
                    $query_1_products=mysqli_query($conn,"SELECT * FROM products");
                    if($pro_count=mysqli_num_rows( $query_1_products) >0){
                        $num_products= $pro_count;
                    }else{
                        $num_products=0;
                    }
    
                    ?>
                    <p>number of products</p>
                    <span><?php echo $num_products;?></span>
                </div>            
            </div>

            <div class="main-cards">
                <div class="card chart1">
                    <svg id="product-chart"></svg>
                    
                </div>
                <div class="card">Card</div>
                <div class="card">Card</div>
            </div>
           
        </div>


                

    </main>

 <?php include('../page_parts/admin_footer.php'); ?>

   </div>
    <!-- D3.js charts in dashboard -->
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <!-- main javascript file  -->
    <script src="https://kit.fontawesome.com/9e0e68f55e.js" crossorigin="anonymous"></script>

    <!-- sweetalert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.js"></script>
    
    <script src="../../js/admin.js"></script>
</body>
</html>