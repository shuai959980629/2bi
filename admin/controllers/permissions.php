<?php if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
/**
 *@邻售商家商户管理-商户权限
 *@version v-1.0
 *@author zhoushuai
 *@copyright 2014-06-18
 */
class Permissions extends Admin_Controller{

	
	
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index() {
	    $this->page_data['title']='邻售商家商户管理-商户权限';
        $this->page_data['current']='permissions';
        $this->get_permissions(1,'');
        $this->load->view ('permissions',$this->page_data);
	} 
    
    /**
     * @获取商户权限列表
     * @author zhoushuai
     * @param int  offset ：页码
     * @param int  page ：条数
     * @param string  where:查询条件
     */
    public function get_permissions($offset,$where,$page=0){
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        //每页显示数量
        $page = $page ? $page : 8;
        $this->load->model('user_model','user');
        //商户权限列表
        $permissions_list=$this->user->get_permissions_list($where,$page,$page*($offset-1));
        //获取商户权限总数
        $permissions_count = count($this->user->get_permissions_list($where,0,0));
        //分页代码
        $page_html = $this->get_page($permissions_count, $offset, 'permissions_list_page','method',$page);
        $this->page_data['permissions_list'] = $permissions_list;
        $this->page_data['page_html'] = $page_html;
        $this->page_data['page_type']='permissions';
    }
    
    
    
    /**
     * @获取商户权限列表分页
     * @author zhoushuai
     * @param int  offset ：页码
     * @param int  page ：条数
     * @param string  where:查询条件
     */
    public function list_permissions(){
        $offset = $this->input->post('offset') ? $this->input->post('offset') : 1;
        $this->get_permissions($offset,'');
        echo $this->load->view ('lists',$this->page_data);
    }
    
    /**
     * @修改商铺用户权限
     */
    public function update(){
        $data=trim($this->input->post('data'));
        if(empty($data)){
            $this->errors='修改失败！';
            $this->return_status(0, $this->errors);
        }
        $data = json_decode($data,true);
        $this->load->model('user_model','user');
        $where = array('id_right'=>$data['rid']);
        $dat = array('max'=>$data['max']);
        $res = $this->user->modify_right($where,$dat);
        if($res){
            $this->return_status(1,'修改成功！'); 
        }
        $this->errors='修改失败！';
        $this->return_status(0, $this->errors);
    }
    
    
    
 }
 
 ?>