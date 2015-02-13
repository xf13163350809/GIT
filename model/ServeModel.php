<?php
/**
 * 周边服务model
 * User: xufeng
 * Date: 15-2-12
 * Time: 上午11:39
 */


class Server{

/*
 * 通过分类id获取产品
 * @value $classId  分类id
 * @value $page     页数
 * */
    public function proListByClassId($classId,$page,$position){

       /* $goods=new \classes\IQuery('category as c');

        $goods->field=' g.* ';

        $goods->join=' left join '.C('DB.DB_PREFIX').'category_extend ce on ce.category_id=c.id';

        $goods->join=' left join '.C('DB.DB_PREFIX').'goods g on ce.goods_id=g.id';

        $goods->where=' c.id='.$classId;

        $result=$goods->find();

        var_dump($result);

        exit;*/

        $data=array(
            array(
                'img'=>'images/serve_list_1.jpg',
                'shopName'=>iconv('gb2312','utf-8','小明洗衣'),
                'address'=>iconv('gb2312','utf-8','西湖区 西港新界'),
                'tel'=>'13163350809',
                'distance'=>'2km',   //距离
                'shop_img'=>array(
                    'images/serve_list_1.jpg',
                    'images/serve_list_1.jpg',
                ),
                'description'=>iconv('gb2312','utf-8','国内首个家庭消费理财综合型服务平台,钜惠以全新的生活理念的理念,为消费者提供一个全新的购物体验和一站式消费理财服务。'),  //店铺介绍
            ),
            array(
                'img'=>'',
                'shopName'=>iconv('gb2312','utf-8','苹果MP3维修点'),
                'address'=>iconv('gb2312','utf-8','西湖区 文三路100号'),
                'tel'=>'13163350809',
                'distance'=>'2km',
                'shop_img'=>array(
                    'images/serve_list_1.jpg',
                    'images/serve_list_1.jpg',
                ),
                'description'=>iconv('gb2312','utf-8','国内首个家庭消费理财综合型服务平台,钜惠以全新的生活理念的理念,为消费者提供一个全新的购物体验和一站式消费理财服务。'),  //店铺介绍
            ),
            array(
                'img'=>'',
                'shopName'=>iconv('gb2312','utf-8','诚成家电维修'),
                'address'=>iconv('gb2312','utf-8','下城区 朝晖九区'),
                'tel'=>'13163350809',
                'distance'=>'2km',
                'shop_img'=>array(
                    'images/serve_list_1.jpg',
                    'images/serve_list_1.jpg',
                ),
                'description'=>iconv('gb2312','utf-8','国内首个家庭消费理财综合型服务平台,钜惠以全新的生活理念的理念,为消费者提供一个全新的购物体验和一站式消费理财服务。'),  //店铺介绍
            )

        );

        return $data;
    }

/*
 * 通过店铺id获得店铺信息
 * @value shopid获取店铺信息以及前十条评论
 * @value $position获取到店铺距离
 * */
    public function shopInfo($shopId,$position){

        $data=array(
            array(
                'id'=>1,
                'img'=>'images/serve_list_1.jpg',
                'shopName'=>iconv('gb2312','utf-8','小明洗衣'),
                'address'=>iconv('gb2312','utf-8','西湖区 西港新界'),
                'tel'=>'13163350809',
                'distance'=>'2km',   //距离
                'shop_img'=>array(   //店铺详细图片
                    'images/serve_list_1.jpg',
                    'images/serve_list_1.jpg',
                ),
                'shop_id'=>10,      //店铺id
                'description'=>iconv('gb2312','utf-8','国内首个家庭消费理财综合型服务平台,钜惠以全新的生活理念的理念,为消费者提供一个全新的购物体验和一站式消费理财服务。'),  //店铺介绍
            ),
            array(
                'id'=>2,
                'img'=>'',
                'shopName'=>iconv('gb2312','utf-8','苹果MP3维修点'),
                'address'=>iconv('gb2312','utf-8','西湖区 文三路100号'),
                'tel'=>'13163350809',
                'distance'=>'2km',
                'shop_img'=>array(
                    'images/serve_list_1.jpg',
                    'images/serve_list_1.jpg',
                ),
                'shop_id'=>11,
                'description'=>iconv('gb2312','utf-8','国内首个家庭消费理财综合型服务平台,钜惠以全新的生活理念的理念,为消费者提供一个全新的购物体验和一站式消费理财服务。'),  //店铺介绍
            ),
            array(
                'id'=>3,
                'img'=>'',
                'shopName'=>iconv('gb2312','utf-8','诚成家电维修'),
                'address'=>iconv('gb2312','utf-8','下城区 朝晖九区'),
                'tel'=>'13163350809',
                'distance'=>'2km',
                'shop_img'=>array(
                    'images/serve_list_1.jpg',
                    'images/serve_list_1.jpg',
                ),
                'shop_id'=>12,
                'description'=>iconv('gb2312','utf-8','国内首个家庭消费理财综合型服务平台,钜惠以全新的生活理念的理念,为消费者提供一个全新的购物体验和一站式消费理财服务。'),  //店铺介绍
            ),

            'comment'=>array( //店铺前十条评论
                array(
                    'id'=>1,
                    'username'=>iconv('gb2312','utf-8','失落R海角'),
                    'content'=>iconv('gb2312','utf-8','非常满意的一次购物，还会再来！'),
                    'create_time'=>'2015-2-12',
                ),
                array(
                    'id'=>2,
                    'username'=>iconv('gb2312','utf-8','陌路'),
                    'content'=>iconv('gb2312','utf-8','宝贝很好，服务也很到位！'),
                    'create_time'=>'2015-2-14',
                ),
                array(
                    'id'=>3,
                    'username'=>iconv('gb2312','utf-8','心愿'),
                    'content'=>iconv('gb2312','utf-8','发货很快，包装也本完美！'),
                    'create_time'=>'2015-2-13',
                ),
            )

        );

        return $data;
    }

/*
 *通过店铺id检索店铺评论
 * @value $shopId 店铺id
 * @value $page  页数
 * */
    public function shopEval($shopId,$page){

        $data=array(
            array(
                'id'=>1,
                'username'=>iconv('gb2312','utf-8','失落R海角'),
                'content'=>iconv('gb2312','utf-8','非常满意的一次购物，还会再来！'),
                'create_time'=>'2015-2-12',
            ),
            array(
                'id'=>2,
                'username'=>iconv('gb2312','utf-8','陌路'),
                'content'=>iconv('gb2312','utf-8','宝贝很好，服务也很到位！'),
                'create_time'=>'2015-2-14',
            ),
            array(
                'id'=>3,
                'username'=>iconv('gb2312','utf-8','心愿'),
                'content'=>iconv('gb2312','utf-8','发货很快，包装也本完美！'),
                'create_time'=>'2015-2-13',
            ),
        );

        return $data;
    }


/*
 * 店铺好评与差评
 * @value  shopId  店铺id
 * @value  dot   1:好评  2：差评
 * @value  userid  用户id
 * return TURE OR FALSE OR 0
 * */
    public function shopForDot($shopId,$dot,$userid){

        /*
         * 数据库操作
         * */

        /*---模拟--*/
        if(1){//通过用户id判断是否已经点击评价

            if(1){
                return true;    //数据库操作成功
            }

            return false;    //数据库操作失败
        }
        return 0; //如果已经操作过返回‘0’
        /*---模拟--*/
    }


/*
 * 用户对店铺评价
 * @value $shopId 店铺id
 * @value $userid 用户id
 * @value $message 内容
 * return  新增id OR FALSE
 * */
    public function shopSetEval($shopId,$userid,$message){

        /*
         * 数据库操作
         * */

        /*---模拟--*/
        if(1){
            return 10;  //返回新增id
        }

        return false;
        /*---模拟--*/

    }
}