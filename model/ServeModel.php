<?php
/**
 * �ܱ߷���model
 * User: xufeng
 * Date: 15-2-12
 * Time: ����11:39
 */


class Server{

/*
 * ͨ������id��ȡ��Ʒ
 * @value $classId  ����id
 * @value $page     ҳ��
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
                'shopName'=>iconv('gb2312','utf-8','С��ϴ��'),
                'address'=>iconv('gb2312','utf-8','������ �����½�'),
                'tel'=>'13163350809',
                'distance'=>'2km',   //����
                'shop_img'=>array(
                    'images/serve_list_1.jpg',
                    'images/serve_list_1.jpg',
                ),
                'description'=>iconv('gb2312','utf-8','�����׸���ͥ��������ۺ��ͷ���ƽ̨,�һ���ȫ�µ��������������,Ϊ�������ṩһ��ȫ�µĹ��������һվʽ������Ʒ���'),  //���̽���
            ),
            array(
                'img'=>'',
                'shopName'=>iconv('gb2312','utf-8','ƻ��MP3ά�޵�'),
                'address'=>iconv('gb2312','utf-8','������ ����·100��'),
                'tel'=>'13163350809',
                'distance'=>'2km',
                'shop_img'=>array(
                    'images/serve_list_1.jpg',
                    'images/serve_list_1.jpg',
                ),
                'description'=>iconv('gb2312','utf-8','�����׸���ͥ��������ۺ��ͷ���ƽ̨,�һ���ȫ�µ��������������,Ϊ�������ṩһ��ȫ�µĹ��������һվʽ������Ʒ���'),  //���̽���
            ),
            array(
                'img'=>'',
                'shopName'=>iconv('gb2312','utf-8','�ϳɼҵ�ά��'),
                'address'=>iconv('gb2312','utf-8','�³��� ���;���'),
                'tel'=>'13163350809',
                'distance'=>'2km',
                'shop_img'=>array(
                    'images/serve_list_1.jpg',
                    'images/serve_list_1.jpg',
                ),
                'description'=>iconv('gb2312','utf-8','�����׸���ͥ��������ۺ��ͷ���ƽ̨,�һ���ȫ�µ��������������,Ϊ�������ṩһ��ȫ�µĹ��������һվʽ������Ʒ���'),  //���̽���
            )

        );

        return $data;
    }

/*
 * ͨ������id��õ�����Ϣ
 * @value shopid��ȡ������Ϣ�Լ�ǰʮ������
 * @value $position��ȡ�����̾���
 * */
    public function shopInfo($shopId,$position){

        $data=array(
            array(
                'id'=>1,
                'img'=>'images/serve_list_1.jpg',
                'shopName'=>iconv('gb2312','utf-8','С��ϴ��'),
                'address'=>iconv('gb2312','utf-8','������ �����½�'),
                'tel'=>'13163350809',
                'distance'=>'2km',   //����
                'shop_img'=>array(   //������ϸͼƬ
                    'images/serve_list_1.jpg',
                    'images/serve_list_1.jpg',
                ),
                'shop_id'=>10,      //����id
                'description'=>iconv('gb2312','utf-8','�����׸���ͥ��������ۺ��ͷ���ƽ̨,�һ���ȫ�µ��������������,Ϊ�������ṩһ��ȫ�µĹ��������һվʽ������Ʒ���'),  //���̽���
            ),
            array(
                'id'=>2,
                'img'=>'',
                'shopName'=>iconv('gb2312','utf-8','ƻ��MP3ά�޵�'),
                'address'=>iconv('gb2312','utf-8','������ ����·100��'),
                'tel'=>'13163350809',
                'distance'=>'2km',
                'shop_img'=>array(
                    'images/serve_list_1.jpg',
                    'images/serve_list_1.jpg',
                ),
                'shop_id'=>11,
                'description'=>iconv('gb2312','utf-8','�����׸���ͥ��������ۺ��ͷ���ƽ̨,�һ���ȫ�µ��������������,Ϊ�������ṩһ��ȫ�µĹ��������һվʽ������Ʒ���'),  //���̽���
            ),
            array(
                'id'=>3,
                'img'=>'',
                'shopName'=>iconv('gb2312','utf-8','�ϳɼҵ�ά��'),
                'address'=>iconv('gb2312','utf-8','�³��� ���;���'),
                'tel'=>'13163350809',
                'distance'=>'2km',
                'shop_img'=>array(
                    'images/serve_list_1.jpg',
                    'images/serve_list_1.jpg',
                ),
                'shop_id'=>12,
                'description'=>iconv('gb2312','utf-8','�����׸���ͥ��������ۺ��ͷ���ƽ̨,�һ���ȫ�µ��������������,Ϊ�������ṩһ��ȫ�µĹ��������һվʽ������Ʒ���'),  //���̽���
            ),

            'comment'=>array( //����ǰʮ������
                array(
                    'id'=>1,
                    'username'=>iconv('gb2312','utf-8','ʧ��R����'),
                    'content'=>iconv('gb2312','utf-8','�ǳ������һ�ι������������'),
                    'create_time'=>'2015-2-12',
                ),
                array(
                    'id'=>2,
                    'username'=>iconv('gb2312','utf-8','İ·'),
                    'content'=>iconv('gb2312','utf-8','�����ܺã�����Ҳ�ܵ�λ��'),
                    'create_time'=>'2015-2-14',
                ),
                array(
                    'id'=>3,
                    'username'=>iconv('gb2312','utf-8','��Ը'),
                    'content'=>iconv('gb2312','utf-8','�����ܿ죬��װҲ��������'),
                    'create_time'=>'2015-2-13',
                ),
            )

        );

        return $data;
    }

/*
 *ͨ������id������������
 * @value $shopId ����id
 * @value $page  ҳ��
 * */
    public function shopEval($shopId,$page){

        $data=array(
            array(
                'id'=>1,
                'username'=>iconv('gb2312','utf-8','ʧ��R����'),
                'content'=>iconv('gb2312','utf-8','�ǳ������һ�ι������������'),
                'create_time'=>'2015-2-12',
            ),
            array(
                'id'=>2,
                'username'=>iconv('gb2312','utf-8','İ·'),
                'content'=>iconv('gb2312','utf-8','�����ܺã�����Ҳ�ܵ�λ��'),
                'create_time'=>'2015-2-14',
            ),
            array(
                'id'=>3,
                'username'=>iconv('gb2312','utf-8','��Ը'),
                'content'=>iconv('gb2312','utf-8','�����ܿ죬��װҲ��������'),
                'create_time'=>'2015-2-13',
            ),
        );

        return $data;
    }


/*
 * ���̺��������
 * @value  shopId  ����id
 * @value  dot   1:����  2������
 * @value  userid  �û�id
 * return TURE OR FALSE OR 0
 * */
    public function shopForDot($shopId,$dot,$userid){

        /*
         * ���ݿ����
         * */

        /*---ģ��--*/
        if(1){//ͨ���û�id�ж��Ƿ��Ѿ��������

            if(1){
                return true;    //���ݿ�����ɹ�
            }

            return false;    //���ݿ����ʧ��
        }
        return 0; //����Ѿ����������ء�0��
        /*---ģ��--*/
    }


/*
 * �û��Ե�������
 * @value $shopId ����id
 * @value $userid �û�id
 * @value $message ����
 * return  ����id OR FALSE
 * */
    public function shopSetEval($shopId,$userid,$message){

        /*
         * ���ݿ����
         * */

        /*---ģ��--*/
        if(1){
            return 10;  //��������id
        }

        return false;
        /*---ģ��--*/

    }
}