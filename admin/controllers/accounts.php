<?php
if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
/**
 *@后台管理员角色管理
 *@version v-1.0
 *@author zhoushuai
 *@copyright 2014-06-18
 */
class Accounts extends Admin_Controller{

	
	
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index() {
        $this->load->model('admin_model','admin');
	    $this->page_data['title']='邻售后台帐号管理';
        $this->page_data['current']='accounts';
        $id_admin = $this->users['id_admin'];
        $where = "id_admin != {$id_admin}";
        $id_profile = $this->users['id_profile'];
        if($id_profile!=1){
            $where.=" AND id_admin != 1";
        }
        $this->page_data['adminList']=$this->admin->admin_list($where);
        $this->load->view ('accounts',$this->page_data);
	}
    /**
     * @新增管理员
     */
    public function add(){
        $this->page_data['title']='邻售后台-新增管理员';
        $this->page_data['current']='accounts';
        $this->page_data['profile']= $this->get_profile();
        $this->load->view ('accounts_add',$this->page_data);
    }
    
    /**
     * @新增管理员账户 
     */
    public function add_admin(){
        $data= array(
            'id_profile'=>$this->input->post('profile'),
            'realname'=>$this->input->post('realname'),
            'username'=>$this->input->post('username'),
            'password'=>$this->md5pwd('123456'),//默认密码123456 。管理员以后自己修改
            'department'=>$this->input->post('department'),
            'comment'=>$this->input->post('comment'),
            'last_time'=>date('Y-m-d H:i:s', time()),
            'created'=>date("Y-m-d H:i:s", time())
        );
        $this->load->model('admin_model','admin');
        $where = array('username'=>$this->input->post('username'));
        $return = $this->admin->query_admin($where);
        if($return){
           $this->errors='管理员账号名称已经存在。不能重复添加！';
           $this->return_status(0, $this->errors);
        }       
        $result = $this->admin->add_admin($data);
        if( $result ){
            $this->return_status(1,'账户添加成功！');
        }else{
            $this->return_status(0,'账户添加失败！');
        }
    }
    
    /**
     * @删除管理员
     */
    public function deladmin(){
        $id_admin=$this->input->post('id_admin');
        if(!isset($id_admin)){
            $this->errors='操作失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('admin_model','admin');
        $where = "id_admin = ".$id_admin;
        $result = $this->admin->deladmin($where);
        if( $result ){
            $this->return_status(1,'操作成功！');
        }else{
            $this->return_status(0,'操作失败！');
        }
        
        
    }
    
    
    
    
    /**
     * @author zhoushuai
     * @获取管理员角色
     */
    private function get_profile(){
        $this->load->model('right_model','right');
        $id_profile = $this->users['id_profile'];
        $where = "id_profile != {$id_profile}";
        if($id_profile!=1){
            $where.=" AND id_profile != 1";
        }
        $profile=$this->right->get_profile($where);
        return $profile; 
    }
    
    
    
    
    
 }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 ?>