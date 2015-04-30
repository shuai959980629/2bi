<?php
if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
/**
 *@后台标签管理
 *@version v-2.0
 *@author zhoushuai
 *@copyright 2014-11-10
 */
class Tag extends Admin_Controller{

	
	
    public function __construct()
    {
        parent::__construct();
    } 
	
	public function index() {
	    $this->page_data['title']='邻售商家-标签管理';
        $this->page_data['current']='tag';
        $this->load->model('tag_model','tag');
        
        $where = array('id_parent'=>0);
        $parent=$this->tag->get_tag($where);
        $this->page_data['parent']= $parent;
        /*$where = 'id_parent != 0';
        $child = $this->tag->get_tag($where);
        debug($parent);
        */
        $this->page_data['tag']=$this->tag->get_tag();
        $this->load->view ('tag',$this->page_data);
	}
    
    /**
     * @author zhoushuai
     * @新增宝贝标签
     */
    public function add(){
        $name=trim($this->input->post('name'));
        $id_parent = intval($this->input->post('id_parent'));
        $orders = intval($this->input->post('orders'));
        if(!isset($name)||!isset($id_parent)||empty($orders)){
            $this->errors='标签添加失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('tag_model','tag');
        $where = array('name'=>$name);
        $return = $this->tag->get_tag($where);
        if($return){
           $this->errors='标签名称不可重复，请重新输入！';
           $this->return_status(0, $this->errors);
        }
        $where = array('orders'=>$orders);
        $return = $this->tag->get_tag($where);
        if($return){
           $this->errors='排序编号不可重复，请重新输入！';
           $this->return_status(0, $this->errors);
        }
        $data = array('name'=>$name,'id_parent'=>$id_parent,'orders'=>$orders);
        $res = $this->tag->insert_tag($data);
        if($res){
             $this->return_status(1,'标签添加成功！');
        }else{
           $this->errors='标签添加失败！';
           $this->return_status(0, $this->errors); 
        }
    }
    
    /**
     * @author zhoushuai
     * @删除宝贝标签
     */
    public function delet(){
        $id_tag = intval($this->input->post('id_tag'));
        if(!isset($id_tag)){
            $this->errors='标签删除失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('tag_model','tag');
        $where = array('id_parent'=>$id_tag);
        $res1=$this->tag->get_tag($where);
        if($res1){
            $this->errors='该标签存在子类，请先删除子类！';
            $this->return_status(0, $this->errors);
        }
        $where1 = array('id_tag'=>$id_tag);
        $res2=$this->tag->delete_tag($where1);
        if($res2){
            $res3=$this->tag->delete_tag_cowry($where1);
            if($res3){
                $this->return_status(1,'标签删除成功！');
            }
        }
       $this->return_status(1,'标签删除失败！'); 
    }
    /**
     * @author zhoushuai
     * @修改标签
     */
    public function update(){
        $name=trim($this->input->post('name'));
        $id_parent = intval($this->input->post('id_parent'));
        $id_tag = intval($this->input->post('id_tag'));
        $orders = intval($this->input->post('orders'));
        if(!isset($name)||!isset($id_parent)||!isset($id_tag)||empty($orders)){
            $this->errors='标签修改失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('tag_model','tag');
        $where = array('name'=>$name,'id_tag !='=>$id_tag);
        $return = $this->tag->get_tag($where);
        if($return){
           $this->errors='标签名称不可重复，请重新输入！';
           $this->return_status(0, $this->errors);
        }
        $where = array('orders'=>$orders,'id_tag !='=>$id_tag);
        $return = $this->tag->get_tag($where);
        if($return){
           $this->errors='排序编号不可重复，请重新输入！';
           $this->return_status(0, $this->errors);
        }
                
        $data = array('name'=>$name,'id_parent'=>$id_parent,'orders'=>$orders);
        $where = array('id_tag'=>$id_tag);
        $res = $this->tag->modify_tag($data,$where);
        if($res){
             $this->return_status(1,'标签修改成功！');
        }else{
           $this->errors='标签修改失败！';
           $this->return_status(0, $this->errors); 
        }
    }
	
    /**
     * @author zhoushuai
     * @增加宝贝标签
     */
    public function saveCowryTag(){
        $type=$this->input->post('type');
        $data=$this->input->post('data');
        $uid = intval($this->input->post('uid'));
        $cid = intval($this->input->post('cid'));
        if(empty($data)||empty($uid)||empty($cid)||empty($type)){
            $this->errors='宝贝标签添加失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('cowry_model','cowry');
        $res = $this->cowry->exist_in_cowrys($cid,$uid);
        if(!$res){
            $this->errors='宝贝不存在，标签添加失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('tag_model','tag');
        $tag=json_decode($data);
        $where = 'id_tag IN ('.implode(',', $tag).')';
        $TagName = $this->tag->get_tag_name($where);
        if(!$TagName){
            $this->errors='标签错误，添加失败！';
            $this->return_status(0, $this->errors);
        }
        //先删除以前已经存在的。。。
        $where = array('id_cowry'=>$cid,'owner'=>$uid);
        $this->tag->delete_tag_cowry($where);
        //开始添加标签
        $cowryTAG = array();
        for($i=0;$i<count($tag);$i++){
            $cowryTAG[]=array('id_tag'=>$tag[$i],'id_cowry'=>$cid,'owner'=>$uid);
        }
        $res2 =$this->tag->insert_tag_cowry($cowryTAG);
        if(!$res2){
           $this->errors='宝贝标签添加失败！';
           $this->return_status(0, $this->errors); 
        }
        $this->return_status(1, '宝贝标签添加成功！'); 
    }
}

/* End of file tag.php */
/* Location: ./admin/controllers/tag.php */


























?>