<?php

/*require(str_replace('\\','/',dirname(__FILE__).'/classes/IWeb.php'));*/

use classes\IWeb;
use classes\Pdo;


if(!@include(str_replace('\\','/',dirname(__FILE__).'/classes/base.php'))) exit('base.php isn\'t exists!');
if(!@include(str_replace('\\','/',dirname(__FILE__).'/classes/IWeb.php'))) exit('IWeb.php isn\'t exists!');
if(!@include(str_replace('\\','/',dirname(__FILE__).'/classes/pdo.php'))) exit('pdo.php isn\'t exists!');
if(!@include(str_replace('\\','/',dirname(__FILE__).'/classes/core.php'))) exit('core.php isn\'t exists!');
if(!@include(str_replace('\\','/',dirname(__FILE__).'/classes/response.php'))) exit('response.php isn\'t exists!');

if(!@include(str_replace('\\','/',dirname(__FILE__).'/classes/global.php'))) exit('global.php isn\'t exists!');
$config=require(str_replace('\\','/',dirname(__FILE__).'/config.php'));
IWeb::getInstance();
/*include('./Controller/baseController.php');
$base=new \Controller\baseController();
var_dump($base->index());*/

/*$resert=Pdo::getInstance()->query('select * from jh51_user where id="8"','');
$result_arr = $resert->fetchAll();
print_r($result_arr);*/
/*$pdo = new PDO("mysql:host=127.0.0.1;dbname=juhui","root","root");
$resert=$pdo->query('select * from jh51_user where id="8"');
var_dump($resert);*/

?>