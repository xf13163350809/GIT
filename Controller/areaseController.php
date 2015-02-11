<?php
namespace controller;
use classes\Pdo;
use classes\Response;
use classes\Controller;
class areaseController{
    function show_area(){

        $where='';

        if($_GET['parent_id']!==''){

            $where.=" where parent_id =".$_GET['parent_id'];

        }

        $sql="select area_id,parent_id,area_name,sort from jh51_areas ".$where;
       // $sql="insert into jh51_user values('','username','password','email','phone','head_ico','email_status','email_token','email_token_time','phone_status')";
        $resert=Model()->query($sql);
        var_dump($resert);
        //IMysql::getInstance()->query();

    }
}
?>