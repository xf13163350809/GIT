<?php
/**
 * ���ݴ���
 * User: xufeng
 * Date: 15-2-10
 * Time: ����1:55
 */
namespace classes;
class IModel
{
    //���ݿ��������
    private $db = NULL;

    //���ݱ�����
    private $tableName = '';

    //Ҫ���µı�����,key:��Ӧ���ֶ�; value:����;
    private $tableData = array();

    /**
     * @brief ���캯��,�������ݿ����
     * @param string $tableName ������(��������ʱ�Զ��ŷָ�,�磺user,goods);
     */
    public function __construct($tableName)
    {
        $this->db = getDB();
        $tablePre = isset($GLOBALS['config']['DB']['DB_PREFIX']) ? $GLOBALS['config']['DB']['DB_PREFIX'] : '';

        //�����
        if(stripos($tableName,','))
        {
            $tables = explode(',',$tableName);
            foreach($tables as $val)
            {
                if($this->tableName != '')
                    $this->tableName .= ',';

                $this->tableName .= $tablePre.trim($val);
            }
        }

        //������
        else
        {
            $this->tableName = $tablePre.$tableName;
        }
    }

    /**
     * @brief ����Ҫ���µı�����
     * @param array $data key:�ֶ���; value:�ֶ�ֵ;
     */
    public function setData($data)
    {
        if(is_array($data))
            $this->tableData = $data;
        else
            return false;
    }

    /**
     * @brief ����
     * @param  string $where ��������
     * @param  array  $except ����ͨ������ʽ(keyֵ)
     * @return int or bool int:Ӱ�������; bool:false����
     */
    public function update($where,$except=array(),$flag=false)
    {

        $except = is_array($except) ? $except : array($except);
        //��ȡ��������
        $tableObj  = $this->tableData;
        $updateStr = '';
        $where     = (strtolower($where) == 'all') ? '' : ' WHERE '.$where;
        foreach($tableObj as $key => $val)
        {
            if($updateStr != '') $updateStr.=' , ';
            if(!in_array($key,$except)){
                $updateStr.= '`'.$key.'` = \''.$val.'\'';
            }else{
                $updateStr.= '`'.$key.'` = '.$val;
            }
        }
        $sql = 'UPDATE '.$this->tableName.' SET '.$updateStr.$where;
echo $sql;
        return $this->db->query($sql);
    }

    /**
     * @brief ���
     * @return int or bool int:������Զ�����ֵ bool:false����
     */
    public function add()
    {
        //��ȡ���������
        $tableObj = $this->tableData;

        $insertCol = array();
        $insertVal = array();
        foreach($tableObj as $key => $val)
        {
            $insertCol[] = '`'.$key.'`';
            $insertVal[] = '\''.$val.'\'';
        }
        $sql = 'INSERT INTO '.$this->tableName.' ( '.join(',',$insertCol).' ) VALUES ( '.join(',',$insertVal).' ) ';

        return $this->db->query($sql);
    }

    /**
     * @brief ɾ��
     * @param string $where ɾ������
     * @return int or bool int:ɾ���ļ�¼���� bool:false����
     */
    public function del($where)
    {
        $where = (strtolower($where) == 'all') ? '' : ' WHERE '.$where;
        $sql   = 'DELETE FROM '.$this->tableName.$where;
        return $this->db->query($sql);
    }

    /**
     * @brief ��ȡ��������
     * @param string $where ��ѯ����
     * @param array or string $cols ��ѯ�ֶ�,֧�������ʽ,��array('cols1','cols2')
     * @return array ��ѯ���
     */
    public function getObj($where = false,$cols = '*',$orderBy='',$desc='')
    {
        $result = $this->query($where,$cols,$orderBy,$desc,1);

        var_dump($result);
        if(empty($result))
        {
            return array();
        }
        else
        {
            if(is_array($result[0])&&$cols!=='*'&&strpos($cols,',')==false){

                return $result[0][0];
            }

            return $result[0];
        }
    }

    /**
     * @brief ��ȡ��������
     * @param string $where ��ѯ����
     * @param array or string $cols ��ѯ�ֶ�,֧�������ʽ,��array('cols1','cols2')
     * @param array or string $orderBy �����ֶ�
     * @param array or string $desc ����˳�� ֵ: DESC:����; ASC:����;
     * @param array or int $limit ��ʾ�������� Ĭ��(500)
     * @return array ��ѯ���
     */
    public function query($where=false,$cols='*',$orderBy=false,$desc='DESC',$limit=10)
    {
        //�ֶ�ƴ��
        if(is_array($cols))
        {
            $colStr = join(',',$cols);
        }
        else
        {
            $colStr = ($cols=='*' || !$cols) ? '*' : $cols;
        }

        $sql = 'SELECT '.$colStr.' FROM '.$this->tableName;

        //����ƴ��
        if($where != false) $sql.=' WHERE '.$where;

        //����ƴ��
        if($orderBy != false)
        {
            $sql.= ' ORDER BY '.$orderBy;
            $sql.= (strtoupper($desc) == 'DESC') ? ' DESC ':' ASC ';
        }

        //����ƴ��
        if($limit != 'all')
        {
            $limit = intval($limit);
            $limit = $limit ? $limit : 500;
            $sql.=' limit ' . $limit;
        }
        echo $sql.'<br>';
        return $this->db->query($sql);
    }
}
?>