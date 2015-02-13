<?php
/**
 * ����ģ��
 * User: xufeng
 * Date: 15-2-13
 * Time: ����1:25
 */

class Order{


/*
 *�����б�
 * @value status  1:δ֧�� 2���Ѹ���  3����ɶ���
 * @value userid  �û�id
 * return array   order_id ����id  goods_id����Ʒid  product_img����ƷͼƬ  product_name����Ʒ����  order_status������״̬��1:���ɶ���,2��ȷ�϶���,3ȡ������,4���϶���,5������ɣ�6��ɶ����� type������Ƶ��
 * */
    public function orderList($status,$userid){

        $were='';

        switch($status){
            case 1: $were=' o.pay_status=0 and o.status=1 and o.user_id='.$userid; break;

            case 2: $were=' o.pay_status=1 and o.status=2 and o.user_id='.$userid; break;

            case 3: $were=' o.pay_status=1 and o.status=6 and o.user_id='.$userid; break;

            default:
                return false;
        }

        $userOrder = new \classes\IQuery('order as o');

        $userOrder->join = "left join order_goods AS og on o.id=og.order_id left join goods as g on og.goods_id=g.id left join jh51_channel c on g.id=c.goods_id";

        $userOrder->where = $were;

        $userOrder->fields =
            "o.id as order_id, og.goods_id as goods_id, g.img as product_img, g.name as product_name, o.status as order_status, c.channel as type ,o.distribution_status as distribution_status ";

        $userOrder->order = "o.create_time desc";

        $result = $userOrder->find();

        return $result;
    }
}