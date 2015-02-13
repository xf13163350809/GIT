<?php
/**
 * ����
 * User: xufeng
 * Date: 15-2-11
 * Time: ����5:28
 */
namespace controller;
use classes\Controller;
use classes\Response;
use classes\IFilter;
use Shop;

class shopController extends Controller{

/*
 * ͨ����Ʒid����������Ϣ
 * @value $porId ��Ʒid
 * return
 * */
    public function shopInfoByProId(){

        if($ProId=IFilter::act(I('porId'),'int')){

            $Shop=new Shop();

            $result=$Shop->shopInfoByProId($ProId);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','��ѯʧ��');
        }

        return Response::json('201','��������Ϊ��');
    }

/*
 * ͨ������id�������̲�Ʒ
 * @value $shopId ��Ʒid
 * return
 * */
    public function shopGoodByShopid(){

        if($shopId=IFilter::act(I('shopId'),'int')){

            $Shop=new shop();

            $result=$Shop->shopGoodByShopid($shopId);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','��ѯʧ��');
        }
        return Response::json('201','��������Ϊ��');
    }

}