<?php
namespace classes;
class IFilter
{
    /**
     * @brief �����ַ����ĳ���
     * @param string $str �����Ƶ��ַ���
     * @param int $length ���Ƶ��ֽ���
     * @return string ��:��������ֵ; $str:ԭ�ַ���;
     */
    public static function limitLen($str,$length)
    {

        if($length !== false)
        {
            $count = strlen($str);
            if($count > $length)
            {
                return '';
            }
            else
            {
                return $str;
            }
        }
        return $str;
    }

    /**
     * @brief ���ַ������й��˴���
     * @param  string $str      �����˵��ַ���
     * @param  string $type     ������������ ֵ: int, float, string, text, bool, url
     * @param  int    $limitLen �����������ַ����� , Ĭ�ϲ�����;
     * @return string �����˺���ַ���
     * @note   Ĭ��ִ�е���string���͵Ĺ���
     */
    public static function act($str,$type = 'string',$limitLen = false)
    {
        $str=trim($str);
        if(is_array($str))
        {
            foreach($str as $key => $val)
            {
                $resultStr[$key] = self::act($val, $type, $limitLen);
            }
            return $resultStr;
        }
        else
        {
            switch($type)
            {
                case "int":

                    return intval((int)$str);
                    break;

                case "float":

                    return floatval($str);
                    break;

                case "text":
                    return self::text($str,$limitLen);
                    break;

                case "bool":
                    return (bool)$str;
                    break;

                case "url":
                    return self::clearUrl($str);
                    break;

                case "filename":
                    return self::fileName($str);
                    break;

                default:
                    return self::string($str,$limitLen);
                    break;
            }
        }
    }

    /**
     * @brief  ���ַ��������ϸ�Ĺ��˴���
     * @param  string  $str      �����˵��ַ���
     * @param  int     $limitLen ���������󳤶�
     * @return string �����˺���ַ���
     * @note ��������html��ǩ��php��ǩ�Լ������������
     */
    public static function string($str,$limitLen = false)
    {
        $str = trim($str);
        $str = self::limitLen($str,$limitLen);
        $str = htmlspecialchars($str,ENT_NOQUOTES);
        return self::addSlash($str);
    }

    /**
     * @brief ���ַ���������ͨ�Ĺ��˴���
     * @param string $str      �����˵��ַ���
     * @param int    $limitLen �޶��ַ������ֽ���
     * @return string �����˺���ַ���
     * @note �����ڲ�����:<script,<iframe�ȱ�ǩ���й���
     */
    public static function text($str,$limitLen = false)
    {
        $str = self::limitLen($str,$limitLen);
        $str = trim($str);

        require_once(dirname(__FILE__)."/htmlpurifier/HTMLPurifier.standalone.php");
        $cache_dir=IWeb::$app->getRuntimePath()."htmlpurifier/";

        if(!file_exists($cache_dir))
        {
            IFile::mkdir($cache_dir);
        }
        $config = HTMLPurifier_Config::createDefault();

        //���� ����flash
        $config->set('HTML.SafeEmbed',true);
        $config->set('HTML.SafeObject',true);
        $config->set('Output.FlashCompat',true);

        //���� ����Ŀ¼
        $config->set('Cache.SerializerPath',$cache_dir); //����cacheĿ¼

        //����<a>��target����
        $def = $config->getHTMLDefinition(true);
        $def->addAttribute('a', 'target', 'Enum#_blank,_self,_target,_top');

        //���Ե�����<script>��<i?frame>��ǩ��on�¼�,css��js-expression��import��js��Ϊ��a��js-href
        $purifier = new HTMLPurifier($config);
        return self::addSlash($purifier->purify($str));
    }

    /**
     * @brief ����ת��б��
     * @param string $str Ҫת����ַ���
     * @return string ת�����ַ���
     */
    public static function addSlash($str)
    {
        if(is_array($str))
        {
            $resultStr = array();
            foreach($str as $key => $val)
            {
                $resultStr[$key] = self::addSlash($val);
            }
            return $resultStr;
        }
        else
        {
            return addslashes($str);
        }
    }

    /**
     * @brief ����ת��б��
     * @param string $str Ҫת����ַ���
     * @return string ת�����ַ���
     */
    public static function stripSlash($str)
    {
        if(is_array($str))
        {
            $resultStr = array();
            foreach($str as $key => $val)
            {
                $resultStr[$key] = self::stripSlash($val);
            }
            return $resultStr;
        }
        else
        {
            return stripslashes($str);
        }
    }

    /**
     * @brief ����ļ��Ƿ��п�ִ�еĴ���
     * @param string  $file Ҫ�����ļ�·��
     * @return boolean �����
     */
    public static function checkHex($file)
    {
        $resource = fopen($file, 'rb');
        $fileSize = filesize($file);
        fseek($resource, 0);
        // ��ȡ�ļ���ͷ����β��
        if ($fileSize > 512)
        {
            $hexCode = bin2hex(fread($resource, 512));
            fseek($resource, $fileSize - 512);
            $hexCode .= bin2hex(fread($resource, 512));
        }
        // ��ȡ�ļ���ȫ������
        else
        {
            $hexCode = bin2hex(fread($resource, $fileSize));
        }
        fclose($resource);
        /* ƥ��16�����е� <% (  ) %> */
        /* ƥ��16�����е� <? (  ) ?> */
        /* ƥ��16�����е� <script  /script>  */
        if (preg_match("/(3c25.*?28.*?29.*?253e)|(3c3f.*?28.*?29.*?3f3e)|(3C534352495054.*?2F5343524950543E)|(3C736372697074.*?2F7363726970743E)/is", $hexCode))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * ����URL��ַ���е�Σ���ַ�����ֹXSSע�빥��
     * @param string $url
     * @return string
     */
    public static function clearUrl($url)
    {
        return str_replace(array('\'','"','&#',"\\"),'',$url);
    }

    /**
     * @brief �����ļ�����
     * @param string $string �����ַ���
     * @return string
     */
    public static function fileName($string)
    {
        return str_replace(array('./','../','..'),'',$string);
    }
}