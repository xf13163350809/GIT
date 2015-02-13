<?php
/**
 * ��Ա
 * User: xufeng
 * Date: 15-2-12
 * Time: ����7:46
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

            return Response::json('505','��½ʧ��');
        }
        return Response::json('201','��������Ϊ��');
    }
/*
 * �û�ע��-�ֻ�ע��
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

                    return Response::json('506','��֤�벻��ȷ');
                }

                if(!preg_match("/^1[3458][0-9]{9}$/",$username)){

                    return Response::json('201','�ֻ���ʽ����ȷ');
                }
            }else{
                if(!preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/",$username)){

                    return Response::json('201','�����ʽ����ȷ');
                }
            }

            $Member=new \Member();

            $result=$Member->register($username,$password,$type);

            if($result){

                return Response::json('200','',$result);
            }
            if($result==0){

                return Response::json('204','���û����ѱ�ע��');
            }

            return Response::json('201','����ʧ��');
        }

        return Response::json('201','��������Ϊ��');
    }

/*
 *�ֻ�ע����֤��
 * */
    public function registerCode(){

        $phoneNum=substr(IFilter::act(I('phone')),0,11);

        self::setCode($phoneNum,1);

    }

/*
 *ͨ���ֻ������һ�����
 *
 * */

    public function forgetPWDByPhone(){

        $phoneNum=substr(IFilter::act(I('phone')),0,11);

        $password=IFilter::act(I('password'));

        $code=IFilter::act(I('code'));

        if($phoneNum&&$password&&$code){

            $File=new File();

            if($code!==$File->cacheData($phoneNum.'code')){

                return Response::json('506','��֤�����');
            }

            $Member=new \Member();

            $result=$Member->forgetPWD($phoneNum,$password);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('201','����ʧ��');

        }
        return Response::json('201','��������Ϊ��');


    }
/*
 *�ֻ��һ����뷢����֤��
 * */
    public function forgetPWDCode(){

        $phoneNum=substr(IFilter::act(I('phone')),0,11);

        self::setCode($phoneNum,2);

    }

}