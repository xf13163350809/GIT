<?php
namespace classes;
class File{
    static private $ETX;
    public function __construct(){

        $this->_dir=BASE_PATH.'/'.$GLOBALS['config']['cache']['cachePath'].'/';

        if($GLOBALS['config']['cache']['cacheFileType']!==''&&$GLOBALS['config']['cache']['cacheFileType']!=='.php'){

            self::$ETX=$GLOBALS['config']['cache']['cacheFileType'];
        }

    }
    public function cacheData($key,$value='',$cacheTime=''){

        if(empty($cacheTime)&&$cacheTime!==0){

            @$cacheTime=$GLOBALS['config']['cacheTime'];
        }

        $filename=$this->_dir.$key.self::$ETX;

        if($value!==''){ //–¥»Î”Î…æ≥˝ª∫¥Ê

            if(is_null($value)){

                return unlink($filename);

            }

            $dir=dirname($filename);

            if(!is_dir($dir)){

                mkdir($dir,0777);

            }

            $cacheTime=sprintf("%011d",$cacheTime);

            return file_put_contents($filename,$cacheTime.json_encode($value));
        }

        if(!is_file($filename)){
            return false;
        }

        $contents=file_get_contents($filename);

        $cacheTime=(int)substr($contents,0,11);

        $value=substr($contents,11);

        if($cacheTime!=0&&($cacheTime + filemtime($filename)<time())){

            unlink($filename);

            return FALSE;

        }
        return json_decode($value,true);

    }

}?>