<?php
/**
 * 订餐管理
 * User: xufeng
 * Date: 15-2-12
 * Time: 下午5:16
 */
namespace controller;
use classes\Controller;
use classes\Response;
use classes\IFilter;

class eatController extends Controller{

/*
 * 订餐首页
 * */
    public function index(){

        /*banner图片*/
        $img_arr=array(
            array(
                'img'=>'',
                'url'=>''
            )
        );

        $position=IFilter::act(I('position'));

        if(IFilter::act(I('channel'))=='eat'&&$position){

            $Server=new \Eat();

            //$result=$Server->shopSetEval($shopId,$userid,$message);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','操作失败');

        }
        return Response::json('201','参数不能为空');
    }
/*
 * 通过客户端地址查找最近优惠信息
 *@value $position 客户端位置
 * */
    public function eatList(){

        $position=IFilter::act(I('position'));

        $page=IFilter::act(I('page'));

        if(IFilter::act(I('channel'))=='eat'&&$position&&$page){

            $Eat=new \Eat();

            $result=$Eat->eatList($position,$page);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','操作失败');

        }
    }
}