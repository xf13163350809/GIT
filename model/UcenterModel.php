<?php
/**
 * Created by PhpStorm.
 * User: xufeng
 * Date: 15-2-13
 * Time: 上午11:54
 */

class Ucenter extends Model{

/*
 * 用户消息
 * */
    public function  message($userid,$page){

        $query=new \classes\IQuery('feeds_msg as fm');

        $query->fields=' fm.id as id,fm.message as message,fm.create_time as create_time,fm.is_read as is_read,fm.order_no as order_no,og.img as img';

        $query->join=' left join order as ord ON ord.order_no=fm.order_no left join '.C('DB.DB_PREFIX').'order_goods og ON og.order_id=ord.id ';

        $query->where=" fm.user_id=".$userid." and fm.is_del=0 ";

        $query->page=$page;

        return $query->find();

    }

/*
 * 更新阅读状态
 * */
    public function lookMessge($arr,$userid){

        $err='';

        $query=new \classes\IModel('feeds_msg');

        if(is_array($arr)){

            foreach($arr as $v){

                $result=$query->update('user_id='.$userid.' and is_del=0 and id='.$v,array('is_read'=>1));

                if(!$result){

                    $err.=$v;
                }
            }

        }else{

            $result=$query->update('user_id='.$userid.' and is_del=0 and id='.$arr,array('is_read'=>1));

            if(!$result){

                $err.=$arr;
            }
        }

        if($err){
            return array(false,$err);
        }

        return array(true);
    }

/*
 *收货地址
 * */
    public function address($userid,$page){

        $address=new \classes\IQuery('address');

        $address->fields=' * ';

        $address->where=' user_id='.$userid;

        $address->page=$page;

        $data=$address->find();

        return self::areaNameByCodeToArr($data);

    }

/*
 * 添加收货地址
 * */
    public function addaddress($userid,$name,$mobile,$zip,$telphone,$province,$city,$area,$address,$default){

        $quert=new \classes\IModel('address');

        if(!empty($default)){  //移除原本默认收货地址
            $oid=$quert->getObj('user_id='.$userid,'id');
            $quert->setData(array('default'=>0));
            $quert->update('user_id='.$userid.' and id='.$oid);
        }

        $data=array(
            'user_id'=>$userid,
            'accept_name'=>$name,
            'mobile'=>$mobile,
            'zip'=>$zip,
            'telphone'=>$telphone,
            'province'=>$province,
            'city'=>$city,
            'area'=>$area,
            'address'=>$address,
            'default'=>1
        );
        $result=$quert->getObj('user_id='.$userid.' and accept_name="'.$name.'" and mobile="'.$mobile.'" and zip="'.$zip.'" and telphone="'.$telphone.'"
        and province="'.$province.'" and city="'.$city.'" and area="'.$area.'" and address="'.$address.'"');

        if($result){  //如果已存在该记录

            return 503;
        }

        $quert->setData($data);

        return $quert->add();

    }


/*通过用户id获取用户基本信息
 *return  phone_status 手机绑定状态（0未绑定  1 已绑定）  head_ico：用户图像
 * */
    public function getUserById($userid){

        $user=new \classes\IModel('user');

        return $user->getObj('id='.$userid,'id,username,email,phone,head_ico,phone_status,address,age,sex');

    }

/*
 *修改用户信息
 * @value $userid 用户id
 * @value $data   （array）需要更新改变的数据
 *
 * */
    public function reviseUserInfo($userid,$data){

        $user=new \classes\IModel('user');

        $user->setData($data);

        return $user->update('id='.$userid,$data);

    }


}