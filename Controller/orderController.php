<?php
/**
 * Created by PhpStorm.
 * User: xufeng
 * Date: 15-2-13
 * Time: 上午1:09
 */

namespace controller;
use classes\Controller;
use classes\Response;
use classes\IFilter;

class orderController extends Controller{

/*
 *订单列表
 * @value status  1:未支付 2：已付款  3：完成订单
 * */
    public function orderList(){

        $status=IFilter::act(I('status'),'int'); //1:未支付 2：已付款  3：完成订单

        $userid=IFilter::act(I('userid'),'int');

        $data=array(1,2,3);

        if($status&&$userid){

            if(!in_array($status,$data)){

                return Response::json('202','参数有误');

            }
            $Order=new \Order();

            $result=$Order->orderList($status,$userid);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('201','操作失败');
        }
        return Response::json('201','参数不能为空');
    }

/*
 *订单中立即支付
 * */

    public function orderPay(){

        $orderId=IFilter::act(I('orderId'),'int');

        $userid=IFilter::act(I('userid'),'int');

    }



}