<?php
namespace classes;
use classes;
class IWeb{
    private $act;
    private $op;
    private static $instance = null;
    public function  __construct(){
        echo "IGNORE_EXCEPTION";
    }
    /*
     *ʵ����
     *
     * @return obj
     * */
    public static function getInstance(){
        if (self::$instance === null || !(self::$instance instanceof IWeb)){
            self::$instance = new IWeb();
        }
        self::controller();
        return self::$instance;
    }

    /**
     * ����������
     *
     */
    private static function controller(){
/*        //��������
        if ($GLOBALS['setting_config']['enabled_subdomain'] == '1' && $_GET['act'] == 'index' && $_GET['op'] == 'index'){
            $store_id = subdomain();
        if ($store_id > 0) $_GET['act'] = 'show_store';
        }
*/

        $act_file = realpath(BASE_PATH.'/controller/'.$_GET['controller'].'.php');
        $class_name = $_GET['controller'].'Controller';
        if(!@include($act_file)){
            if (C('debug')) {
                throw new Exception("Base Error: access file isn't exists!");
            } else {
                throw new Exception('��Ǹ�������ʵ�ҳ�治����','','html','error');
            }
        }
        if (class_exists($class_name)){
            $main = new $class_name();
            $function = $_GET['op'].'Op';
            if (method_exists($main,$function)){
                $main->$function();
            }elseif (method_exists($main,'indexOp')){
                $main->indexOp();
            }else{
                $error = "Base Error: function $function not in $class_name!";
                throw_exception($error);
            }
        }else {
            $error = "Base Error: class $class_name isn't exists!";
            throw new Exception($error);
        }
    }
}
?>