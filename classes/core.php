<?php
/**
 * ���Ĺ�������
 */

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

?>