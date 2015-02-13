<?php
/**
 * Created by PhpStorm.
 * User: xufeng
 * Date: 15-2-11
 * Time: 下午2:07
 */
class Model{

    public function __construct(){

    }

    public function areaNameByCodeToArr($arr){

        if(isset($arr['province'])||isset($arr['city'])||isset($arr['area'])){//一维数组

            $add_arr=array(
                $arr['province'],
                $arr['city'],
                $arr['area']
            );

            $areaDB=new \classes\IModel('areas');

            $areaResult = $areaDB->query("area_id in (" . join(',', $add_arr) . ")");

            $add=array();
            foreach($areaResult as $value){
                if($value['area_id']==$arr['province']){
                    $arr['province']=$value['area_name'];
                }

                if($value['area_id']==$arr['city']){
                    $arr['city']=$value['area_name'];
                }

                if($value['area_id']==$arr['area']){
                    $arr['area']=$value['area_name'];
                }
            }

        }else{ //多维数组

            foreach($arr as $v){

                self::areaNameByCodeToArr($v);
            }

        }
        return $arr;
    }
}