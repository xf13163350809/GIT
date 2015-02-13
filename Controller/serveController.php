<?php
/**
 *便民服务
 * User: xufeng
 * Date: 15-2-12
 * Time: 上午10:05
 */

namespace controller;
use classes\Controller;
use classes\Response;
use classes\IFilter;
use Shop;

class serveController extends Controller{

/*
 * 通过产品id检索店铺信息
 * @value $porId 产品id
 * return
 * */
    /*public function index(){

        if($channel=IFilter::act(I('channel'))&&IFilter::act(I('channel'))=='serve'){

            $banner_arr=array(
                'img'=>
                array(
                    'img'=>'',
                    'url'=>''
                ),
                array(
                    'img'=>'',
                    'url'=>''
                ),
            );
            return Response::json('200','',$banner_arr);
        }

        return Response::json('201','参数不能为空');
    }*/
/*
 *
 *
 * */
    public function proListByClassId(){

        $page=IFilter::act(I('page'),'int');

        if($classId=IFilter::act(I('classId'))&&IFilter::act(I('channel'))=='serve'&&$position=IFilter::act(I('position'))){

            $Server=new \Server();

            $result=$Server->proListByClassId($classId,$page,$position);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','查询失败');

        }
        return Response::json('201','参数不能为空');
    }

/*
 * 通过店铺id获得店铺信息
 * @value shopid获取店铺信息以及前十条评论
 * @value $position获取到店铺距离
 * @value $channel 验证频道
 * */
    public function shopInfo(){

        $shopId=IFilter::act(I('shopId'),'int');

        $position=IFilter::act(I('position'));

        if($shopId&&IFilter::act(I('channel'))=='serve'&&$position){

            $Server=new \Server();

            $result=$Server->shopInfo($shopId,$position);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','查询失败');

        }
        return Response::json('201','参数不能为空');


    }


/*
 * 通过店铺id获得评价
 * @value shopid 获取店铺id
 * @value $channel 验证频道
 * */
    public function shopEval(){

        $shopId=IFilter::act(I('shopId'),'int');

        $page=IFilter::act(I('page'),'int');

        if(IFilter::act(I('channel'))=='serve'&&$shopId){

            $Server=new \Server();

            $result=$Server->shopEval($shopId,$page);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','查询失败');
        }
        return Response::json('201','参数不能为空');
    }

/*
 * 店铺好评与差评
 * @value  shopId  店铺id
 * @value  userid  用户id
 * @value  dot   1:好评  2：差评
 * */
    public function shopForDot(){

        $data=array(1,2);  //评价参数限制

        $shopId=IFilter::act(I('shopId'),'int');

        $dot=IFilter::act(I('dot'),'int');

        $userid=IFilter::act(I('userid'),'int');

        if(IFilter::act(I('channel'))=='serve'&&$shopId&&$dot&&$userid){

            if(in_array($dot,$data)){

                $Server=new \Server();

                $result=$Server->shopForDot($shopId,$dot,$userid);

                if($result){

                    return Response::json('200','',$result);
                }

                if($result===0){

                    return Response::json('503','');  //用户已经操作过
                }

                return Response::json('204','操作失败');
            }

            return Response::json('501','参数值不存在');

        }
        return Response::json('201','参数不能为空');

    }

/*
 * 用户对店铺评价
 *@value  $shopId 店铺id
 *@value  $userid 用户id
 *@value  $message 评价内容
 * return 新增记录id
 * */
    public function shopSetEval(){

        $shopId=IFilter::act(I('shopId'),'int');

        $userid=IFilter::act(I('userid'),'int');

        $message=IFilter::act(I('message'));

        if(IFilter::act(I('channel'))=='serve'&&$shopId&&$userid&&$message){

            $Server=new \Server();

            $result=$Server->shopSetEval($shopId,$userid,$message);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','操作失败');

        }
        return Response::json('201','参数不能为空');
    }


}