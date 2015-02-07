<?php
namespace classes;
class Response {
    /*实例化*/

    /*
     * 返回Json格式数据
     * $code 编码
     * $message 提示信息
     * $data  数据(数组)*/
   static public function json($code,$message='',$data=array()){
        if(!is_numeric($code)){
            return '返回编码不能为空';
        }
        $arr=array(
            'code'=>$code,
            'msg'=>iconv('gb2312','utf-8',$message),
            'data'=>$data
        );
        $str=$arr;
        unset($arr);
        return json_encode($str);
    }
}

?>