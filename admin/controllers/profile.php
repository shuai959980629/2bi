<?php
if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
/**
 *@后台管理员角色管理
 *@version v-1.0
 *@author zhoushuai
 *@copyright 2014-06-18
 */
class Profile extends Admin_Controller{

	
	
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index() {
	    $this->page_data['title']='邻售后台权限管理';
        $this->page_data['current']='profile';
        $this->page_data['profile']= $this->get_profile();
        $this->page_data['right_list']= $this->get_right_list();
        $this->load->view ('profile',$this->page_data);
	}
    private function get_right_list(){
        $this->load->model('right_model','right');
        //角色权限关系profile_right 角色权限right
        $where = 'id_parent != 0';
        $child = $this->right->get_right($where);
        $where = array("r.id_parent"=>0);
        $parent = $this->right->get_right($where);
        $tree =$this->list_to_tree($child,$parent);
        return $tree;
    }
    
    
    /**
     * @author zhoushuai
     * @增加管理员角色
     */
    public function add(){
        $name=trim($this->input->post('name'));
        $role = trim($this->input->post('role'));
        if(!isset($name)||!isset($role)){
            $this->errors='管理员角色添加失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('right_model','right');
        $where = array('name'=>$name);
        $return = $this->right->get_profile($where);
        if($return){
           $this->errors='管理员角色已经存在。不能重复添加！';
           $this->return_status(0, $this->errors);
        }
        $data = array('name'=>$name,'role'=>$role,'created' => date("Y-m-d H:i:s", time()));
        $res = $this->right->add_profile($data);
        if($res){
             $this->return_status(1,'管理员角色添加成功！');
        }else{
           $this->errors='管理员角色添加失败！';
           $this->return_status(0, $this->errors); 
        }
    }
    
    /**
     * @author zhoushuai
     * @删除管理员角色
     */
    public function delete(){
        $id_profile=$this->input->post('id_profile');
        if(!isset($id_profile)){
            $this->errors='删除失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('admin_model','admin');
        $where = "a.id_profile = {$id_profile}";
        $data = $this->admin->query_admin($where);
        if($data){
            $this->errors='该角色已经与管理员绑定，无法删除！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('right_model','right');
        $where = "id_profile = {$id_profile}";
        $this->right->delete_profile_right($where);
        $res = $this->right->delete_profile($where);
        if($res){
             $this->return_status(1,'删除成功！');
        }else{
           $this->errors='删除失败！';
           $this->return_status(0, $this->errors); 
        }  
    }
    
    /**
     * @author zhoushuai
     * @增加(编辑)管理员角色的权限
     */
    public function add_right(){
        $id_profile=$this->input->post('id_profile');
        $rid = $this->input->post('rid');
        if(!isset($id_profile)|| !isset($rid)){
            $this->errors='操作失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('right_model','right');
        $where = "id_profile = {$id_profile}";
        $this->right->delete_profile_right($where);
        $ridStr = implode(',',$rid);
        $where = "id_right in ({$ridStr})";
        $res = $this->right->get_right($where);
        $parent = array();
        $child = array();
        foreach($res as $key=>$val){
            if($val['id_parent']==0){
                $parent[] = $val['id_right'];
            }else{
                $child[] = $val['id_right'];
            }
        }
        $pidStr = implode(',',$parent);
        $where = "id_parent in ({$pidStr})";
        $children =$this->right->get_right($where);
        foreach($children as $key =>$val){
            array_push($child,$val['id_right']);
        }
        for($i=0;$i<count($child);$i++){
            $right[]=array('id_profile'=>$id_profile,'id_right'=>$child[$i]);
        }
        $return = $this->right->insert_profile_right($right);
        if($return){
             $this->return_status(1,'操作成功！');
        }else{
           $this->errors='操作失败！';
           $this->return_status(0, $this->errors); 
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
    
    
    /**
     * @author zhoushuai
     * @获取权限列表
     */
    public function getRight(){
        $id_profile=$this->input->post('id_profile');
        if(!isset($id_profile)){
            $this->errors='操作失败！';
            $this->return_status(0, $this->errors);
        }      
        $right = $this->get_menu($id_profile);
        $this->page_data['page_type']='profile';
        $this->page_data['right_list'] = $right;
        $this->page_data['id_profile'] = $id_profile;
        echo $this->load->view ('lists',$this->page_data);
       
    }
    
    /**
     * @author zhoushuai
     * @删除权限
     */
     public function delRight(){
        $id_profile=$this->input->post('id_profile');
        $id_right = $this->input->post('id_right');
        if(!isset($id_profile)|| !isset($id_right)){
            $this->errors='删除失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('right_model','right');
        $rightList = $this->right->get_right_list(array("id_profile"=>$id_profile,'id_parent'=>$id_right));
        foreach($rightList as $Key=>$val){
            $right[] = $val['id_profile_right']; 
        }
        $prid = implode(',',$right);
        if(!empty($prid)){
            $where = "id_profile_right in ({$prid})";
            $res = $this->right->delete_profile_right($where);
        }
        $this->return_status(1,'操作成功！');
     }
    
    
    
    
    
    
    
    
    
    
    
    
 }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 ?>