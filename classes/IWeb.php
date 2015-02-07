<?php
namespace classes;
use controller\baseController;
class IWeb{
    private static $Controller;
    private static $Action;
    private static $instance = null;
    public function  __construct(){
    }
    /*
     *实例化
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
     * 控制器调度
     *
     */
    private static function controller(){


        if(!C("URL_SIZE_DISTINGUISH")){

            self::$Controller=@$_GET['controller'];

            self::$Action=@$_GET['action'];

            if(empty(self::$Controller)){

                self::$Controller=@$_GET['Controller'];

            }

            if(empty(self::$Action)){

                self::$Action=@$_GET['Action'];

            }

        }else{

            self::$Controller=@$_GET['Controller'];

            self::$Controller=@$_GET['Action'];

        }

        $act_file = BASE_PATH.'/'.C('CONTROLLER_NAME').'/'.self::$Controller.'Controller.php';

        $class_name =  '\Controller\\'.self::$Controller.'Controller';

        if(!@include($act_file)){

            $error = "Base Error: Controller isn't exists!";

            throw_exception($error);

        }
        if (class_exists($class_name)){

            $main = new $class_name();

            $function = self::$Action;

            if (method_exists($main,$function)){

                $main->$function();

            }elseif (method_exists($main,'index')){

                $main->index();

            }else{

                $error = "Base Error: function $function not in $class_name!";

                throw_exception($error);

            }
        }else {

            $error = "Base Error: class $class_name isn't exists!";

            throw_exception($error);
        }
    }
}
?>