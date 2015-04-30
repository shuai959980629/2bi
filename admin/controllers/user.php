<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 *@version v-1.0
 *@author zhoushuai
 *@copyright 2014-06-18
 */
class User extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        
    }
    /**
     * @后台管理员登录
     */
    public function login()
    {   
       
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        //$this->form_validation->set_error_delimiters('<div class="alert alert-error"><span>','</span></div>');
        if($this->input->post('username')){
            $this->form_validation->set_rules('username', '用户名', 'required|min_length[4]');
            $this->form_validation->set_rules('password', '密码', 'required');
            if (false !== $this->form_validation->run()) {
                $username = $this->input->post('username');
                $username = str_replace("'", "", $username);
                $admin = $this->admin_login($username, $this->input->post('password'));
                if ($admin === FALSE) {
                    $this->return_status(0, $this->errors);
                } else {
                    //登录成功更新用户最后一次登录时间
                    $id_admin = $admin['id_admin'];
                    $this->load->model('admin_model','admin');
                    $data = array('last_time' => date('Y-m-d H:i:s', time()));
                    $where = 'id_admin = ' . $id_admin;
                    $this->admin->update_admin($data, $where);
                    header('location:' . $this->url);
                    exit;
                }
                
            } else {
                $this->return_status(0, $this->form_validation->error_string());
            }  
            
        }else{
            $this->page_data['title']='邻售商家管理后台-登录';
            $this->load->view ('login',$this->page_data);
        }  
    }
    
    /**
     * @后台管理员退出登录
     */
    public function logout(){
	 	
	    $this->load->driver('cache');
		$return = array();
		if($this->cache->memcached->is_supported() === TRUE){
			$this->cache->memcached->delete($this->session_id);
		}
		header('location:'.$this->url);
	}
    

}

/* End of file home.php */
/* Location: ./admin/controllers/home.php */
