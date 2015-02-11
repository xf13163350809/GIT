<?php
namespace classes;
use classes;
use classes\File;
class Pdo {

    private static $instance = null;
    private static $linkRes = false;
    private static $queryID;
    private static $queryStr;
    public static  $error;
    public static  $__queries;


    protected $PDOStatement = null;
    private   $table        = '';
    private  $numRows;

    /**
     * �ܹ����� ��ȡ���ݿ�������Ϣ
     * @access public
     * @param array $config ���ݿ���������
     */
    public function __construct(){
        if(self::$linkRes===false){
            self::connect();
        }
    }

    /*
     * ʵ����
     * */
    public static function getInstance(){

        if (self::$instance === null || !(self::$instance instanceof Pdo)){

            self::$instance = new Pdo();

        }
        return self::$instance;
    }

    /**
     * �������ݿⷽ��
     * @access public
     */
    public function connect() {

        $db_config=$GLOBALS['config']['DB'];

        if($db_config['DB_TYPE']=='pdo'){



            if(version_compare(PHP_VERSION,'5.3.6','<=')){

                $config['params'][\PDO::ATTR_EMULATE_PREPARES]  =   false;

            }

            try{

               $dsn="mysql:host=".$db_config['DB_HOST'].";dbname=".$db_config['DB_NAME'];

                self::$linkRes =new \PDO($dsn,$db_config['DB_USER'],$db_config['DB_PWD']);

            }catch (\Exception $e){

                $err='Connection failed: ' . $e->getMessage();

                throw_exception($err);

            }

            if($db_config['DB_charset']===''){

                $db_config['DB_charset']='utf8';

            }

            self::$linkRes->exec('set names '.$db_config['DB_charset']);
        }

    }

    /**
     * �ͷŲ�ѯ���
     * @access public
     */
    private function free() {
        self::$queryID = '';
    }

    /**
     * execute
     * @access public
     * @param string $str  sqlָ��
     * @param array $bind ������
     * @return mixed
     */
    public function query($sql,$params=null) {

       try {

            $stmt=self::$linkRes->prepare($sql);

            if($params!==null) {

                if(is_array($params) || is_object($params)) {

                    $i=1;

                    foreach($params as $param) {

                        $stmt->bindValue($i++,$param);
                    }
                } else {
                    $stmt->bindValue(1,$params);
                }
            }

            if($stmt->execute()) {

                self::$__queries++;

                return $result_arr = $stmt->fetchAll();

            } else {
                $err='sql failed: ' .$sql;
                throw_exception($err);
            }
        } catch(\Exception $e) {
            throw_exception($e);
        }
    }

    /**
     * ִ�����
     * @access public
     * @param string $str  sqlָ��
     * @param array $bind ������
     * @return integer
     */
    public function execute($str,$bind=array()) {

        if ( !self::$linkRes ) return false;

        self::$queryStr = $str;

        if(!empty($bind)){
            self::$queryStr .=   '[ '.print_r($bind,true).' ]';
        }
        //�ͷ�ǰ�εĲ�ѯ���
        if ( !empty($this->PDOStatement) ) $this->free();

        $this->PDOStatement = self::$linkRes->prepare($str);
        if(false === $this->PDOStatement) {
            throw_exception($this->error());
        }
        // ������
        $this->bindPdoParam($bind);
        $result = $this->PDOStatement->execute();
        if ( false === $result) {
            $this->error();
            return false;
        } else {
            $this->numRows = $this->PDOStatement->rowCount();
            if( preg_match("/^\s*(INSERT\s+INTO|REPLACE\s+INTO)\s+/i", $str)) {
                $this->lastInsID = $this->getLastInsertId();
            }
            return $this->numRows;
        }
    }

    /**
     * ������
     * @access protected
     * @return void
     */
    protected function bindPdoParam($bind){
        // ������
        foreach($bind as $key=>$val){
            if(is_array($val)){
                array_unshift($val,$key);
            }else{
                $val  = array($key,$val);
            }
            call_user_func_array(array($this->PDOStatement,'bindValue'),$val);
        }
    }

    /**
     * ��������
     * @access public
     * @return void
     */
    public function startTrans() {
        $this->initConnect(true);
        if ( !$this->_linkID ) return false;
        //����rollback ֧��
        if ($this->transTimes == 0) {
            $this->_linkID->beginTransaction();
        }
        $this->transTimes++;
        return ;
    }

    /**
     * ���ڷ��Զ��ύ״̬����Ĳ�ѯ�ύ
     * @access public
     * @return boolen
     */
    public function commit() {
        if ($this->transTimes > 0) {
            $result = $this->_linkID->commit();
            $this->transTimes = 0;
            if(!$result){
                $this->error();
                return false;
            }
        }
        return true;
    }

