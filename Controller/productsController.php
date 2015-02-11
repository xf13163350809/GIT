<?php
/**
 * �̳ǲ�Ʒ
 * User: xufeng
 * Date: 15-2-10
 * Time: ����11:22
 */
namespace controller;
use classes\IModel;
use classes\Response;
use classes\IFilter;
use classes\IQuery;
use classes\Controller;
class productsController extends Controller{

    /*
     *��������/��Ʒ����
     *$value keyword �����ؼ���
     *@value channalid Ƶ��id
     * retunr json����
     * */
    public function search(){

        if($keyword=IFilter::act(I('keyword'))){

             if(!$channelid=IFilter::act(I('channelid'),'int')){

                /*��Ʒ����*/
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

                        return Response::json('204','��ѯʧ��');
                    }
                }

                if($goods_result){

                    return Response::json('200','',$goods_result);
                }

                    return Response::json('204','��ѯʧ��');

            }else{

                 /*��Ʒ����*/
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

                         return Response::json('204','��ѯʧ��');
                     }
                 }

                 if($goods_result){

                     return Response::json('200','',$goods_result);
                 }

                 return Response::json('204','��ѯʧ��');

             }
        }
        return Response::json('201','��������Ϊ��');
    }

    /*
     * ��Ʒ�б�ͨ��Ƶ���ͷ����Լ������ȡ
     *@value channelid
     *@value classid
     *@value sale
     *@value eval
     *@value price
     * return ajax ����
     * */
    public function productsList(){

       $sale=IFilter::act(I('sale'),'int');  //�ۺ�

       $eval=IFilter::act(I('eval'),'int');  //����

       $price=IFilter::act(I('price'),'int'); //�۸�(1:�͵��� or 2���ߵ���)

        if($channelid=IFilter::act(I('channelid'),'int')&&$classid=IFilter::act(I('classid'),'int')){

            $channel=new IQuery('goods as g');

            $channel->field='';

            $channel->join=' left join '.C('DB.DB_PREFIX').'category_extend ce ON ce.goods_id=g.id left join '.C('DB.DB_PREFIX').'channel ch ON ch.goods_id=g.id';

            $channel->where=' ch.channel='.$channelid.' and ce.category_id='.$classid;

            $order='';

            if(!empty($price)&&empty($eval)&&empty($sale)){ //���ݼ۸�����

                $order=' g.sell_price asc';

                if($price==2){

                    $order=' g.sell_price desc';

                }

            }else if(!empty($eval)&&empty($sale)&&empty($price)){//������������

                $order=' g.id desc';

            }else{                          //Ĭ�ϸ����ۺ�����
                $order=' g.id desc';
            }

            $channel->order=$order;

            $goods_result=$channel->find();

            if($goods_result){

                return Response::json('200','',$goods_result);
            }

            return Response::json('204','��ѯʧ��');
        }

        return Response::json('201','��������Ϊ��');
    }

    /*
     * ��Ʒ��ϸ
     * @value  porId ��Ʒid�����룩
     * @value  channelid Ƶ��id�����룩
     * */
    public function productsDetail(){

        if($channelid=IFilter::act(I('channelid'),'int')&&$porId=IFilter::act(I('porId'),'int')){  //��Ʒid��Ƶ��id

            $Products=new \Products();

           $result=$Products->productsDetail($porId,$channelid);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','��ѯʧ��');
        }

        return Response::json('201','��������Ϊ��');
    }


}