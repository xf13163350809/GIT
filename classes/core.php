<?php
/**
 * 核心公共方法
 */

set_include_path('classes' . PATH_SEPARATOR . get_include_path());
spl_autoload_register();
/**
 * 抛出异常
 *
 * @param string $error 异常信息
 */
function throw_exception($error){
    if (C('debug.IGNORE_EXCEPTION')){
        echo($error);
        exit();
    }else{
        exit();
    }
}


/**
 * 取得系统配置信息(三级)
 *
 * @param string $key 取得下标值
 * @return mixed
 */
function C($key){

    if(strpos($key,'.')){

        $key=explode('.',$key);

        if(isset($key[2])){

           return$GLOBALS['config'][$key[0]][$key[1]][$key[2]];

        }

           return $GLOBALS['config'][$key[0]][$key[1]];

    }else{

        return $GLOBALS['config'][$key];

    }

}

/**
 * 实例化
 *
 * @return mixed
 */

function getDB() {

    $classname=ucwords($GLOBALS['config']['DB']['DB_TYPE']);

    ini_set('include_path','classes');

    @include_once(BASE_PATH.'/'.strtolower($GLOBALS['config']['DB']['DB_TYPE']).'.php');

    if(class_exists(ucwords($classname))){

       $class='\classes\\'.ucwords($classname);

      return $class::getInstance();

    }else{

        $error='failed : Model Instantiation Failed !';

        throw_exception($error);

    }

}

/**
 * 输出信息
 *
 * @param string $msg 输出信息
 * @param string/array $url 跳转地址 当$url为数组时，结构为 array('msg'=>'跳转连接文字','url'=>'跳转连接');
 * @param string $show_type 输出格式 默认为html
 * @param string $msg_type 信息类型 succ 为成功，error为失败/错误
 * @param string $is_show  是否显示跳转链接，默认是为1，显示
 * @param int $time 跳转时间，默认为2秒
 * @return string 字符串类型的返回结果
 */


/**
 * 取上一步来源地址
 *
 * @param
 * @return string 字符串类型的返回结果
 */
function getReferer(){
    return empty($_SERVER['HTTP_REFERER'])?'':$_SERVER['HTTP_REFERER'];
}


function I($obj){

    $type=strtolower(C('SYSTEM.REQUEST_TYPE'));
    switch($type){

        case 'get' :
            return isset($_GET[$obj])?$_GET[$obj]:'';
        break;

        case 'post':
            return isset($_POST[$obj])?$_POST[$obj]:'';
        break;

        default:
           throw_exception('目前仅支持post或get请求');
    }
}
?>