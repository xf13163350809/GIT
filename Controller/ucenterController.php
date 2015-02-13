<?php
/**
 * �û�����
 * User: xufeng
 * Date: 15-2-13
 * Time: ����11:50
 */
namespace controller;
use classes\Controller;
use classes\IModel;
use classes\Response;
use classes\IFilter;

class ucenterController extends Controller{

/*
 * �ҵ���Ϣ
 * */
    public function message(){

        $userid=IFilter::act(I('userid'),'int');

        $page=IFilter::act(I('page'),'int');

        if($userid){

            $Ucenter=new \Ucenter();

            $result=$Ucenter->message($userid,$page);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('201','����ʧ�ܻ�����Ϣ');

        }
        return Response::json('201','��������Ϊ��');
    }


/*
 *�鿴��Ϣ
 * @value id  idƴ���ַ��� 1,2,3
 * return true or false
 * */

    public function lookMessge(){

        $id=IFilter::act(I('id'));

        $userid=IFilter::act(I('userid'));

        if($id){

            $data='';
            if(strpos($id,',')){

                $data=implode(',',$id);

            }else{
                $data=$id;
            }

            $Ucenter=new \Ucenter();

            $result=$Ucenter->lookMessge($data,$userid);

            if($result[0]){

                return Response::json('200','',$result);
            }

            return Response::json('201','��ϢidΪ'.$result[1].'״̬����ʧ��');
        }

        return Response::json('201','��������Ϊ��');
    }

/*
 * �ҵ��ջ���ַ
 *
 * */
    public function address(){

        $userid=IFilter::act(I('userid'));

        if(isset($userid)){

            $page=IFilter::act(I('page'));

            $Ucenter=new \Ucenter();

            $result=$Ucenter->address($userid,$page);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('201','����ʧ��');

        }
        return Response::json('201','��������Ϊ��');
    }

/*
 * ����ջ���ַ
 *
 * @value userid �û�id
 * @value name �û���
 * @value mobile �ֻ�
 * @value zip �ʱ�
 * @value telphone ����
 * @value province  ʡid
 * @value city  ��id
 * @value area  ����id
 * @value address  ��ϸ��ַ
 * @value default  �Ƿ���ΪĬ��
 * */
    public function addaddress(){

        $userid=IFilter::act(I('userid'),'int');
        $name=IFilter::act(I('name'));
        $mobile=IFilter::act(I('mobile'));
        $zip=IFilter::act(I('zip'));
        $telphone=IFilter::act(I('telphone')); //����

        $province=IFilter::act(I('province'));
        $city=IFilter::act(I('city'));
        $area=IFilter::act(I('area'));
        $address=IFilter::act(I('address'));
        $default=IFilter::act(I('default'));

        if($userid&&$name&&$mobile&&$province&&$city&&$area&&$address){

            $Ucenter=new \Ucenter();

            $result=$Ucenter->addaddress($userid,$name,$mobile,$zip,$telphone,$province,$city,$area,$address,$default);

            if($result){

                if($result==503){

                    return Response::json('503','�����Ѵ���');
                }

                return Response::json('200','',$result);
            }

            return Response::json('201','����ʧ��');
        }

        return Response::json('201','��������Ϊ��');
    }

/*
 *��������
 * */
    public function getUserById(){

        $userid=IFilter::act(I('userid'),'int');

        if($userid){

             $Ucenter=new \Ucenter();

            $result=$Ucenter->getUserById($userid);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('201','����ʧ��');
        }

        return Response::json('201','��������Ϊ��');
    }

/*
 *�޸ĸ�������
 *
 * @value userid �û�id
 * @value sex �Ա�0��Ů 1���У�
 * @value head_ico ͼ��
 * @value age ����
 * @value address ���ڵ�
 * */
    public function reviseUserInfo(){

            $userid=IFilter::act(I('userid'),'int');
        $head_ico=IFilter::act(I('head_ico'));
        $age=IFilter::act(I('age'),'int');
        $sex=IFilter::act(I('sex'),'int');
        $address=IFilter::act(I('address'));

        if($userid){

            $data=array();  //�齨������Ϣ����
            if($head_ico){

                $data['head_ico']=$head_ico;
            }
            if($age){

                $data['age']=$age;
            }

            if($sex){

                $data['sex']=$sex;
            }
            if($address){

                $data['address']=$address;
            }

            $Ucenter=new \Ucenter();

            $result=$Ucenter->reviseUserInfo($userid,$data);

            if($result){

                return Response::json('200','',$result);
            }

            return Response::json('201','����ʧ��');

        }
        return Response::json('201','��������Ϊ��');
    }
}