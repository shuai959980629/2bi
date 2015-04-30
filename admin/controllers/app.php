<?php
if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
/**
 *@后台APP-Version管理
 *@version v-1.0
 *@author zhoushuai
 *@copyright 2014-06-18
 */
class App extends Admin_Controller{

	
	
    public function __construct()
    {
        parent::__construct();
    } 
	
	public function index() {
	    $this->page_data['title']='邻售商家APP管理';
        $this->page_data['current']='app';
        $this->load->model('app_version_model','app');
        $v_list = $this->app->query_version();
        $this->page_data['v_list']=$v_list;
        $this->load->view ('app',$this->page_data);
	}
    
    /**
     * 新增加版本
     */
    public function add(){
        $this->page_data['title']='邻售商家APP管理';
        $this->page_data['current']='app';
        $this->load->view ('app_add',$this->page_data);
    }
    
    public function delversion(){
        $appid=$this->input->post('appid');
        if(!isset($appid)){
            $this->errors='操作失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('app_version_model','app');
        $where = "app_version_id = ".$appid;
        /*
		$app = $this->app->query_version($where);
        $path=DOCUMENT_ROOT.'/'.$app[0]['url'];
        if(file_exists($path)){
            unlink($path);
        }
		*/
        $result = $this->app->del_version($where);
        if( $result ){
            $this->return_status(1,'操作成功！');
        }else{
            $this->return_status(0,'操作失败！');
        }
    }
    
    /**
     *@增加新的版本
     */
    public function add_app(){
       $data= array(
            'version'=>$this->input->post('version'),
            'inner_version'=>$this->input->post('inner_version'),
            'client_type'=>$this->input->post('plat'),
            'url'=>$this->input->post('app_src'),
            'content'=>$this->input->post('log'),
            'is_update'=>$this->input->post('update'),
            'sysuser_name'=>$this->users['realname'],
            'created'=>date("Y-m-d H:i:s", time())
        );
        $this->load->model('app_version_model','app');
        $result = $this->app->add_version($data);
        if( $result ){
            $this->return_status(1,'操作成功！');
        }else{
            $this->return_status(0,'操作失败！');
        }
    }
    
    
    










}