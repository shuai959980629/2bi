<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 * @专题活动
 * @author zhoushuai
 * @date 2014-11-07 16:30
 */
class Theme extends Theme_Controller 
{


    public function __construct()
    {

        parent::__construct();
        //$this->lang->load('mark');
        //$this->load->library('form_validation');
    }
    
    /**
     * @author zhoushuai
     * @获取专题活动列表
     */
    public function theme_list(){
        $list=parent::get_theme_list();
        if(FALSE !== $list){
            $this->return_client(1,$list);
        }
        $this->return_client(0,null,$this->errors);
    }
    
    /**
     * @author zhoushuai
     * @专题活动宝贝列表
     */
     public function theme_cowry(){
         $page = $this->params['page'] ? $this->params['page'] : 1;
         $tid = intval($this->params['tid'])?intval($this->params['tid']):false;
         if(!$tid){
            $this->errors = "请传入需要查询的专题活动id！";
         }else{
            $result = parent::get_theme_cowry($this->params['tid'],$page);
            if(FALSE !== $result){
                $this->return_client(1,$result);
            }
         }
         $this->return_client(0,null,$this->errors );
    }
    
	/**
     * @author zhoushuai
     * @专题活动--推荐自己宝贝，待后台审核
     */
	public function recom_cowry(){
		$tid = intval($this->params['tid'])?intval($this->params['tid']):false;
		$cid = !empty($this->params['cid'])?$this->params['cid']:false;
		if($tid && $cid){
			$result = parent::recom_self_cowry($tid,$cid);
            if(FALSE !== $result){
                $this->return_client(1,$result,'推荐成功，请等待后台审核！');
            }
		}else{
			$this->errors = '传入的参数宝贝id或专题id有误，执行中断！';
		}
		$this->return_client(0,null,$this->errors );
	
	}

}

/* End of file theme.php */
/* Location: ./service/controllers/theme.php */





?>