    /**
     * ����ع�
     * @access public
     * @return boolen
     */
    public function rollback() {
        if ($this->transTimes > 0) {
            $result = $this->_linkID->rollback();
            $this->transTimes = 0;
            if(!$result){
                $this->error();
                return false;
            }
        }
        return true;
    }

    /**
     * ������еĲ�ѯ����
     * @access private
     * @return array
     */
    private function getAll() {
        //�������ݼ�
        $result =   $this->PDOStatement->fetchAll(\PDO::FETCH_ASSOC);
        $this->numRows = count( $result );
        return $result;
    }

    /**
     * ȡ�����ݱ���ֶ���Ϣ
     * @access public
     */
    public function getFields($tableName) {
        if(C('DB_DESCRIBE_TABLE_SQL')) {
            // ����������ֶβ�ѯSQL
            $sql   = str_replace('%table%',$tableName,C('DB_DESCRIBE_TABLE_SQL'));
        }else{
            switch($this->dbType) {
                case 'MSSQL':
                case 'SQLSRV':
                    $sql   = "SELECT   column_name as 'Name',   data_type as 'Type',   column_default as 'Default',   is_nullable as 'Null'
        FROM    information_schema.tables AS t
        JOIN    information_schema.columns AS c
        ON  t.table_catalog = c.table_catalog
        AND t.table_schema  = c.table_schema
        AND t.table_name    = c.table_name
        WHERE   t.table_name = '$tableName'";
                    break;
                case 'SQLITE':
                    $sql   = 'PRAGMA table_info ('.$tableName.') ';
                    break;
                case 'ORACLE':
                case 'OCI':
                    $sql   = "SELECT a.column_name \"Name\",data_type \"Type\",decode(nullable,'Y',0,1) notnull,data_default \"Default\",decode(a.column_name,b.column_name,1,0) \"pk\" "
                        ."FROM user_tab_columns a,(SELECT column_name FROM user_constraints c,user_cons_columns col "
                        ."WHERE c.constraint_name=col.constraint_name AND c.constraint_type='P' and c.table_name='".strtoupper($tableName)
                        ."') b where table_name='".strtoupper($tableName)."' and a.column_name=b.column_name(+)";
                    break;
                case 'PGSQL':
                    $sql   = 'select fields_name as "Name",fields_type as "Type",fields_not_null as "Null",fields_key_name as "Key",fields_default as "Default",fields_default as "Extra" from table_msg('.$tableName.');';
                    break;
                case 'IBASE':
                    break;
                case 'MYSQL':
                default:
                    $sql   = 'DESCRIBE '.$tableName;//��ע: �����಻ֻ���mysql�����ܼ�``
            }
        }
        $result = self::$linkRes->query($sql);
        $info   =   array();
        if($result) {
            foreach ($result as $key => $val) {
                $val            =   array_change_key_case($val);
                $val['name']    =   isset($val['name'])?$val['name']:"";
                $val['type']    =   isset($val['type'])?$val['type']:"";
                $name           =   isset($val['field'])?$val['field']:$val['name'];
                $info[$name]    =   array(
                    'name'    => $name ,
                    'type'    => $val['type'],
                    'notnull' => (bool)(((isset($val['null'])) && ($val['null'] === '')) || ((isset($val['notnull'])) && ($val['notnull'] === ''))), // not null is empty, null is yes
                    'default' => isset($val['default'])? $val['default'] :(isset($val['dflt_value'])?$val['dflt_value']:""),
                    'primary' => isset($val['key'])?strtolower($val['key']) == 'pri':(isset($val['pk'])?$val['pk']:false),
                    'autoinc' => isset($val['extra'])?strtolower($val['extra']) == 'auto_increment':(isset($val['key'])?$val['key']:false),
                );
            }
        }
        return $info;
    }

