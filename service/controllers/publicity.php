<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 描述文件的功能
 * 
 * @author jxy
 * @date 2013-11-04 14:35
 */
class Publicity extends Common_Controller {

	
	public function __construct(){
		
		parent::__construct();
		$this->load->library('form_validation');
		
	}
	
	
	/**
	 * 同步用户设备信息
	 */
	public function device_info()
	{
		if($this->token['uid']){
			if(FALSE === $this->form_validation->run('device_info',$this->params)){
				parent::return_client(0,null,$this->lang->line('request_param_errors'));
				return FALSE;
			}else{
				//记录设备码
				$this->load->model('user_model','user');
				$this->filter_params['client_model'] = $this->params['brand'].' '.$this->params['modnum'];
				$this->filter_params['client_number'] = $this->params['devuniq'];
                $this->filter_params['device_token']= $this->params['devuniq'];
				if(in_array($this->params['type'], array('web','android','ios'))){
					$this->filter_params['object_type'] = $this->params['type'];
				}
                //device_token数据库写入,非必须
                $data = array('device_token'=>trim($this->filter_params['device_token']));
                //确保设备码唯一。删除已经存在的
                $this->user->delete_device_token($data);
                //更新用户设备
				if($this->user->update_device_info($this->token['uid'],$this->filter_params)){
					parent::return_client(1);
					return TRUE;
				}
			
			}
		}
		parent::return_client(0,null,$this->lang->line('request_param_errors'));
	}
	
	
	/**
	 * 验证密码是否正确
	 */
	public function validation_password(){
		if(!empty($this->token['uid']) && !empty($this->params['password'])){
			$this->load->model('user_model','user');
			$where = array('id_2buser'=>$this->token['uid'],'password'=>$this->params['password']);
			if(FALSE !== $this->user->validation_password($where)){
				parent::return_client(1);
				return TRUE;
			}else{
			 parent::return_client(0,null,$this->lang->line('pwd_error'));
			}
		}else{
		  parent::return_client(0,null,$this->lang->line('request_param_errors'));
		}
	
	}
	
	
	/**
	 * 发送手机验证码
	 */
	public function send_valicode(){
		
		if(!empty($this->params['phonum'])){
            
            if($this->params['type']=='login'){
                //每个手机号码限制每天最大10条登录验证码。
                $this->load->model('user_model','user');
                $where = array('phone'=>$this->params['phonum']);
                $data =array('phone'=>$this->params['phonum'],'created'=>date('Y-m-d H:i:s',time()));
                $res = $this->user->query_record($where);
                if($res>=10){
                    parent::return_client(0,null,'手机登录验证超过10次，验证失败！');
                }else{
                    $this->user->insert_record($data);
                }
                //手机登录验证。初始用户id为零
                $userID = 0;
            }else{
                $userID = $this->token['uid'];
            }
            $result = $this->send_captcha($this->params['phonum'],$userID);
            if(TRUE === $result){
                $this->return_client(1,null,'sendsuccessfully');
            }else{
                $this->return_client(0);
            }
		}
		parent::return_client(0,null,$this->lang->line('request_param_errors'));
		
	}
	
	
	/**
	 * 上传附件
	 */
	public function upload_attachment(){
	    /**
         * @本地测试。打开以下参数
         */
        //参数msgimg,cowry,favicon
        //$this->params['type'] = 'cowry';
		if(in_array($this->params['type'], array_keys($this->attach_config)) && !empty($_FILES['attachment'])){
			$result = parent::attachment_upload($this->params['type']);
            if( !empty($result) ){
                parent::return_client(1,$result);
            }else{
                parent::return_client(0,NULL,strip_tags($this->errors));
            }
		}
		parent::return_client(0,null,$this->lang->line('request_param_errors'));
		
	}
	 
    /**
     * @版本更新管理
     * @检测软件更新
     */
    public function check_update(){
        $this->load->model('app_version_model','app');
        $where = "client_type = '{$this->platform}'";
        $applist = $this->app->query_version($where);
        if(empty($applist)){
            parent::return_client(1,null,'最新版本无须更新！');
        }
        $data = array('state'=>0,'version'=>$this->version,'force'=>0,'info'=>'','url'=>'');
        $version = array();
        for($i=0;$i<count($applist);$i++){
            if(version_compare($applist[$i]['version'],$this->version,"<=")){
                continue;
            }
            $version[]=$applist[$i];
        }
        if(empty($version)){
            parent::return_client(1,$data,'最新版本无须更新！');
        }
        for($i=0;$i<count($version);$i++){
            if($version[$i]['is_update']==1){
                $data['state']=1;
                $data['force']=1;
                break;
            }else{
                $data['state']=1;
                continue;
            }
        }
        $data['version']= $applist[0]['version'];
        $data['info']=$applist[0]['content'];
        $data['url']='http://' . $_SERVER['HTTP_HOST'].'/'.$applist[0]['url'];
        parent::return_client(1,$data,null);
    }
    
	
}


  

/* End of file Publicity.php */
/* Location: ./service/controllers/publicity.php */