<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 哔哔相关接口
 * 
 * @author jxy
 * @date 2013-11-05 13:30
 */
class Bibi extends Bibi_Controller {
	
	
	public function __construct(){
		
		parent::__construct();
		
		$this->lang->load('bibi');
        $this->load->library('form_validation');
	}

	/**
	 * 添加哔哔
	 */
	public function add_bibi(){

		if(FALSE === parent::add_modify_bibi()){
			parent::return_client(0,null,$this->errors);
		}else {
			parent::return_client(1,NULL,$this->lang->line('bb_add_success'));
		}
		
	}
	

	/**
	 * 取得哔哔
	 */
	public function get_bibi(){
		
		$result = parent::bibi_dettail();
		parent::return_client(1,$result);
		
	}
	
	
	/**
	 * 编辑哔哔
	 */
	public function modify_bibi(){
		
		if(empty($this->params['bid'])){
			parent::return_client(0,null,$this->lang->line('request_param_errors'));
		}else{
			if(FALSE !== parent::add_modify_bibi($this->params['bid'])){
				parent::return_client(1);
			}
		}
		parent::return_client(0,null,$this->errors);
		
	}
	
	
	/**
	 * 取得哔哔列表
	 * 未开发：根据距离获取
	 */
	public function get_bblist(){
		
		$list = $this->bblist();
		if(FALSE !== $list){
			$this->return_client(1,$list);
		}
		$this->return_client(0,null,$this->errors);
		
	}
	
	
	/**
	 * 成员加入
	 */
	public function add_member(){
		
		$result = parent::member_management('join');
		if(FALSE !== $result){
			parent::return_client(1);
		}
		parent::return_client(0,null,$this->errors);
		
	}
	
	
	/**
	 * 退出哔哔
	 */
	public function logout_member(){
		
		$result = parent::member_management('out');
		if(FALSE !== $result){
			parent::return_client(1);
		}
		parent::return_client(0,null,$this->errors);
		
	}
	
	
	/**
	 * 关闭哔哔
	 */
	public function dissolve_bibi(){
		
		if(!empty($this->params['bid'])){
			$result = parent::close_bibi();
			if(FALSE !== $result){
				parent::return_client(1);
			}
		}
		parent::return_client(0,null,$this->errors);
		
	}
	
	
	/**
	 * 获取宝贝房
	 */
	public function get_bbcowry(){
		
		if(!empty($this->params['bid'])){
			$result = $this->get_cowrylist();
			if(FALSE !== $result){
				parent::return_client(1,$result);
			}
		}
		parent::return_client(0,null,$this->errors);
		
	}
	
	
	/**
	 * 获取哔哔成员
	 */
	public function get_memberlist(){
		
		if(!empty($this->params['bid'])){
			$result = parent::get_memberlist();
			if(FALSE !== $result){
				parent::return_client(1,$result);
			}
		}
		parent::return_client(0,null,$this->errors);
		
	}
	
	
	/**
	 * 禁言或解除禁言
	 */
	public function shut_message(){
		
		$result = parent::member_management('shut');
		if(FALSE !== $result){
			parent::return_client(1);
		}
		parent::return_client(0,null,$this->errors);
		
	}
	
	
	/**
	 * 获取禁言列表
	 */
	public function get_shutlist(){
		
		if(!empty($this->params['bid'])){
			$result = parent::get_memberlist(0);
			if(FALSE !== $result){
				parent::return_client(1,$result);
			}
		}
		parent::return_client(0,null,$this->errors);
		
	}
	
	
	/**
	 * 获取聊天历史记录
	 */
	public function get_historymsg()
    {
        if( $this->_validate_history() == FALSE){
            parent::return_client(0,NULL,strip_tags($this->errors));
        }
        $result = parent::historymsg($this->filter_params);

        if( $result ){
            parent::return_client(1,$result,NULL);
        }else{
            parent::return_client(0,NULL,$this->lang->line('bb_history_error'));
        }

    }
    
    
	/**
	 * 获取聊天历史记录 数据验证
	 */
    private function _validate_history()
    {
        if($this->form_validation->run('historymsg',$this->params) === FALSE){
            $this->errors = $this->form_validation->error_string();
            return FALSE;
        }else{
            $this->filter_params = $this->params;
            //是否已登录
            if( !$this->token['uid'] ){
                $this->errors = $this->lang->line('bb_history_login');
                return FALSE;
            }
            if( empty($this->params['page']) ){
                $this->filter_params['page'] = 1;
            }
            return TRUE;
        }
    }	
	
	
	/**
	 * 获取参与的列表
	 */
	public function get_joinlist()
    {
        if( $this->_validate_joinlist() == FALSE){
            parent::return_client(0,NULL,strip_tags($this->errors));
        }
        $list = parent::joinlist($this->token['uid'],$this->filter_params['page']);
        if( $list ){
            parent::return_client(1,$list,NULL);
        }else{
            parent::return_client(0,NULL,$this->errors ? strip_tags($this->errors) : $this->lang->line('bb_joinlist_fail'));
        }
    }
    
    
	/**
	 * 获取参与的列表 数据验证
	 */
    private function _validate_joinlist()
    {
        if($this->form_validation->run('bbjoinlist',$this->params) === FALSE){
            $this->errors = $this->form_validation->error_string();
            return FALSE;
        }else{
            $this->filter_params = $this->params;
            if( empty($this->params['page']) )
                $this->filter_params['page'] = 1;
            return TRUE;
        }
    }



}

/* End of file Bibi.php */
/* Location: ./service/controllers/bibi.php */