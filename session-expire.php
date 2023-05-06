<?php
if(isset($_GET['timeout'])){
    mysqli_query($conn, "UPDATE `users` SET connection_status = 'offline' WHERE  user_id='".$_SESSION['admin_id']."' LIMIT 1");
    session_unset();
    session_destroy(); 
    header("location:login.php");
}

?>