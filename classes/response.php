<?php
namespace classes;
use classes;
class Response {
    /*ʵ����*/

    /*
     * ����Json��ʽ����
     * $code ����
     * $message ��ʾ��Ϣ
     * $data  ����(����)*/
   static public function json($code,$message='',$data=array()){
        if(!is_numeric($code)){
            return '���ر��벻��Ϊ��';
        }
        $arr=array(
            'code'=>$code,
            'msg'=>iconv('gb2312','utf-8',$message),
            'data'=>$data,
       );

       $str=$arr;
        unset($arr);
        echo json_encode($str);
    }

    /**
     * XML����
     * @param mixed $data ����
     * @param string $root ���ڵ���
     * @param string $item �����������ӽڵ���
     * @param string $attr ���ڵ�����
     * @param string $id   ���������ӽڵ�keyת����������
     * @param string $encoding ���ݱ���
     * @return string
     */
    static function xml_encode($data, $root='think', $item='item', $attr='', $id='id', $encoding='utf-8') {
        if(is_array($attr)){
            var_dump($data);
            $_attr = array();
            foreach ($attr as $key => $value) {
                $_attr[] = "{$key}=\"{$value}\"";
            }
            $attr = implode(' ', $_attr);
        }


        $attr   = trim($attr);
        $attr   = empty($attr) ? '' : " {$attr}";
        $xml    = "<?xml version=\"1.0\" encoding=\"{$encoding}\"?>";
        $xml   .= "<{$root}{$attr}>";
        $xml   .= self::data_to_xml($data, $item, $id);
        $xml   .= "</{$root}>";
        echo $xml;
    }

    /**
     * ����XML����
     * @param mixed  $data ����
     * @param string $item ��������ʱ�Ľڵ�����
     * @param string $id   ��������keyת��Ϊ��������
     * @return string
     */
   static function data_to_xml($data, $item='item', $id='id') {
        $xml = $attr = '';
        foreach ($data as $key => $val) {
            if(is_numeric($key)){
                $id && $attr = " {$id}=\"{$key}\"";
                $key  = $item;
            }
            $xml    .=  "<{$key}{$attr}>";
            $xml    .=  (is_array($val) || is_object($val)) ? self::data_to_xml($val, $item, $id) : $val;
            $xml    .=  "</{$key}>";
        }
        return $xml;
    }
}

?>