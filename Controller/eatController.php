<?php
/**
 * ���͹���
 * User: xufeng
 * Date: 15-2-12
 * Time: ����5:16
 */
namespace controller;
use classes\Controller;
use classes\Response;
use classes\IFilter;

class eatController extends Controller{

/*
 * ������ҳ
 * */
    public function index(){

        /*bannerͼƬ*/
        $img_arr=array(
            array(
                'img'=>'',
                'url'=>''
            )
        );

        $position=IFilter::act(I('position'));

        if(IFilter::act(I('channel'))=='eat'&&$position){

            $Server=new \Eat();

            //$result=$Server->shopSetEval($shopId,$userid,$message);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','����ʧ��');

        }
        return Response::json('201','��������Ϊ��');
    }
/*
 * ͨ���ͻ��˵�ַ��������Ż���Ϣ
 *@value $position �ͻ���λ��
 * */
    public function eatList(){

        $position=IFilter::act(I('position'));

        $page=IFilter::act(I('page'));

        if(IFilter::act(I('channel'))=='eat'&&$position&&$page){

            $Eat=new \Eat();

            $result=$Eat->eatList($position,$page);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('204','����ʧ��');

        }
    }
}