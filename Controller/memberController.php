<?php
/**
 * 会员
 * User: xufeng
 * Date: 15-2-12
 * Time: 下午7:46
 */

namespace controller;
use classes\File;
use classes\IModel;
use classes\Response;
use classes\IFilter;
use classes\IQuery;
use classes\Controller;
use classes\sms;

class memberController extends Controller{

    public function __autoload(){

    }

    public function login(){

        $username=IFilter::act(I('username'));

        $password=IFilter::act(I('password'));

        if($username&&$password){

            $Member=new \Member();

            $result=$Member->login($username,$password);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('505','登陆失败');
        }
        return Response::json('201','参数不能为空');
    }
/*
 * 用户注册-手机注册
 * */
    public function register(){

        $phone=substr(IFilter::act(I('phone')),0,11);

        $Email=IFilter::act(I('Email'));

        $password=IFilter::act(I('password'));

        $username=$phone?$phone:$Email;

        $type=$phone?1:0;

        if($username&&$password){

            if($type){
                    $code=IFilter::act(I('code'));
                $File=new File();

                if($code!==$File->cacheData($phone.'code')){

                    return Response::json('506','验证码不正确');
                }

                if(!preg_match("/^1[3458][0-9]{9}$/",$username)){

                    return Response::json('201','手机格式不正确');
                }
            }else{
                if(!preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/",$username)){

                    return Response::json('201','邮箱格式不正确');
                }
            }

            $Member=new \Member();

            $result=$Member->register($username,$password,$type);

            if($result){

                return Response::json('200','',$result);
            }
            if($result==0){

                return Response::json('204','该用户名已被注册');
            }

            return Response::json('201','操作失败');
        }

        return Response::json('201','参数不能为空');
    }

/*
 *手机注册验证码
 * */
    public function registerCode(){

        $phoneNum=substr(IFilter::act(I('phone')),0,11);

        self::setCode($phoneNum,1);

    }

/*
 *通过手机号码找回密码
 *
 * */

    public function forgetPWDByPhone(){

        $phoneNum=substr(IFilter::act(I('phone')),0,11);

        $password=IFilter::act(I('password'));

        $code=IFilter::act(I('code'));

        if($phoneNum&&$password&&$code){

            $File=new File();

            if($code!==$File->cacheData($phoneNum.'code')){

                return Response::json('506','验证码错误');
            }

            $Member=new \Member();

            $result=$Member->forgetPWD($phoneNum,$password);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('201','操作失败');

        }
        return Response::json('201','参数不能为空');


    }
/*
 *手机找回密码发送验证码
 * */
    public function forgetPWDCode(){

        $phoneNum=substr(IFilter::act(I('phone')),0,11);

        self::setCode($phoneNum,2);

    }

}