<?php
namespace classes;
class Response {
    /*ʵ����*/

    /*
     * ����Json��ʽ����
     * $code ����
     * $message ��ʾ��Ϣ
     * $data  ����(����)*/
   static public function json($code,$message='',$data=array()){
        if(!is_numeric($code)){
            return '���ر��벻��Ϊ��';
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