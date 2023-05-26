<?php
    // Connect to the database
    include '../database/config.php';
    // Records per page is set to 10
    $pagesize = 10;      
    $start_rec =0;
    
    if(isset($_POST['search_category'])){
        $search_category =$_REQUEST['search_category'];
    }else{
        $search_category = "";
    };

    $condition="category_name LIKE '%$search_category%' OR category_id LIKE '%$search_category%' OR category_desc LIKE '%$search_category%' OR category_status LIKE '%$search_category%'";
    $categories_query=mysqli_query($conn,"SELECT COUNT(*) as categories_count FROM category WHERE $condition");

    while ($count_categories=mysqli_fetch_assoc($categories_query)){
        $all_categories=$count_categories['categories_count'];
    };

    // calculate number of pages
    $num_pages = ceil($all_categories/$pagesize);
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
    $query_1_categories=mysqli_query($conn,"SELECT * FROM category WHERE $condition LIMIT $start_rec, $pagesize");

    if(mysqli_num_rows($query_1_categories)>0){
        while($row_1_categories=mysqli_fetch_assoc($query_1_categories)){
            $query_5_products=mysqli_query($conn,"SELECT COUNT(*) AS count_products_of_category FROM products WHERE category_id={$row_1_categories['category_id']}");
            while($row_5_products=mysqli_fetch_assoc($query_5_products)){
                $count_products_of_category=$row_5_products['count_products_of_category'];
            };
            $category_id=$row_1_categories['category_id'];
            echo 
            "<tr id='row-$category_id'>
                <td>$slno</td>
                <td>{$row_1_categories['category_name']}</td>
                <td>{$row_1_categories['category_desc']}</td>
                <td>{$row_1_categories['category_status']}</td>
                <td>{$count_products_of_category}</td>
                <td><button type='button' id='update_btn-$category_id' class='update_btn' data-value='category' data-id='$category_id'>update</button></td>
                <td><button type='button' id='delete_btn-$category_id' class='delete_btn' data-value='category' data-id='$category_id'>delete</button></td>
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