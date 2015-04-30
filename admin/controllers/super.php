<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *@超级管理 
 *@version v-2.0
 *@author zhoushuai
 *@copyright 2014-06-18
 */
class Super extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('super_model', 'super');
    }
    
   	public function index() {
	    $this->page_data['title']='邻售管理';
        $this->page_data['current']='super';
        $this->load->view ('super',$this->page_data);
	}

    public function adminMysql(){
        $this->page_data['title']='邻售数据库管理';
        $this->page_data['current']='super';
        $tbs = $this->super->show_list_tables();
        $this->page_data['tbs']= $tbs;
        $this->page_data['dtbase']= $this->db->database;
        $this->load->view ('mysql',$this->page_data);
    }
    
    public function exec(){
        $mysql = trim($this->input->post('mysql',TRUE));
        //$mysql = addslashes($mysql);
        $result = $this->super->exec($mysql);
        if($result){
            if(is_bool($result)||is_int($result)){
                $this->return_status(1,'执行成功！','SQL执行成功..........');
            }
            $this->return_status(1,'执行成功！',$result);
        }else{
            $this->return_status(0,'执行失败。。。',$result);
        }
    }
    
    
    
    
    
    
}

/* End of file super.php */
/* Location: ./admin/controllers/super.php */
