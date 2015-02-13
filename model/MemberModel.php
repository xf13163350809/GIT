<?php
/**
 * Created by PhpStorm.
 * User: xufeng
 * Date: 15-2-12
 * Time: ÏÂÎç7:59
 */

class Member extends Model{

    public function login($username,$password){

        $user=new \classes\IQuery('user');

        $user->fields=' id,username,email,phone ';

        $user->where=' username='.$username.' and password="'.$password.'"';

        $user->limit=' 1 ';

        $result=$user->find();

        return $result;

    }
/*
 * ×¢²á
 * */
    public function register($username,$password,$type){

        $user=new \classes\IModel('user');

        $userid=$user->getObj(' username='.$username,' id ');

        if(!$userid){

            if($type===1){
                $where=' username='.$username;

                $data=array('username' => $username,'password'=>$password,'phone'=>$username,'phone_status'=>1);

            }else{
                $where=' username='.$username;

                $data=array('username' => $username,'password'=>$password,'email'=>$username);
            }

            $user->setData($data);

            return $user->add();


        }else{

            return 0;
        }
    }


    public function forgetPWD($phoneNum,$password){

        $user=new \classes\IModel('user');

        $where=' username='.$phoneNum;

        $data=array(
            'password'=>$password,
            'phone_status'=>1
        );

       return $user->update($where,$data);
    }

}