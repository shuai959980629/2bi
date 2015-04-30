<?php
if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
/**
 *@后台首页
 *@version v-1.0
 *@author zhoushuai
 *@copyright 2014-06-18
 */
class Home extends Admin_Controller{

	
	
    public function __construct()
    {
        parent::__construct();
    } 
	
	public function index() {
	    $this->page_data['title']='邻售商家管理后台';
        $this->page_data['current']='home';
        $this->load->view ('home',$this->page_data);
	}
    
    public function passwd(){
        $this->page_data['title']='邻售商家管理-用户密码修改';
        $this->page_data['current']='home';
        $this->load->view ('passwd',$this->page_data);
    }
    
    
    /**
     * 修改密码
     */
    public function updatepwd(){
        $opasswd = trim($this->input->post('opasswd'));
        $opwd = $this->md5pwd($opasswd);
        if($opwd !== $this->users['password']){
            $this->return_status(0,'原密码输入错误！');
        }
        $npasswd = trim($this->input->post('npasswd'));
        $rnpasswd =trim($this->input->post('rnpasswd'));
        if(empty($npasswd)|| $npasswd!==$rnpasswd){
            $this->return_status(0,'新密码输入错误！');
        }
        $id_admin = $this->users['id_admin'];
        $this->load->model('admin_model','admin');
        $data = array(
            'password'=>$this->md5pwd($npasswd),
            'last_time' => date('Y-m-d H:i:s', time())
        );
        $where = 'id_admin = ' . $id_admin;
        $res = $this->admin->update_admin($data, $where);
        if($res){
            $this->return_status(0,'密码修改成功！');
        }else{
            $this->return_status(0,'密码修改失败！');
        }  
    }
    
    
    
	
}

/* End of file home.php */
/* Location: ./admin/controllers/home.php */