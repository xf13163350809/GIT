<?php
/**
 * 商城产品
 * User: xufeng
 * Date: 15-2-10
 * Time: 上午11:22
 */
namespace controller;
use classes\IModel;
use classes\Response;
use classes\IFilter;
use classes\IQuery;
use classes\Controller;
class productsController extends Controller{

    /*
     *顶部店铺/商品搜索
     *$value keyword 搜索关键字
     *@value channalid 频道id
     * retunr json数组
     * */
    public function search(){

        if($keyword=IFilter::act(I('keyword'))){

             if(!$channelid=IFilter::act(I('channelid'),'int')){

                /*商品名称*/
                $goods=new IModel('goods');

                $goods_result=$goods->query('name like "%'.$keyword.'%"');

                $shop=new IModel('shop');

                $shop_id=$shop->getObj('name ="'.$keyword.'"','id');

                if($shop_id){

                    $shop_good=new IQuery('shop_goods AS sg');

                    $shop_good->fields='g.*';

                    $shop_good->join=' left join '.C('DB.DB_PREFIX').'goods g ON g.id=sg.goods_id';

                    $shop_good->where=' sg.shop_id='.$shop_id;

                    $goods_result=$shop_good->find();

                    unset($keyword);

                    if(!$goods_result){

                        return Response::json('204','查询失败');
                    }
                }

                if($goods_result){

                    return Response::json('200','',$goods_result);
                }

                    return Response::json('204','查询失败');

            }else{

                 /*商品名称*/
                 $goods=new IQuery('goods as g');

                 $goods->fields='g.*';

                 $goods->join=' left join '.C('DB.DB_PREFIX').'channel ch ON g.id=ch.goods_id';

                 $goods->where=' ch.channel='.$channelid.' and g.name like "%'.$keyword.'%"';

                 $goods_result=$goods->find();

                 $shop=new IModel('shop');

                 $shop_id=$shop->getObj('name ="'.$keyword.'"','id');

                 if($shop_id){

                     $shop_good=new IQuery('shop_goods AS sg');

                     $shop_good->fields='g.*';

                     $shop_good->join=' left join '.C('DB.DB_PREFIX').'goods g ON g.id=sg.goods_id';

                     $shop_good->join=' left join '.C('DB.DB_PREFIX').'channel ch on ch.goods_id=sg.id';

                     $shop_good->where=' sg.shop_id='.$shop_id.' and ch.channel='.$channelid;

                     $goods_result=$shop_good->find();

                     unset($keyword);

                     if(!$goods_result){

                         return Response::json('204','查询失败');
                     }
                 }

                 if($goods_result){

                     return Response::json('200','',$goods_result);
                 }

                 return Response::json('204','查询失败');

             }
        }
        return Response::json('201','参数不能为空');
    }

    /*
     * 产品列表：通过频道和分类以及排序获取
     *@value channelid
     *@value classid
     *@value sale
     *@value eval
     *@value price
     * return ajax 数组
     * */
    public function productsList(){

       $sale=IFilter::act(I('sale'),'int');  //综合

       $eval=IFilter::act(I('eval'),'int');  //评价

       $price=IFilter::act(I('price'),'int'); //价格(1:低到高 or 2：高到低)

        if($channelid=IFilter::act(I('channelid'),'int')&&$classid=IFilter::act(I('classid'),'int')){

            $channel=new IQuery('goods as g');

            $channel->field='';

            $channel->join=' left join '.C('DB.DB_PREFIX').'category_extend ce ON ce.goods_id=g.id left join '.C('DB.DB_PREFIX').'channel ch ON ch.goods_id=g.id';

            $channel->where=' ch.channel='.$channelid.' and ce.category_id='.$classid;

            $order='';

            if(!empty($price)&&empty($eval)&&empty($sale)){ //根据价格排序

                $order=' g.sell_price asc';

                if($price==2){

                    $order=' g.sell_price desc';

                }

            }else if(!empty($eval)&&empty($sale)&&empty($price)){//根据评价排序

                $order=' g.id desc';

            }else{                          //默认根据综合排序
                $order=' g.id desc';
            }

            $channel->order=$order;

            $goods_result=$channel->find();

            if($goods_result){

                return Response::json('200','',$goods_result);
            }

            return Response::json('204','查询失败');
        }

        return Response::json('201','参数不能为空');
    }

    /*
     * 产品详细
     * @value  porId 产品id（必须）
     * @value  channelid 频道id（必须）
     * */
    public function productsDetail(){

        if($channelid=IFilter::act(I('channelid'),'int')&&$porId=IFilter::act(I('porId'),'int')){  //产品id和频道id

            $Products=new \Products();

           $result=$Products->productsDetail($porId,$channelid);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','查询失败');
        }

        return Response::json('201','参数不能为空');
    }


}