<?php
if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
/**
 * @文件上传
 * @copyright(c) 2014-06-24
 * @author zhoushuai
 * @version Id:Files.php
 */
class Files extends Admin_Controller{
    
    protected $attach_config; //上传文件的配置
    public function __construct()
    {
        parent::__construct();
        $this->init_attach();
    } 
    /**
     * @初始化上传配置
     */
    private function init_attach()
    {

        $this->attach_config = array(
            'favicon' => array(
                'upload_path' => 'favicon/',
                'allowed_types' => 'jpg|gif|png',
                'overwrite' => true,
                'max_size' => 0,
                'range_size'=>array(100),
                ),
            'cowry' => array(
                'upload_path' => 'cowry/',
                'allowed_types' => 'jpg|gif|png',
                'max_size' => 0,
                'range_size'=>array(100,192,292),
                ),
            'backimg' => array(
                'upload_path' => 'backimg/',
                'allowed_types' => 'jpg|gif|png',
                'overwrite' => true,
                'max_size' => 0,
                ),
            'msgimg' => array(
                'upload_path' => 'msgimg/',
                'allowed_types' => 'jpg|gif|png',
                'overwrite' => true,
                'max_size' => 0,
                'range_size'=>array(192),
                ),
            'theme' => array(
                'upload_path' => 'theme/',
                'allowed_types' => 'jpg|gif|png|jpeg',
                'overwrite' => true,
                'max_size' => 0,
                ),
            'radio' => array(
                'upload_path' => 'radio/',
                'allowed_types' => '*',
                'overwrite' => true,
                'max_size' => 0,
                ),
            'app' =>array(
                'upload_path' => 'app/',
                'allowed_types' => 'apk|ipa',
                'overwrite' => true,
                'max_size' => 10*1024*1024,
               )
            );

    }
    
    private function create_upload_path($type){
        switch($type){
            case 'app':
                //$path .= ;
                break;  
        }
        $path = $this->attach_config["$type"]['upload_path'];
        return $path;
    }
    
    private function create_file_name($type,$filename){
       $ext = substr($filename, strripos($filename,'.'));
       $date = date("Ymd",time());
       if($type=='app'){
           $this->attach_config["$type"]['file_name'] = 'LinShou_App'.$ext;
       }else{
            $this->attach_config["$type"]['file_name'] = md5(uniqid(microtime(),true)).$ext;
       }
       $fileName = 'attachment/' . $this->attach_config["$type"]['upload_path'] . $this->attach_config["$type"]['file_name']; 
       return $fileName; 
        
    }
   
    
    /**
     * @上传文件的管理
     */
    public function upload_all_file()
    {   
        $type = $this->input->get('type');
        if (!empty($this->attach_config["$type"])) { 
            $path = $this->create_upload_path($type);
            $fileName = $this->create_file_name($type,$_FILES['attachment']["name"]);
            $this->attach_config["$type"]['upload_path'] = ATTACH_PATH . $this->attach_config["$type"]['upload_path'];
            if (!is_dir($this->attach_config["$type"]['upload_path'])) {
                make_dir($this->attach_config["$type"]['upload_path']);
            }
            $this->load->library('upload', $this->attach_config["$type"]);
            if($this->upload->do_upload('attachment')){
                $data = array('path'=>$fileName);
                $this->return_client(1,'上传成功！',$data);
            }else{
                $this->errors = $this->upload->display_errors();
            }
        }else{
            $this->return_client(0,'上传文件配置信息加载失败！');
        }
            

    }
    
    
    /**
     * @删除文件
     */
    public function del_all_file(){
        $fileName = $this->input->post('fileName');
        if(!empty($fileName)){
            $type = $this->input->post('type');
            $path = ATTACH_PATH.$this->attach_config["$type"]['upload_path'] . $fileName;
            if(file_exists($path)){
                unlink($path);
            }
        }
        $this->return_status(1,'删除成功！'); 
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}