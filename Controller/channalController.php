<?php
/**
 * Ƶ������
 * User: xufeng
 * Date: 15-2-10
 * Time: ����10:59
 */
namespace controller;
use classes\Pdo;
use classes\Response;
use classes\IFilter;
use classes\Controller;
class channalController extends Controller{

/*
 *ͨ��Ƶ��id���Ƶ����ҳbannerͼ
 * @value channalid  Ƶ��id ��1��0Ԫ����2��һ�ۻݣ�4�������� ; 16:Ԫ���̳� ; 32:��ʱ�ʹ� ; 64:����ר�� ; 128:��Ȩ��Ʒ��
 * */

    public function index(){
        if($channalid=IFilter::act(isset($_GET['channalid']),'int')){

            switch($channalid){
/*����*/
                case 4:
                    $data=array(
                        array(
                            'img'=>'',
                            'url'=>''
                        )
                    );break;
/*�������*/
                case 8:
                    $data=array(
                        array(
                            'img'=>'',
                            'url'=>''
                        )
                    );break;

/*Ԫ���̳�*/
                case 16:
                    $data=array(
                        array(
                            'img'=>'',
                            'url'=>''
                        )
                    );break;
/*��������*/
                case 32:
                    $data=array(
                        array(
                            'img'=>'',
                            'url'=>''
                        )
                    );break;
/*�һ��̳�*/
                case 64:
                    $data=array(
                        array(
                            'img'=>'',
                            'url'=>''
                        )
                    );break;
/*�����ػ�*/
                case 128:
                    $data=array(
                        array(
                            'img'=>'',
                            'url'=>''
                        )
                    );break;

 /*�ܱ��Ż�*/    case 256:
                    $data=array(
                        array(
                            'img'=>'',
                            'url'=>''
                        )
                    );break;

  /*����*/       case 512:
                    $data=array(
                        array(
                            'img'=>'',
                            'url'=>''
                        )
                    );break;
/*����*/
                default:
                    return '';
            }
            return Response::json('200','',$data);
        }
        return Response::json('201','��������Ϊ��');
    }

    /*
     * ��ȡȫ��Ƶ����ָ��
     * */
   /* public function show_all(){
        $where ="";

        if(IFilter::act(isset($_GET['classid']),'int')){

            $where=" where parent_id=".$_GET['classid'];

        }
        if(IFilter::act(isset($_GET['channalid']),'int')){

            $where=" where channalid=".$_GET['classid'];

        }
        $sql='select * from jh51_channel'.$where;

        $rester=Model()->query($sql);

        return Response::json('200','��ѯ�ɹ�',$rester);
    }*/

}
?>