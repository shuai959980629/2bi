<?php
/**
 * @hook钩子的应用
 * @copyright(c) 2013-12-24
 * @author msi
 * @version Id:admin.php
 */


class Admin {

	private $CI;
	private $users;
	private $session_id;
	 
	function Admin()
	{
		$this->CI = & get_instance();
		$this->CI->load->library('session');
	}
	 
	function auth()
	{
		if(in_array($this->CI->uri->segment(1), array('user','files'))){
			return TRUE;
		}
		
		//检查是否登陆
		if($this->init_login() == FALSE){ 
		    $url = 'http://'.$_SERVER['HTTP_HOST'].ADMIN_PATH."user/login";
            echo '<script type="text/javascript">window.location.href="'.$url.'";</script>';
			exit;
		}	
	}
	
	private function init_login(){	
		$sess = $this->CI->session->all_userdata();
	    $this->session_id = $sess['session_id'];
		$admin = $this->get_session_data($this->session_id);
		if(!empty($admin['id_admin'])){
			$this->users = $admin;
			return TRUE;
		}
		return FALSE;
	}
	
	
	private function get_session_data($key){
		$this->CI->load->driver('cache');
		$return = array();
		if($this->CI->cache->memcached->is_supported() === TRUE){
			$cache = $this->CI->cache->memcached->get($key);
			if(!empty($cache[0])){
				return $cache[0];
			}
		}
		return $return;
	}
	
	
}


/* End of file admin.php */