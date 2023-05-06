<header class="header">
        <div class="menu-icon">
            <i class="fas fa-bars"></i>
        </div>

        <div class="header_left">
            <div class="header__search">Search...</div>
        </div>

        <div class="header_right">
            <div class="user_face">
                <?php 
               $query_0_users=mysqli_query($conn,"SELECT * FROM users WHERE user_id=$admin_id")  or die("something wrong occur!");
               if(mysqli_num_rows($query_0_users)>0){
                   $row_0_users=mysqli_fetch_assoc($query_0_users);
                   echo(
                    "<img src={$row_0_users['image']} alt='' class='user_image'>
                    <p class='user_name'>{$row_0_users['user_name']}</p>"
                    ) ;
               }
                ?>
                <i class="fa-solid fa-chevron-down user_arrow"></i>
                <div class="user_info">
                    <p><span>Email: </span><?php echo ($row_0_users['email']);?> </p>
                    <p><span>password: </span>&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;</p>
                    <!-- <a href="#"><i class="fa-solid fa-circle-user"></i> Change Profile</a> -->
                </div>
            </div>
            <div class="message_count">
                <div>
                    <i class="fa-solid fa-bell"></i>
                </div>
                <div>
                    <p>
                        <?php
                        $query_0_message=mysqli_query($conn,"SELECT * FROM `message`");/*ORDER BY message_time DESC*/
                        if(mysqli_num_rows($query_0_message)>0){ 
                                         
                            echo mysqli_num_rows($query_0_message);
                        }else{
                            echo 0;
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <?php 
        function find_message_time($timestamp){
            $date = date('d/m/Y', strtotime($timestamp));
            $time = date('h:i A', strtotime($timestamp));
            if($date==date('d/m/Y')){
                echo $time ;          
            } elseif($date == date('d/m/Y',strtotime("yesterday"))){
                echo "yesterday";
            }
            else{
                echo $date;
            }
        }
        ?>

    </header>