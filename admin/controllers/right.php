<?php
if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
/**
 *@后台管理员功能管理
 *@version v-1.0
 *@author zhoushuai
 *@copyright 2014-06-18
 */
class Right extends Admin_Controller{

	
	
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index() {
        $this->load->model('admin_model','admin');
	    $this->page_data['title']='邻售后台功能管理';
        $this->page_data['current']='right';
        $where = array("r.id_parent"=>0);
        $parent = $this->right->get_right($where);
        $this->page_data['parent']= $parent;
        $where = 'id_parent != 0';
        $child = $this->right->get_right($where);
        $this->page_data['child']= $child;
        $this->load->view ('right',$this->page_data);
	}
    /**
     * @新增管理员权限
     */
    public function add(){
        $this->page_data['title']='邻售后台-新增管理员功能';
        $this->page_data['current']='right';
        $this->page_data['profile']= $this->get_profile();
        $this->load->model('right_model','right');
        $where = array("r.id_parent"=>0);
        $parent = $this->right->get_right($where);
        $this->page_data['parent']= $parent;
        $this->load->view ('right_add',$this->page_data);
    }
    
    /**
     * @新增管理员权限
     */
    public function add_right(){
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        if($this->users['id_profile']!=1){
            $this->return_status(0,'新增管理员功能失败！');
        }
        $data= array(
            'name'=>trim($this->input->post('name')),
            'menu_url'=>trim($this->input->post('url')),
            'icon'=>trim($this->input->post('icon')),
            'orders'=>trim($this->input->post('orders')),
            'roue_char'=>trim($this->input->post('roue_char')),
            'id_parent'=>trim($this->input->post('parent'))
        );
        $this->load->model('right_model','right');    
        $rid = $this->right->insert_right($data);
        if( $rid ){
            $where=array('id_right'=>$rid);
            if($data['id_parent']==0){
                //顶级父类
                $dat = array('id_roue'=>'0:'.$rid);
            }else{
                //功能添加给超级管理员
                $pright=array('id_profile'=>$this->users['id_profile'],'id_right'=>$rid);
                $return = $this->right->insert_pright($pright);
                $dat = array('id_roue'=>'0:'.$data['id_parent'].':'.$rid);
            }
            $this->right->modify_right($dat,$where);
            $this->return_status(1,'新增管理员功能成功！');
        }else{
            $this->return_status(0,'新增管理员功能失败！');
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