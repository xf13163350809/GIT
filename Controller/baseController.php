<?
/**
 *
 * User: xufeng
 * Date: 15-2-10
 * Time: 上午10:59
 */
namespace controller;
use classes\Pdo;
use classes\Response;
use classes\Controller;
class baseController extends Controller{
    public function index(){
        echo "222222";
    }
    public function aa(){
        $rester=Model()->query('select * from jh51_user where id="8"');

        return Response::json('200','查询成功',$rester);
    }
}
?>