<?php
/**
 * 核心公共方法
 */

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

?>