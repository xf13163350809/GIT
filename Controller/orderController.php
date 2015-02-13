<?php
/**
 * Created by PhpStorm.
 * User: xufeng
 * Date: 15-2-13
 * Time: ����1:09
 */

namespace controller;
use classes\Controller;
use classes\Response;
use classes\IFilter;

class orderController extends Controller{

/*
 *�����б�
 * @value status  1:δ֧�� 2���Ѹ���  3����ɶ���
 * */
    public function orderList(){

        $status=IFilter::act(I('status'),'int'); //1:δ֧�� 2���Ѹ���  3����ɶ���

        $userid=IFilter::act(I('userid'),'int');

        $data=array(1,2,3);

        if($status&&$userid){

            if(!in_array($status,$data)){

                return Response::json('202','��������');

            }
            $Order=new \Order();

            $result=$Order->orderList($status,$userid);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('201','����ʧ��');
        }
        return Response::json('201','��������Ϊ��');
    }

/*
 *����������֧��
 * */

    public function orderPay(){

        $orderId=IFilter::act(I('orderId'),'int');

        $userid=IFilter::act(I('userid'),'int');

    }



}