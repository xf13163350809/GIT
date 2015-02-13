<?php
/**
 * 订单模型
 * User: xufeng
 * Date: 15-2-13
 * Time: 上午1:25
 */

class Order{


/*
 *订单列表
 * @value status  1:未支付 2：已付款  3：完成订单
 * @value userid  用户id
 * return array   order_id 订单id  goods_id：产品id  product_img：产品图片  product_name：产品名称  order_status：订单状态（1:生成订单,2：确认订单,3取消订单,4作废订单,5交易完成，6完成订单） type：所属频道
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