<?php
/**
 * ���Ĺ�������
 */

/**
 * �׳��쳣
 *
 * @param string $error �쳣��Ϣ
 */
function throw_exception($error){
    if (IGNORE_EXCEPTION){
        showMessage($error,'','exception');
    }else{
        exit();
    }
}


/**
 * ȡ��ϵͳ������Ϣ
 *
 * @param string $key ȡ���±�ֵ
 * @return mixed
 */
function C($key){

    /*if (strpos($key,'.')){
        $key = explode('.',$key);
        if (isset($key[2])){
            return $GLOBALS['setting_config'][$key[0]][$key[1]][$key[2]];
        }else{
            return $GLOBALS['setting_config'][$key[0]][$key[1]];
        }
    }else{
        return $GLOBALS[$config][$key];
    }*/
}

/**
 * �����Ϣ
 *
 * @param string $msg �����Ϣ
 * @param string/array $url ��ת��ַ ��$urlΪ����ʱ���ṹΪ array('msg'=>'��ת��������','url'=>'��ת����');
 * @param string $show_type �����ʽ Ĭ��Ϊhtml
 * @param string $msg_type ��Ϣ���� succ Ϊ�ɹ���errorΪʧ��/����
 * @param string $is_show  �Ƿ���ʾ��ת���ӣ�Ĭ����Ϊ1����ʾ
 * @param int $time ��תʱ�䣬Ĭ��Ϊ2��
 * @return string �ַ������͵ķ��ؽ��
 */
function showMessage($msg,$url='',$show_type='html',$msg_type='succ',$is_show=1,$time=2000){
    /**
     * ���Ĭ��Ϊ�գ�����ת����һ������
     */
    $url = ($url!='' ? $url : getReferer());

    $msg_type = in_array($msg_type,array('succ','error')) ? $msg_type : 'error';

    /**
     * �������
     */
    switch ($show_type){
        case 'json':
            $return = '{';
            $return .= '"msg":"'.$msg.'",';
            $return .= '"url":"'.$url.'"';
            $return .= '}';
            echo $return;
            break;
        case 'exception':
            echo '<!DOCTYPE html>';
            echo '<html>';
            echo '<head>';
            echo '<meta http-equiv="Content-Type" content="text/html; charset='.CHARSET.'" />';
            echo '<title></title>';
            echo '<style type="text/css">';
            echo 'body { font-family: "Verdana";padding: 0; margin: 0;}';
            echo 'h2 { font-size: 12px; line-height: 30px; border-bottom: 1px dashed #CCC; padding-bottom: 8px;width:800px; margin: 20px 0 0 150px;}';
            echo 'dl { float: left; display: inline; clear: both; padding: 0; margin: 10px 20px 20px 150px;}';
            echo 'dt { font-size: 14px; font-weight: bold; line-height: 40px; color: #333; padding: 0; margin: 0; border-width: 0px;}';
            echo 'dd { font-size: 12px; line-height: 40px; color: #333; padding: 0px; margin:0;}';
            echo '</style>';
            echo '</head>';
            echo '<body>';
            echo '<h2>'.$lang['error_info'].'</h2>';
            echo '<dl>';
            echo '<dd>'.$msg.'</dd>';
            echo '<dt><p /></dt>';
            echo '<dd>'.$lang['error_notice_operate'].'</dd>';
            echo '<dd><p /><p /><p /><p /></dd>';
            echo '<dd><p /><p /><p /><p />Copyright 2007-2014 ShopNC, All Rights Reserved '.$lang['company_name'].'</dd>';
            echo '</dl>';
            echo '</body>';
            echo '</html>';
            exit;
            break;
        case 'javascript':
            echo "<script>";
            echo "alert('". $msg ."');";
            echo "location.href='". $url ."'";
            echo "</script>";
            exit;
            break;
        case 'tenpay':
            echo "<html><head>";
            echo "<meta name=\"TENCENT_ONLINE_PAYMENT\" content=\"China TENCENT\">";
            echo "<script language=\"javascript\">";
            echo "window.location.href='" . $url . "';";
            echo "</script>";
            echo "</head><body></body></html>";
            exit;
            break;
        default:
            if (is_array($url)){
                foreach ($url as $k => $v){
                    $url[$k]['url'] = $v['url']?$v['url']:getReferer();
                }
            }
    }
    exit;
}

/**
 * ȡ��һ����Դ��ַ
 *
 * @param
 * @return string �ַ������͵ķ��ؽ��
 */
function getReferer(){
    return empty($_SERVER['HTTP_REFERER'])?'':$_SERVER['HTTP_REFERER'];
}
?>