<?php

/**
 * 产品model
 * User: xufeng
 * Date: 15-2-11
 * Time: 下午2:04
 */
class Shop extends Model{

    /*
     * 通过产品id检索店铺信息
     * @value $porId 产品id
     * return
     * */
    public function shopInfoByProId($porId){

        $shop_goods=new \classes\IQuery('shop_goods as sg');

        $shop_goods->fields='s.*,sg.*,s.id as id';

        $shop_goods->join=' left join '.C('DB.DB_PREFIX').'shop s on s.id=sg.shop_id';

        $shop_goods->where=' sg.goods_id='.$porId;

        $shop_goods->limit=' 1';

        $result=$shop_goods->find();

        return $result[0];
    }
    /*
     * 通过产品id检索店铺信息
     * @value $porId 产品id
     * return
     * */

    public function shopGoodByShopid($shopId){

        $shop_goods=new \classes\IQuery('goods as g');

        $shop_goods->fields=' g.*,count(g.id) as goods_num';

        $shop_goods->join=' left join '.C('DB.DB_PREFIX').'shop_goods sg ON g.id=sg.goods_id';

        $shop_goods->where='sg.shop_id='.$shopId;

        $result=$shop_goods->find();

        return $result;

    }


}