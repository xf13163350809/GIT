<?php
/**
 * 产品分类管理
 * User: xufeng
 * Date: 15-2-10
 * Time: 上午10:59
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
     * 查询产品全部分类或指定分类
     *@value classid int 分类id
     *@value channalid int 频道id
     *return json数组
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

           return Response::json('200','查询成功',$rester);
       }

        return Response::json('204','查询不成功',$rester);

    }

    /*
     *
     *通过类id获取类名称
     *@value classid int 分类id
     * */
    public function getNameById(){

        if($classid=IFilter::act(isset($_GET['classid']),'int')){

            $category=new IModel('category');

            $rester=$category->query('id='.$classid,'name');

            if($rester){

                return Response::json('200','',$rester);
            }

            return Response::json('204','查询不成功',$rester);

        }
        return Response::json('201','参数不能为空');
    }


}
?>