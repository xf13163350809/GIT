<?php
namespace controller;
use classes\Pdo;
use classes\Response;
use classes;

class baseController{
    public function index(){
        echo "222222";
    }
    public function aa(){
        $rester=Pdo::getInstance()->query('select * from jh51_user where id="8"','');
        echo Response::json('200','',$rester);
    }
}
?>