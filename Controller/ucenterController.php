<?php
/**
 * 用户中心
 * User: xufeng
 * Date: 15-2-13
 * Time: 上午11:50
 */
namespace controller;
use classes\Controller;
use classes\IModel;
use classes\Response;
use classes\IFilter;

class ucenterController extends Controller{

/*
 * 我的消息
 * */
    public function message(){

        $userid=IFilter::act(I('userid'),'int');

        $page=IFilter::act(I('page'),'int');

        if($userid){

            $Ucenter=new \Ucenter();

            $result=$Ucenter->message($userid,$page);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('201','操作失败或无信息');

        }
        return Response::json('201','参数不能为空');
    }


/*
 *查看消息
 * @value id  id拼接字符串 1,2,3
 * return true or false
 * */

    public function lookMessge(){

        $id=IFilter::act(I('id'));

        $userid=IFilter::act(I('userid'));

        if($id){

            $data='';
            if(strpos($id,',')){

                $data=implode(',',$id);

            }else{
                $data=$id;
            }

            $Ucenter=new \Ucenter();

            $result=$Ucenter->lookMessge($data,$userid);

            if($result[0]){

                return Response::json('200','',$result);
            }

            return Response::json('201','消息id为'.$result[1].'状态更新失败');
        }

        return Response::json('201','参数不能为空');
    }

/*
 * 我的收货地址
 *
 * */
    public function address(){

        $userid=IFilter::act(I('userid'));

        if(isset($userid)){

            $page=IFilter::act(I('page'));

            $Ucenter=new \Ucenter();

            $result=$Ucenter->address($userid,$page);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('201','操作失败');

        }
        return Response::json('201','参数不能为空');
    }

/*
 * 添加收货地址
 *
 * @value userid 用户id
 * @value name 用户名
 * @value mobile 手机
 * @value zip 邮编
 * @value telphone 座机
 * @value province  省id
 * @value city  市id
 * @value area  地区id
 * @value address  详细地址
 * @value default  是否设为默认
 * */
    public function addaddress(){

        $userid=IFilter::act(I('userid'),'int');
        $name=IFilter::act(I('name'));
        $mobile=IFilter::act(I('mobile'));
        $zip=IFilter::act(I('zip'));
        $telphone=IFilter::act(I('telphone')); //座机

        $province=IFilter::act(I('province'));
        $city=IFilter::act(I('city'));
        $area=IFilter::act(I('area'));
        $address=IFilter::act(I('address'));
        $default=IFilter::act(I('default'));

        if($userid&&$name&&$mobile&&$province&&$city&&$area&&$address){

            $Ucenter=new \Ucenter();

            $result=$Ucenter->addaddress($userid,$name,$mobile,$zip,$telphone,$province,$city,$area,$address,$default);

            if($result){

                if($result==503){

                    return Response::json('503','数据已存在');
                }

                return Response::json('200','',$result);
            }

            return Response::json('201','操作失败');
        }

        return Response::json('201','参数不能为空');
    }

/*
 *个人资料
 * */
    public function getUserById(){

        $userid=IFilter::act(I('userid'),'int');

        if($userid){

             $Ucenter=new \Ucenter();

            $result=$Ucenter->getUserById($userid);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('201','操作失败');
        }

        return Response::json('201','参数不能为空');
    }

/*
 *修改个人资料
 *
 * @value userid 用户id
 * @value sex 性别（0：女 1：男）
 * @value head_ico 图像
 * @value age 年龄
 * @value address 所在地
 * */
    public function reviseUserInfo(){

            $userid=IFilter::act(I('userid'),'int');
        $head_ico=IFilter::act(I('head_ico'));
        $age=IFilter::act(I('age'),'int');
        $sex=IFilter::act(I('sex'),'int');
        $address=IFilter::act(I('address'));

        if($userid){

            $data=array();  //组建更新信息数据
            if($head_ico){

                $data['head_ico']=$head_ico;
            }
            if($age){

                $data['age']=$age;
            }

            if($sex){

                $data['sex']=$sex;
            }
            if($address){

                $data['address']=$address;
            }

            $Ucenter=new \Ucenter();

            $result=$Ucenter->reviseUserInfo($userid,$data);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('201','操作失败');

        }
        return Response::json('201','参数不能为空');
    }
}