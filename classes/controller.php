<?php
namespace classes;
use classes\Pdo;
use classes\Response;
use classes\IFilter;
abstract class Controller{

/*
 *发送验证码
 *
 * */
    public function setCode($phoneNum,$type){



        if(!preg_match("/^1[3458][0-9]{9}$/",$phoneNum)){

            return Response::json('201','手机格式不正确');
        }

        $sms=new sms();

        $result=$sms->SendSMS($phoneNum,$type);

        $file=new File();

        $file->cacheData('XXXXX',$result);

        if(substr($result,0,3)=='000'){

            return Response::json('200','',$file->cacheData($phoneNum.'code'));
        }

        return Response::json('404','服务器错误');

    }
}
?>