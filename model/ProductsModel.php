<?php

/**
 * ��Ʒmodel
 * User: xufeng
 * Date: 15-2-11
 * Time: ����2:04
 */
class Products extends Model{

    /*
     * ��Ʒ��ϸ
     * @value $porId ��Ʒid
     * return ������Ʒ��Ϣ�������
     * */
    public function productsDetail($porId,$channelid){

        $goods=new \classes\IQuery('goods as g');

        $goods->fields='g.*';

        $goods->join=' left join '.C('DB.DB_PREFIX').'channel ch on ch.goods_id';

        $goods->where=' g.id='.$porId.' and ch.channel='.$channelid;

        $goods->limit='1';

        $goods_result=$goods->find();

        $products_result='';

        if($goods_result[0]){

            $products=new \classes\IModel('products');

            $products_result=$products->query('goods_id='.$porId);
        }else{

            return false;
        }

        $data=array_merge($goods_result[0],array('specific'=>$products_result)); //�ϲ���Ʒ��Ϣ����

        return $data;
    }


}