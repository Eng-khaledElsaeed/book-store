<?php
class Pagination
{
    public $cur_page;
    public $total;
    public $per_page;

    function __construct($cur_page, $total, $per_page)
    {
        $this->cur_page = $cur_page;
        $this->total = $total;
        $this->per_page = $per_page;
    }

    function getTotalPage(){
        return ceil($this->total / $this->per_page);
    }

    function hasPrevPage(){
        if($this->cur_page > 1){
            return true;
        }
        else{
            return false;
        }
    }

    function hasNextPage(){
        if($this->cur_page < $this->getTotalPage()){
            return true;
        }
        else{
            return false;
        }
    }

    function offSet(){
        return ($this->cur_page - 1) * $this->per_page;
    }
}
?>