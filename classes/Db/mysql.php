<?php

/**
 * @class IMysql
 * @brief MYSQL数据库应用
 */
namespace classes\Db;

/**
 * MYSQL数据库驱动
 */

class IMysql
{
    private static $instance = null;
    private static $linkRes = false;
    private static $queryID;
    private static $queryStr;
    private static $numRows;
    public static  $error;

    protected function __construct(){
        if(self::$linkRes===false){
            self::connect();
        }
    }
    /*
     * 实例化
     * */
    public static function getInstance(){
        if (self::$instance === null || !(self::$instance instanceof IMysql)){
            self::$instance = new IMysql();
        }
        return self::$instance;
    }
    /**
     * @brief 数据库连接
     * @return bool or resource 值: false:链接失败; resource类型:链接的资源句柄;
     */
    protected function connect()
    {
        $db_config=$GLOBALS['config']['DB'];
        if($db_config['DB_TYPE']!=='mysql'){
            return "请使用mysql连接方式";
        }
        self::$linkRes = mysql_connect($db_config['DB_HOST'],$db_config['DB_USER'],$db_config['DB_PWD']);
        if(is_resource(self::$linkRes))
        {
            mysql_select_db($db_config['DB_NAME'],self::$linkRes);
            $DBCharset = isset($db_config['DB_charset'])?$db_config['DB_charset'] : 'utf8';
            mysql_query("SET NAMES '".$DBCharset."'");
            if(isset($db_config['DB_mode']) && $db_config['DB_mode'] != '')
            {
                mysql_query("SET SESSION sql_mode = '".$db_config['DB_mode']."' ");
            }
            else
            {
                mysql_query("SET SESSION sql_mode = '' ");
            }
        }
        else
        {
            return false;
        }
    }

    /**
     * 释放查询资源
     * @access public
     */
    public static function free() {
        mysql_free_result(self::$queryID);
        self::$queryID = null;
    }

    /**
     * 执行查询 返回数据集
     * @access public
     * @param string $str  sql指令
     * @return mixed
     */
   public function query($str) {

        if ( !self::$linkRes ) return false;

        self::$queryStr=$str;

        //释放前次的查询结果
        if ( self::$queryID ) {self::free();}
        self::$queryID = mysql_query($str, self::$linkRes);

        if ( false === self::$queryID){
            return  self::error();
        } else {
            self::$numRows = mysql_num_rows(self::$queryID);
            return self::getAll();
        }
    }

    /**
     * 数据库错误信息
     * 并显示当前的SQL语句
     * @access public
     * @return string
     */
    protected function error(){

        self::$error = mysql_errno().':'.mysql_error(self::$linkRes);

        if('' !=self::$queryStr){
            self::$error .= "\n [ SQL语句 ] : ".self::$queryStr;
        }

        return self::$error;
    }


    /**
     * 获得所有的查询数据
     * @access private
     * @return array
     */
    protected static function getAll(){
        //返回数据集
        $result = array();
        if(self::$numRows >0) {
            while($row = mysql_fetch_assoc(self::$queryID)){
                $result[]   =   $row;
            }
            mysql_data_seek(self::$queryID,0);
        }
        return $result;
    }




}
?>