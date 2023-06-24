<?php
include '../../database/config.php';
$search_book=$_GET['search_value'];

$pagesize = 10;
$start_rec =0;

$condition="prod_name LIKE '%$search_book%' OR prod_desc LIKE '%$search_book%' OR prod_quant LIKE '%$search_book%' OR status = '$search_book'";
// calculate number of pages
$books_query=mysqli_query($conn,"SELECT COUNT(*) as books_count FROM products WHERE $condition");
while ($count_books=mysqli_fetch_assoc($books_query)){
    $all_books=$count_books['books_count'];
}

 // calculate number of pages
$num_pages = ceil($all_books/$pagesize);
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
$query_2_products=mysqli_query($conn,"SELECT p.* ,c.category_name FROM products p INNER JOIN category c ON p.category_id=c.category_id WHERE $condition LIMIT $start_rec, $pagesize");

$books_arr = array(); // Initialize the book array     
if($query_2_products){

    if(mysqli_num_rows($query_2_products)>0){
                                                 
        while($row_2_products=mysqli_fetch_assoc($query_2_products)){
            $books_arr['status'] =true; 
            $books_arr['data'][] = $row_2_products;
            $books_arr['num_pages']=$num_pages;
            $books_arr['start_rec']=$start_rec;
            $books_arr['curr_page']=intval($curr_page);
            $books_arr['privious_page']=$privious_page;
            $books_arr['next_page']=$next_page;
            $books_arr['next_page_disable']=$next_page_disable;
            $books_arr['privious_page_disable']=$privious_page_disable;
        }
    }
}else{
    $books_arr['status'] =false; 
}
echo json_encode($books_arr);

?>