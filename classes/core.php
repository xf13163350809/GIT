<?php
/**
 * ���Ĺ�������
 */

set_include_path('classes' . PATH_SEPARATOR . get_include_path());
spl_autoload_register();
/**
 * �׳��쳣
 *
 * @param string $error �쳣��Ϣ
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
 * ȡ��ϵͳ������Ϣ(����)
 *
 * @param string $key ȡ���±�ֵ
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
 * ʵ����
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
 * �����Ϣ
 *
 * @param string $msg �����Ϣ
 * @param string/array $url ��ת��ַ ��$urlΪ����ʱ���ṹΪ array('msg'=>'��ת��������','url'=>'��ת����');
 * @param string $show_type �����ʽ Ĭ��Ϊhtml
 * @param string $msg_type ��Ϣ���� succ Ϊ�ɹ���errorΪʧ��/����
 * @param string $is_show  �Ƿ���ʾ��ת���ӣ�Ĭ����Ϊ1����ʾ
 * @param int $time ��תʱ�䣬Ĭ��Ϊ2��
 * @return string �ַ������͵ķ��ؽ��
 */


/**
 * ȡ��һ����Դ��ַ
 *
 * @param
 * @return string �ַ������͵ķ��ؽ��
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
           throw_exception('Ŀǰ��֧��post��get����');
    }
}
?>