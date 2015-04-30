<?php
if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
/**
 *@零售APP下载
 *@version v-1.0
 *@author zhoushuai
 *@copyright 2014-09-28
 */
class App extends CI_Controller {

	
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    } 
	
       
	public function index() {
        $this->params['title']='邻售';
        $type = get_device_type();
        if($type=='weixin'){
            $this->params['android_app']='javascript:openPop();';
            $this->params['ios_app']='javascript:openPop();';
        }else{
           $this->params['android_app']=$this->android_version(); 
           $this->params['ios_app']= 'https://itunes.apple.com/cn/app/lin-shou/id830293898?ls=1&mt=8';
        }
        $this->params['type']=$type;
        $this->load->view('download',$this->params);
	}
    
    public function download(){
        $type = get_device_type();
        switch($type){
            case 'ios':
                redirect('https://itunes.apple.com/cn/app/lin-shou/id830293898?ls=1&mt=8');
                break;
            case 'android':
                $url = $this->android_version();
                redirect($url); 
                break;
            default:
                redirect('/app');
                break;
        }
    }
    
    
    private function ios_version(){
        $this->load->model('app_version_model','app');
        $where = "client_type = 'ios'";
        $app = $this->app->check_update($where);
        return '/'.$app['url'];    
    }
    
    private function android_version(){
        $this->load->model('app_version_model','app');
        $where = "client_type = 'android'";
        $app = $this->app->check_update($where);
        if($app['url']){
            return 'http://'.$_SERVER ['HTTP_HOST'].'/'.$app['url'];
        }else{
            return 'http://'.$_SERVER ['HTTP_HOST'];
        }
    }
	
}

/* End of file app.php */
/* Location: ./service/controllers/app.php */