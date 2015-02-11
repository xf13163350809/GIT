<?php
/**
 * ��Ʒ�������
 * User: xufeng
 * Date: 15-2-10
 * Time: ����10:59
 */
namespace controller;
use classes\IFilter;
use classes\IQuery;
use classes\Pdo;
use IModel;
use classes\Response;
use classes\Controller;

class categoryController extends Controller{

    /*
     * ��ѯ��Ʒȫ�������ָ������
     *@value classid int ����id
     *@value channalid int Ƶ��id
     *return json����
     * */
    public function index(){
        $where =" 1=1 ";

        if(IFilter::act(isset($_GET['classid']))){

            $where.=" parent_id=".$_GET['classid'];

        }
        if(IFilter::act(isset($_GET['channalid']))){

            $where.=" where channalid=".$_GET['classid'];

        }

        $category=new IModel('category');

       $rester=$category->query($where);

       if($rester){

           return Response::json('200','��ѯ�ɹ�',$rester);
       }

        return Response::json('204','��ѯ���ɹ�',$rester);

    }

    /*
     *
     *ͨ����id��ȡ������
     *@value classid int ����id
     * */
    public function getNameById(){

        if($classid=IFilter::act(isset($_GET['classid']),'int')){

            $category=new IModel('category');

            $rester=$category->query('id='.$classid,'name');

            if($rester){

                return Response::json('200','',$rester);
            }

            return Response::json('204','��ѯ���ɹ�',$rester);

        }
        return Response::json('201','��������Ϊ��');
    }


}
?>