<?php
/**
 * 店铺
 * User: xufeng
 * Date: 15-2-11
 * Time: 下午5:28
 */
namespace controller;
use classes\Controller;
use classes\Response;
use classes\IFilter;
use Shop;

class shopController extends Controller{

/*
 * 通过产品id检索店铺信息
 * @value $porId 产品id
 * return
 * */
    public function shopInfoByProId(){

        if($ProId=IFilter::act(I('porId'),'int')){

            $Shop=new Shop();

            $result=$Shop->shopInfoByProId($ProId);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','查询失败');
        }

        return Response::json('201','参数不能为空');
    }

/*
 * 通过店铺id检索店铺产品
 * @value $shopId 产品id
 * return
 * */
    public function shopGoodByShopid(){

        if($shopId=IFilter::act(I('shopId'),'int')){

            $Shop=new shop();

            $result=$Shop->shopGoodByShopid($shopId);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','查询失败');
        }
        return Response::json('201','参数不能为空');
    }

}