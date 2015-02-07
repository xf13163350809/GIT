<?php

/*require(str_replace('\\','/',dirname(__FILE__).'/classes/IWeb.php'));*/
use classes\Db\Pdo;

require(str_replace('\\','/',dirname(__FILE__).'/classes/Base.php'));
require(str_replace('\\','/',dirname(__FILE__).'/classes/Db/pdo.php'));
$config=require(str_replace('\\','/',dirname(__FILE__).'/config.php'));

$rester=Pdo::getInstance()->connect();
var_dump($rester);
/*$pdo = new PDO("mysql:host=127.0.0.1;dbname=juhui","root","root");
$resert=$pdo->query('select * from jh51_user where id="8"');
var_dump($resert);*/

?>