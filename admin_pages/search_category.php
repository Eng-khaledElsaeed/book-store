<?php
if(isset($_POST['search_category'])){
    $search_category =$_POST['search_category'];
    $condition="category_name LIKE '%$search_category%' OR category_id LIKE '%$search_category%' OR category_desc LIKE '%$search_category%' OR category_status LIKE '%$search_category%'";
    $categories_query=mysqli_query($conn,"SELECT COUNT(*) as categories_count FROM category WHERE $condition");

    while ($count_categories=mysqli_fetch_assoc($categories_query)){
        $all_categories=$count_categories['categories_count'];
    };
}
?>