    /**
     * ȡ�����ݿ�ı���Ϣ
     * @access public
     */
    public function getTables($dbName='') {
        if(C('DB_FETCH_TABLES_SQL')) {
            // ��������ı��ѯSQL
            $sql   = str_replace('%db%',$dbName,C('DB_FETCH_TABLES_SQL'));
        }else{
            switch($this->dbType) {
                case 'ORACLE':
                case 'OCI':
                    $sql   = 'SELECT table_name FROM user_tables';
                    break;
                case 'MSSQL':
                case 'SQLSRV':
                    $sql   = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE'";
                    break;
                case 'PGSQL':
                    $sql   = "select tablename as Tables_in_test from pg_tables where  schemaname ='public'";
                    break;
                case 'IBASE':
                    // ��ʱ��֧��
                    E(L('_NOT_SUPPORT_DB_').':IBASE');
                    break;
                case 'SQLITE':
                    $sql   = "SELECT name FROM sqlite_master WHERE type='table' "
                        . "UNION ALL SELECT name FROM sqlite_temp_master "
                        . "WHERE type='table' ORDER BY name";
                    break;
                case 'MYSQL':
                default:
                    if(!empty($dbName)) {
                        $sql    = 'SHOW TABLES FROM '.$dbName;
                    }else{
                        $sql    = 'SHOW TABLES ';
                    }
            }
        }
        $result = $this->query($sql);
        $info   =   array();
        foreach ($result as $key => $val) {
            $info[$key] = current($val);
        }
        return $info;
    }

    /**
     * limit����
     * @access protected
     * @param mixed $lmit
     * @return string
     */
    protected function parseLimit($limit) {
        $limitStr    = '';
        if(!empty($limit)) {
            switch($this->dbType){
                case 'PGSQL':
                case 'SQLITE':
                    $limit  =   explode(',',$limit);
                    if(count($limit)>1) {
                        $limitStr .= ' LIMIT '.$limit[1].' OFFSET '.$limit[0].' ';
                    }else{
                        $limitStr .= ' LIMIT '.$limit[0].' ';
                    }
                    break;
                case 'MSSQL':
                case 'SQLSRV':
                    break;
                case 'IBASE':
                    // ��ʱ��֧��
                    break;
                case 'ORACLE':
                case 'OCI':
                    break;
                case 'MYSQL':
                default:
                    $limitStr .= ' LIMIT '.$limit.' ';
            }
        }
        return $limitStr;
    }

    /**
     * �ֶκͱ�������
     * @access protected
     * @param string $key
     * @return string
     */
    protected function parseKey(&$key) {
        if(!is_numeric($key) && $this->dbType=='MYSQL'){
            $key   =  trim($key);
            if(!preg_match('/[,\'\"\*\(\)`.\s]/',$key)) {
                $key = '`'.$key.'`';
            }
            return $key;
        }else{
            return parent::parseKey($key);
        }

    }

    /**
     * �ر����ݿ�
     * @access public
     */
    public function close() {
        self::$linkRes = false;
    }

    /**
     * ���ݿ������Ϣ
     * ����ʾ��ǰ��SQL���
     * @access public
     * @return string
     */
    public function error() {
        if($this->PDOStatement) {
            $error = $this->PDOStatement->errorInfo();
            $this->error = $error[1].':'.$error[2];
        }else{
            $this->error = '';
        }
        if('' != $this->queryStr){
            $this->error .= "\n [ SQL��� ] : ".$this->queryStr;
        }
        return $this->error;
    }

    /**
     * SQLָ�ȫ����
     * @access public
     * @param string $str  SQLָ��
     * @return string
     */
    public function escapeString($str) {
        switch($this->dbType) {
            case 'MSSQL':
            case 'SQLSRV':
            case 'MYSQL':
                return addslashes($str);
            case 'PGSQL':
            case 'IBASE':
            case 'SQLITE':
            case 'ORACLE':
            case 'OCI':
                return str_ireplace("'", "''", $str);
        }
    }

    /**
     * value����
     * @access protected
     * @param mixed $value
     * @return string
     */
    protected function parseValue($value) {
        if(is_string($value)) {
            $value =  strpos($value,':') === 0 ? $this->escapeString($value) : '\''.$this->escapeString($value).'\'';
        }elseif(isset($value[0]) && is_string($value[0]) && strtolower($value[0]) == 'exp'){
            $value =  $this->escapeString($value[1]);
        }elseif(is_array($value)) {
            $value =  array_map(array($this, 'parseValue'),$value);
        }elseif(is_bool($value)){
            $value =  $value ? '1' : '0';
        }elseif(is_null($value)){
            $value =  'null';
        }
        return $value;
    }

    /**
     * ��ȡ������id
     * @access public
     * @return integer
     */
    public function getLastInsertId() {
        switch($this->dbType) {
            case 'PGSQL':
            case 'SQLITE':
            case 'MSSQL':
            case 'SQLSRV':
            case 'IBASE':
            case 'MYSQL':
                return $this->_linkID->lastInsertId();
            case 'ORACLE':
            case 'OCI':
                $sequenceName = $this->table;
                $vo = $this->query("SELECT {$sequenceName}.currval currval FROM dual");
                return $vo?$vo[0]["currval"]:0;
        }
    }
}