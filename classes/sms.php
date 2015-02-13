<?php
/**
 * Created by PhpStorm.
 * User: xufeng
 * Date: 14-12-31
 * Time: 下午2:15
 */
namespace classes;

class sms {
    function getContent($strMobile,$id=0)
    {
        $pcode =rand(111111, 999999);
        switch($id){
            case 1: $content = "您正在进行手机验证操作，验证码($pcode),请勿向任何人提供验证码。";break;
            case 2: $content = "您正在通过手机找回密码，验证码($pcode),请勿向任何人提供验证码。";break;
            default: $content = "验证码($pcode),请勿向任何人提供验证码。";break;
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

        $content =iconv("UTF-8","gbk",$content); //将utf-8转为gb2312再发

        $content = urlencode($content);

        $rurl = sprintf($url, $id, $pwd, $to, $content);//写入变量中

        $result = file_get_contents($rurl);
        // 	dump($result);
        return $result;
    }

} 