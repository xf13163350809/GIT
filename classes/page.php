<?php
/**
 * ��ҳ������
 * User: xufeng
 * Date: 15-2-13
 * Time: ����3:29
 */
class IPaging
{
    private $fields;
    private $dbo;
    private $sql;
    private $rows;
    public $index;//��ǰҳ��
    public $totalpage;//��ҳ��
    public $pagesize;//ÿҳ������
    public $firstpage;//��һҳ
    public $lastpage;//���һҳ
    public $pagelength;//Ҫչʾ��ҳ����
    /**
     * @brief ���캯��
     * @param string $sql Ҫ��ҳ��SQL���
     * @param int $pagesize ÿҳ�ļ�¼
     * @param int $pagelength չʾpageBar��ҳ��
     */
    public function __construct($sql="",$pagesize=20,$pagelength=10)
    {
        $this->pagesize=$pagesize;
        $this->pagelength=$pagelength;
        $this->dbo=getDB();
        if($sql!="")
        {
            $this->setSql($sql);
        }
    }
    /**
     * @brief ����Ҫ��ҳ��SQl���
     * @param string $sql SQL���
     */
    public function setSql($sql)
    {
        $this->sql=$sql;
        if(strpos($sql,'GROUP BY') === false)
        {
            $endstr = strstr($this->sql,'from');
            $endstr = preg_replace('/^(.*)order\s+by.+$/i','$1',$endstr);
            $count=$this->dbo->query("select count(*) as total ".$endstr);
        }
        else
        {
            $count=$this->dbo->query("select count(*) as total from (".$sql.") as IPaging");
        }

        $this->rows=isset($count[0]['total']) ? $count[0]['total'] : 0;
        $this->firstpage=1;
        $this->totalpage=floor(($this->rows-1)/$this->pagesize)+1;
        $this->lastpage=$this->firstpage+$this->totalpage-1;
        if($this->lastpage>$this->totalpage)$this->lastpage=$this->totalpage;
    }
    /**
     * @brief �õ���ӦҪ��ѯ��ҳ����������
     * @param int  $pageҪ��ѯ��ҳ��
     * @return Array ����
     */
    public function getPage($page)
    {
        $page=intval($page);
        $this->index=$page;
        if($page<=0)$this->index=1;
        if($this->totalpage>0)
        {
            if($page>$this->totalpage)$this->index=$this->totalpage;
            $this->firstpage=$this->index-floor($this->pagelength/2);
            if($this->firstpage<=0)$this->firstpage=1;
            $this->lastpage=$this->firstpage+$this->pagelength-1;
            if($this->lastpage>$this->totalpage)
            {
                $this->lastpage=$this->totalpage;
                $this->firstpage=($this->totalpage-$this->pagelength+1)>1?$this->totalpage-$this->pagelength+1:1;
            }
            return $this->dbo->query($this->sql." limit ".($this->index-1)*$this->pagesize.",".($this->pagesize));
        }
        else return array();
    }
    /**
     * @brief ��ȡ��ǰ��ҳ��
     * @return int ��ҳ��
     */
    public function getIndex()
    {
        return $this->index;
    }
    /**
     * @brief ��ȡ��ҳ����
     * @return int ��ҳ����
     */
    public function getTotalPage()
    {
        return $this->totalpage;
    }
    /**
     * @brief ����չʾ�ķ�ҳ����
     * @return int ��ҳ����
     */
    public function setPageLength($legth)
    {
        $this->pagelength=$legth;
    }
    /**
     * @brief ��ȡչʾ�ķ�ҳ����
     * @return int ��ҳ����
     */
    public function getPageLength()
    {
        return $this->pagelength;
    }
    /**
     * @brief ����ÿҳ����������
     * @return int ��������
     */
    public function setPageSize($size)
    {
        $this->pagesize  = $size;
        $this->totalpage = floor(($this->rows-1)/$this->pagesize)+1;
    }
    /**
     * @brief �õ���ҳҪչʾ����������
     * @return int ��������
     */
    public function getPageSize()
    {
        return $this->pagesize;
    }
    /**
     * @brief ��ǰpageBar�ĵ�һҳ
     * @return int ��ǰpageBar�ĵ�һҳ
     */
    public function getFirstPage()
    {
        return $this->firstpage;
    }
    /**
     * @brief ��ǰpageBar������һҳ��ҳ��
     * @return int ��ǰpageBar���һҳ��ҳ��
     */
    public function getLastPage()
    {
        return $this->lastpage;
    }
    /**
     * @brief ȡ��pageBar
     * @param string $url URL��ַ��һ��Ϊ�գ�
     * @param string $attrs URL��Ӳ���
     * @return string pageBar�Ķ�ӦHTML����
     */
    public function getPageBar($url='', $attrs='')
    {
        $attr = '';
        if($attrs != '')
        {
            $ajax_attr = " {$attrs} ";
        }
        $flag = false;
        if($url=='')
        {
            $flag = true;
            $url = IUrl::getUri();
            $url = preg_replace('/page=\d?&/','',$url);
            $url = preg_replace('/(\?|&|\/)page(\/|=).*/i','',$url);
            $mark = '=';
            if(strpos($url,'?') !== false)
                $index = '&page';
            else
                $index = '?page';
        }
        else
        {
            $flag = false;
            $index='';
            $mark='';
        }

        $baseUrl = "{$url}{$index}{$mark}";
        $baseUrl = IFilter::act($baseUrl,'text');

        $attr = str_replace('[page]',1,$attrs);
        $href = $baseUrl.($flag?1:'');
        //$tem="<div class='pages_bar'><a href='{$href}' {$attr}>��ҳ</a>";
        $tem="<div class='pages_bar'>";

        $attr = str_replace('[page]',$this->getIndex()-1,$attrs);
        $href = $baseUrl.($flag?$this->getIndex()-1:'');
        if($this->index>1)$tem.="<a href='{$href}' {$attr}> < </a>";

        for($i=$this->firstpage;$i<=$this->lastpage;$i++)
        {
            $attr = str_replace('[page]',$i,$attrs);
            $href = $baseUrl.($flag?$i:'');
            if($i==$this->index)
            {
                $tem.="<a class='current_page' href='{$href}' {$attr}>{$i}</a>";
            }
            else
            {
                $tem.="<a href='{$href}' {$attr}>{$i}</a>";
            }
        }

        $attr = str_replace('[page]',$this->getIndex()+1,$attrs);
        $href = $baseUrl.($flag?$this->getIndex()+1:'');
        if($this->index<$this->totalpage)$tem.="<a href='{$href}' {$attr}> > </a>";

        if($this->totalpage==0)$this->index=1;
        $attr = str_replace('[page]',$this->totalpage,$attrs);
        $href = $baseUrl.($flag?$this->totalpage:'');
        //var_dump($this->firstpage,$this->lastpage,$this->totalpage);exit;
        //return $tem."<a href='{$href}' {$attr}>βҳ</a><span>��ǰ��{$this->index}ҳ/��{$this->totalpage}ҳ</span></div>";
        $select = '';
        for($i=1;$i<=$this->totalpage;$i++){
            $select .= '<option value="'.$i.'">'.$i.'</option>';
        }
        $select = "<span>�� �� <select id='page_bar_select' style='height:18px; width:40px;'><option value=''>&nbsp;</option>{$select}</select> ҳ <input class='tuik_btn' type='button' onclick="."page_select_subm('{$baseUrl}');"." value='ȷ��'></span>";
        return $tem."<span>��{$this->totalpage}ҳ</span>{$select}</div>";
    }
}
?>
