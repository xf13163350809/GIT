<?php
/**
 *�������
 * User: xufeng
 * Date: 15-2-12
 * Time: ����10:05
 */

namespace controller;
use classes\Controller;
use classes\Response;
use classes\IFilter;
use Shop;

class serveController extends Controller{

/*
 * ͨ����Ʒid����������Ϣ
 * @value $porId ��Ʒid
 * return
 * */
    /*public function index(){

        if($channel=IFilter::act(I('channel'))&&IFilter::act(I('channel'))=='serve'){

            $banner_arr=array(
                'img'=>
                array(
                    'img'=>'',
                    'url'=>''
                ),
                array(
                    'img'=>'',
                    'url'=>''
                ),
            );
            return Response::json('200','',$banner_arr);
        }

        return Response::json('201','��������Ϊ��');
    }*/
/*
 *
 *
 * */
    public function proListByClassId(){

        $page=IFilter::act(I('page'),'int');

        if($classId=IFilter::act(I('classId'))&&IFilter::act(I('channel'))=='serve'&&$position=IFilter::act(I('position'))){

            $Server=new \Server();

            $result=$Server->proListByClassId($classId,$page,$position);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','��ѯʧ��');

        }
        return Response::json('201','��������Ϊ��');
    }

/*
 * ͨ������id��õ�����Ϣ
 * @value shopid��ȡ������Ϣ�Լ�ǰʮ������
 * @value $position��ȡ�����̾���
 * @value $channel ��֤Ƶ��
 * */
    public function shopInfo(){

        $shopId=IFilter::act(I('shopId'),'int');

        $position=IFilter::act(I('position'));

        if($shopId&&IFilter::act(I('channel'))=='serve'&&$position){

            $Server=new \Server();

            $result=$Server->shopInfo($shopId,$position);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','��ѯʧ��');

        }
        return Response::json('201','��������Ϊ��');


    }


/*
 * ͨ������id�������
 * @value shopid ��ȡ����id
 * @value $channel ��֤Ƶ��
 * */
    public function shopEval(){

        $shopId=IFilter::act(I('shopId'),'int');

        $page=IFilter::act(I('page'),'int');

        if(IFilter::act(I('channel'))=='serve'&&$shopId){

            $Server=new \Server();

            $result=$Server->shopEval($shopId,$page);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','��ѯʧ��');
        }
        return Response::json('201','��������Ϊ��');
    }

/*
 * ���̺��������
 * @value  shopId  ����id
 * @value  userid  �û�id
 * @value  dot   1:����  2������
 * */
    public function shopForDot(){

        $data=array(1,2);  //���۲�������

        $shopId=IFilter::act(I('shopId'),'int');

        $dot=IFilter::act(I('dot'),'int');

        $userid=IFilter::act(I('userid'),'int');

        if(IFilter::act(I('channel'))=='serve'&&$shopId&&$dot&&$userid){

            if(in_array($dot,$data)){

                $Server=new \Server();

                $result=$Server->shopForDot($shopId,$dot,$userid);

                if($result){

                    return Response::json('200','',$result);
                }

                if($result===0){

                    return Response::json('503','');  //�û��Ѿ�������
                }

                return Response::json('204','����ʧ��');
            }

            return Response::json('501','����ֵ������');

        }
        return Response::json('201','��������Ϊ��');

    }

/*
 * �û��Ե�������
 *@value  $shopId ����id
 *@value  $userid �û�id
 *@value  $message ��������
 * return ������¼id
 * */
    public function shopSetEval(){

        $shopId=IFilter::act(I('shopId'),'int');

        $userid=IFilter::act(I('userid'),'int');

        $message=IFilter::act(I('message'));

        if(IFilter::act(I('channel'))=='serve'&&$shopId&&$userid&&$message){

            $Server=new \Server();

            $result=$Server->shopSetEval($shopId,$userid,$message);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','����ʧ��');

        }
        return Response::json('201','��������Ϊ��');
    }


}