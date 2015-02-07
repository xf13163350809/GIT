<?php
namespace controller;
class areaseController extends Controller{
    function show_area($parent_id=''){
        $where=" 1=1 ";
        if($parent_id!==''){
            $where.=" parent_id =".$parent_id;
        }
        $sql="select area_id,parent_id,area_name,sort from jh51_area ".$where;
        echo $sql;
        //IMysql::getInstance()->query();

    }
}
?>