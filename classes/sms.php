<?php
/**
 * Created by PhpStorm.
 * User: xufeng
 * Date: 14-12-31
 * Time: ����2:15
 */
namespace classes;

class sms {
    function getContent($strMobile,$id=0)
    {
        $pcode =rand(111111, 999999);
        switch($id){
            case 1: $content = "�����ڽ����ֻ���֤��������֤��($pcode),�������κ����ṩ��֤�롣";break;
            case 2: $content = "������ͨ���ֻ��һ����룬��֤��($pcode),�������κ����ṩ��֤�롣";break;
            default: $content = "��֤��($pcode),�������κ����ṩ��֤�롣";break;
        }
        $file=new File();

        $file->cacheData($strMobile.'code',$pcode,60);

        return $content;
    }

     function SendSMS($strMobile,$type){

        $content=$this->getContent($strMobile,$type);

        $url="http://service.winic.org:8009/sys_port/gateway/?id=%s&pwd=%s&to=%s&content=%s&time=";

        $id = urlencode("tyrbl_timely");

        $pwd = urlencode("tyrbl911");

        $to = urlencode($strMobile);

        var_dump($content);

        $content =iconv("UTF-8","gbk",$content); //��utf-8תΪgb2312�ٷ�

        $content = urlencode($content);

        $rurl = sprintf($url, $id, $pwd, $to, $content);//д�������

        $result = file_get_contents($rurl);
        // 	dump($result);
        return $result;
    }

} 