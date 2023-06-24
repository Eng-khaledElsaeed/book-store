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
        <div class="main_item pending_orders show" data-content="item10">
            pending_orders
        </div>
    </main>

 <?php include('../page_parts/admin_footer.php'); ?>

   </div>

    <!-- main javascript file  -->
    <script src="https://kit.fontawesome.com/9e0e68f55e.js" crossorigin="anonymous"></script>

   <!-- sweetalert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.js"></script>
    
    <script src="../../js/admin.js"></script>
</body>
</html>