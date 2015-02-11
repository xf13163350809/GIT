<?php
/**
 * 频道管理
 * User: xufeng
 * Date: 15-2-10
 * Time: 上午10:59
 */
namespace controller;
use classes\Pdo;
use classes\Response;
use classes\IFilter;
use classes\Controller;
class channalController extends Controller{

/*
 *通过频道id获得频道首页banner图
 * @value channalid  频道id （1：0元购；2：一折惠；4：返利惠 ; 16:元宝商城 ; 32:即时送达 ; 64:包邮专区 ; 128:特权商品）
 * */

    public function index(){
        if($channalid=IFilter::act(isset($_GET['channalid']),'int')){

            switch($channalid){
/*元宝商城*/
                case 16:
                    $data=array(
                        array(
                            'img'=>'',
                            'url'=>''
                        )
                    );break;
/*即时送达*/
                case 32:
                    $data=array(
                        array(
                            'img'=>'',
                            'url'=>''
                        )
                    );break;
/*包邮专区*/
                case 64:
                    $data=array(
                        array(
                            'img'=>'',
                            'url'=>''
                        )
                    );break;
/*特权商品*/
                case 128:
                    $data=array(
                        array(
                            'img'=>'',
                            'url'=>''
                        )
                    );break;
/*其它*/
                default:
                    $data=array(
                        array(
                            'img'=>'',
                            'url'=>''
                        )
                    );
            }
            return Response::json('200','',$data);
        }
        return Response::json('201','参数不能为空');
    }

    /*
     * 获取全部频道或指定
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

        return Response::json('200','查询成功',$rester);
    }*/

}
?>