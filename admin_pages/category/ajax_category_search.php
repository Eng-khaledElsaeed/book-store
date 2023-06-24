<?php
include '../../database/config.php';
$search_category=$_GET['search_value'];

$pagesize = 10;
$start_rec =0;

$condition="category_name LIKE '%$search_category%' OR category_id LIKE '%$search_category%' OR category_desc LIKE '%$search_category%' OR category_status = '$search_category'";
$categories_query=mysqli_query($conn,"SELECT COUNT(*) as categories_count FROM category WHERE $condition");
while ($count_categories=mysqli_fetch_assoc($categories_query)){
    $all_categories=$count_categories['categories_count'];
};
// calculate number of pages
$num_pages = ceil($all_categories/$pagesize);
// if the page is greater than the number of pages, display the last page

$next_page_disable=false;
$privious_page_disable=false;
if(isset($_GET['page'])){
    if($_GET['page']>=$num_pages ){
        $curr_page=$num_pages;
        $next_page_disable=true;
    }elseif($_GET['page']<=1){
        $curr_page=1;
        $privious_page_disable=true;
    }else{
        $curr_page = $_GET['page'];
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

$category_arr = array(); // Initialize the category array

if($query_1_categories){
    if (mysqli_num_rows($query_1_categories) > 0) {
        while ($row_1_categories = mysqli_fetch_assoc($query_1_categories)) {
            $query_5_products = mysqli_query($conn, "SELECT COUNT(*) AS count_products_of_category FROM products WHERE category_id = {$row_1_categories['category_id']}");
            if ($query_5_products) {
                while ($row_5_products = mysqli_fetch_assoc($query_5_products)) {
                    $row_1_categories['count_products'] = $row_5_products['count_products_of_category'];
                }
            }
            $category_arr['status'] =true; 
            $category_arr['data'][] = $row_1_categories;
            $category_arr['num_pages']=$num_pages;
            $category_arr['start_rec']=$start_rec;
            $category_arr['curr_page']=intval($curr_page);
            $category_arr['privious_page']=$privious_page;
            $category_arr['next_page']=$next_page;
            $category_arr['next_page_disable']=$next_page_disable;
            $category_arr['privious_page_disable']=$privious_page_disable;
        }
    }
}else{
    $category_arr['status'] =false; 
}
echo json_encode($category_arr);


?>