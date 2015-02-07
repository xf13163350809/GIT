<?php

/**
 * @class IMysql
 * @brief MYSQL���ݿ�Ӧ��
 */
namespace classes\Db;

/**
 * MYSQL���ݿ�����
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
     * ʵ����
     * */
    public static function getInstance(){
        if (self::$instance === null || !(self::$instance instanceof IMysql)){
            self::$instance = new IMysql();
        }
        return self::$instance;
    }
    /**
     * @brief ���ݿ�����
     * @return bool or resource ֵ: false:����ʧ��; resource����:���ӵ���Դ���;
     */
    protected function connect()
    {
        $db_config=$GLOBALS['config']['DB'];
        if($db_config['DB_TYPE']!=='mysql'){
            return "��ʹ��mysql���ӷ�ʽ";
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
     * �ͷŲ�ѯ��Դ
     * @access public
     */
    public static function free() {
        mysql_free_result(self::$queryID);
        self::$queryID = null;
    }

    /**
     * ִ�в�ѯ �������ݼ�
     * @access public
     * @param string $str  sqlָ��
     * @return mixed
     */
   public function query($str) {

        if ( !self::$linkRes ) return false;

        self::$queryStr=$str;

        //�ͷ�ǰ�εĲ�ѯ���
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
     * ���ݿ������Ϣ
     * ����ʾ��ǰ��SQL���
     * @access public
     * @return string
     */
    protected function error(){

        self::$error = mysql_errno().':'.mysql_error(self::$linkRes);

        if('' !=self::$queryStr){
            self::$error .= "\n [ SQL��� ] : ".self::$queryStr;
        }

        return self::$error;
    }


    /**
     * ������еĲ�ѯ����
     * @access private
     * @return array
     */
    protected static function getAll(){
        //�������ݼ�
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