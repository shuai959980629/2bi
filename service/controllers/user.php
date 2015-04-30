<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 * 用户接口
 * @author jxy
 * @date 2013-10-25 10:38
 */
class User extends User_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->lang->load('user');
        $this->load->library('form_validation');
    }


    /**
     * 客户端调用接口
     */
    public function login()
    {

        //验证客户端数据是否正确，并做相应提示
        if (false === $this->_validate_login()) {
            parent::return_client(0, null, strip_tags($this->errors));
        }

        $login = parent::login();

        if (false !== $login) {
            parent::return_client(1, $login,'login successfully');
        } else {
            parent::return_client(0, null, $this->errors);
        }

    }
    
    
    /**
     * 注销登录
     */
    public function logout(){
        $logout = parent::logout($this->token['uid']);
        if (false !== $logout) {
            $this->load->driver('cache');
    		if($this->cache->memcached->is_supported() === TRUE){
    			$this->cache->memcached->clean();
    		}
            parent::return_client(1, $logout,'logout successfully');
        } else {
            parent::return_client(0, null, $this->errors);
        }
    }

    /**
     * 检测用户数据
     */
    private function _validate_login()
    {

        //检查是否有单独针对客户端的数据验证

        //父类验证公共数据
        if (true === parent::validation_login()) {
            return true;
        }
        return false;

    }


    /**
     * 注册
     */
    public function register()
    {

        //验证数据
        if ($this->_validate_register() == false) {
            parent::return_client(0, null, strip_tags($this->errors));
        }
        //调公用 注册
        $result = parent::register($this->filter_params);
        //返回数据
        if ($result > 0)
            parent::return_client(1, $result, $this->lang->line('user_register_success'));
        else
            parent::return_client(0, null, $this->lang->line('user_register_fail'));
    }


    /**
     * 验证注册数据
     */
    private function _validate_register()
    {

        $this->load->library('form_validation');
        $this->lang->load('user');
        $this->load->model('user_model', 'user');
        $this->form_validation->set_rules('username', '用户名','callback_username_check');
        if ($this->form_validation->run('register', $this->params) === false) {
            $this->errors = $this->form_validation->error_string();
        } else {
            $this->filter_params = $this->params;
            //验证用户名是否已存在
            $re = $this->user->username_exit($this->params['username']);
            if ($re) {
                parent::return_client(0, null, $this->lang->line('user_register_name'));
            } else {
                return true;
            }
        }
        return false;
    }
    /**
     * 用户名验证
     */
    public function username_check($username)
    {
        $is_email = false;
        $is_name = false;
        $is_phone = false;
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $is_email = true;
        }
        if (preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u",$username)) {
            $is_name = true;
        }

        if (preg_match("/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|18[0-9])\d{8}$/",$username)) {
            $is_phone = true;
        }
        $len = (mb_strlen($username)+strlen($username))/2;
        if($len>=4&&$len<=24){
            if ($is_email||$is_name||$is_phone) {
                 return true;
            } else {
                $this->form_validation->set_message('username_check',' %s格式不正确，请重新填写！');
                return false;
            }
        }else{
            $this->form_validation->set_message('username_check',' %s格式不正确，请重新填写！');
            return false;
        }      
    }

    /**
     * 找回用户密码
     */
    public function retrieve_passwd()
    {
        //验证数据 step
        if ($this->_validate_retrieve_0() == false) {
            parent::return_client(0, null, strip_tags($this->errors));
        }
        if ($this->filter_params['step'] == 1) {
            //验证数据
            if ($this->_validate_retrieve_1() == false) {
                parent::return_client(0, null, strip_tags($this->errors));
            }
            if (parent::check_user($this->filter_params['data']['username']) == false) {
                parent::return_client(0, null, $this->errors ? strip_tags($this->errors) : $this->
                    lang->line('user_retrieve_send_fail'));
            }
            parent::return_client(1, null, $this->lang->line('user_retrieve_send'));
        } elseif ($this->filter_params['step'] == 2) {
            //验证数据
            if ($this->_validate_retrieve_2() == false) {
                parent::return_client(0, null, strip_tags($this->errors));
            }
            //修改密码
            $result = parent::retrieve($this->filter_params['data']);
            if ($result) {
                parent::return_client(1, null, $this->lang->line('user_retrieve_success'));
            } else {
                parent::return_client(0, null, $this->errors ? strip_tags($this->errors) : $this->
                    lang->line('user_retrieve_fail'));
            }
        } else {
            parent::return_client(0, null, $this->lang->line('param_error'));
        }
    }


    /**
     * 找回用户密码 验证
     */
    private function _validate_retrieve_0()
    {

        if ($this->form_validation->run('retrieve_0', $this->params) === false) {
            $this->errors = $this->form_validation->error_string();
            return false;
        } else {
            $this->filter_params = $this->params;
            return true;
        }
    }


    private function _validate_retrieve_1()
    {

        if ($this->form_validation->run('retrieve_1', $this->params['data']) === false) {
            $this->errors = $this->form_validation->error_string();
            return false;
        } else {
            $this->filter_params = $this->params;
            return true;
        }
    }


    private function _validate_retrieve_2()
    {
        if ($this->form_validation->run('retrieve_2', $this->params['data']) === false) {
            $this->errors = $this->form_validation->error_string();
            return false;
        } else {
            $this->filter_params['data'] = $this->params['data'];
            return true;
        }
    }


    /**
     * 编辑资料
     */
    public function profile()
    {
        if ($this->_validate_profile() == false) {
            parent::return_client(0, null, strip_tags($this->errors));
        }
        if (!empty($this->filter_params)) {
            $result = parent::profile($this->filter_params, $this->token['uid']);
            if ($result) {
                parent::return_client(1, null, $this->lang->line('user_profile_success'));
            } else {
                parent::return_client(0, null, $this->lang->line('user_profile_fail'));
            }
        }
        parent::return_client(0, null, $this->lang->line('request_param_errors'));
    }
    
    /**
     * 完善第三方登录的用户信息
     */
    public function oauth_info(){
        if ($this->_validate_profile() == false) {
            parent::return_client(0, null, strip_tags($this->errors));
        }
        if (!empty($this->filter_params)) {
            $result = parent::profile($this->filter_params, $this->token['uid']);
            if ($result) {
                parent::return_client(1, null, $this->lang->line('user_profile_success'));
            } else {
                parent::return_client(0, null, $this->lang->line('user_profile_fail'));
            }
        }
        parent::return_client(0, null, $this->lang->line('request_param_errors'));
    }
    
    

    /**
     * 编辑资料 数据验证
     */
    private function _validate_profile()
    {
        if ($this->form_validation->run('profile', $this->params) === false) {
            $this->errors = $this->form_validation->error_string();
            return false;
        } else {
            $this->filter_params = $this->params;
            return true;
        }
    }

    /**
     * 绑定手机
     */
    public function bind_phone()
    {
        if ($this->_validate_bind() == false) {
            parent::return_client(0, null, strip_tags($this->errors));
        }
        $result = parent::binding($this->filter_params, $this->token['uid']);

        if ($result) {
            parent::return_client(1, null, $this->lang->line('user_bind_success'));
        } else {
            parent::return_client(0, null, $this->errors ? strip_tags($this->errors) : $this->lang->line('user_bind_fail'));
        }
    }


    /**
     * 绑定手机 数据验证
     */
    private function _validate_bind()
    {
        $this->form_validation->set_message('phone_check', $this->lang->line('user_bind_phone'));
        if ($this->form_validation->run('bind_phone', $this->params) === false) {
            $this->errors = $this->form_validation->error_string();
            return false;
        } else {
            $this->filter_params = $this->params;
            return true;
        }
    }
    
    /**
     * 绑定支付宝帐号
     */
    public function bind_alipay(){
        if ($this->form_validation->run('bind_alipay', $this->params) === false) {
            $this->errors = $this->form_validation->error_string();
            parent::return_client(0, null, strip_tags($this->errors));
        }
        $result = parent::binding_alipay($this->params, $this->token['uid']);
        if ($result) {
            parent::return_client(1, null, '支付宝帐号绑定成功！');
        } else {
            parent::return_client(0, null, $this->errors ? strip_tags($this->errors) : '支付宝帐号绑定失败！');
        }
        
    }
    
    /**
     * 解除绑定的支付宝帐号  
     */
    public function unbind_alipay(){
        $this->load->model('binding_model', 'bind');
        $info = array('alipay_account' =>'','alipay_name' =>'','alipay_binding' => 0);
        $result = $this->bind->modify_bind($info, $this->token['uid']);
        if ($result) {
            parent::return_client(1, null, '解绑成功！');
        } else {
            parent::return_client(0, null,  '解绑失败！');
        }
    }
    


    /**
     * 个人主页
     */
    public function get_homepage()
    {
        if ($this->_validate_homepage() == false) {
            parent::return_client(0, null, strip_tags($this->errors));
        }
        $result = parent::homepage($this->filter_params['uid']);
        if ($result) {
            parent::return_client(1, $result, null);
        } else {
            parent::return_client(0, null, $this->lang->line('user_homepage_fail'));
        }
    }


    /**
     * 个人主页
     */
    private function _validate_homepage()
    {
        if ($this->form_validation->run('homepage', $this->params) === false) {
            $this->errors = $this->form_validation->error_string();
            return false;
        } else {
            $this->filter_params = $this->params;
            //是否非法用户
            $this->load->model('user_model', 'user');
            $user = $this->user->user_exit($this->filter_params['uid']);
            if (empty($user) or empty($user['uid'])) {
                $this->errors = $this->lang->line('user');
                return false;
            }
            if (empty($this->params['page']))
                $this->filter_params['page'] = 1;
            return true;
        }
    }


    /**
     * 设置密码
     */
    public function modify_password()
    {
        if ($this->_validate_modify_pwd() == false) {
            parent::return_client(0, null, strip_tags($this->errors));
        }
        $result = parent::set_password($this->filter_params['password'], $this->token['uid']);

        if ($result) {
            parent::return_client(1, null, $this->lang->line('user_modify_success'));
        } else {
            parent::return_client(0, null, $this->lang->line('user_modify_fail'));
        }
    }


    /**
     * 设置密码 数据验证
     */
    private function _validate_modify_pwd()
    {
        if ($this->form_validation->run('modifypwd', $this->params) === false) {
            $this->errors = $this->form_validation->error_string();
            return false;
        } else {
            $this->filter_params = $this->params;
            return true;
        }
    }


    /**
     * 手机号码 格式
     */
    public function phone_check($str)
    {
        if (preg_match("/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|18[0-9])\d{8}$/", $str)) {
            return true;
        }
        return false;
    }


    public function get_profile()
    {

        if ($this->token['uid']) {
            $this->load->model('user_model','user');
            $profile = $this->user->get_profile($this->token['uid']);
            if (false !== $profile) {
                parent::return_client(1, $profile);
            }
        }
        parent::return_client(0,null, '获取个人资料失败！');

    }

    /**
     * 上传背景
     */
    public function upload_background()
    {
        if (!empty($_FILES['attachment'])) {
            $result = parent::attachment_upload('backimg');
            if ($result) {
                $this->load->model('user_model', 'user');
                $this->user->modify_user(array('background_image' => $result), $this->token['uid']);
                parent::return_client(1);
            }
        }
        parent::return_client(0, null, $this->lang->line('request_param_errors'));
    }

    /**
     * 获取用户基本信息 昵称 头像
     */
    public function baseinfo()
    {
        if ($this->_validate_homepage() == false) {
            $this->return_client(0, null, strip_tags($this->errors));
        }
        $result = parent::get_baseinfo($this->filter_params['uid']);

        if ($result) {
            $this->return_client(1, $result, null);
        } else {
            $this->return_client(0, null, null);
        }
    }

    /**
     * 获取未读消息
     */
    public function get_unread()
    {
        $result = parent::get_user_unread($this->token['uid']);

        if (false !== $result) {
            $this->return_client(1, $result);
        }
        $this->return_client(0, null, $this->errors);
    }
    
    /**
     * 5.2.16.获取未读消息（私信、咨询、系统消息）
     */
    public function get_msg(){
        
        $result = parent::get_msg($this->token['uid']);
        if (false !== $result) {
            $this->return_client(1, $result);
        }
        $this->return_client(0, null, $this->errors);
        
    }
    
    

    /**
     * 获取自动评价
     */
    public function appraise()
    {
        if ($this->_validate_appraise() == false) {
            $this->return_client(0, null, strip_tags($this->errors));
        }
        $result = parent::get_user_appraise($this->filter_params['uid']);
        if (false !== $result) {
            $this->return_client(1, $result);
        }
        $this->return_client(0, null, $this->errors);

    }
    /**
     * 验证
     */
    public function _validate_appraise()
    {
        if ($this->form_validation->run('appraise', $this->params) === false) {
            $this->errors = $this->form_validation->error_string();
            return false;
        } else {
            //是否非法用户
            $this->load->model('user_model', 'user');
            $user = $this->user->user_exit($this->params['uid']);
            if (empty($user) or empty($user['uid'])) {
                $this->errors = "非法用户，用户不存在！";
                return false;
            } else {
                $this->filter_params = $this->params;
                return true;
            }
        }

    }
    
    /**
     * @我的财务
     */
    public function my_finances(){   
        $result = parent::my_finances($this->token['uid']);
        if (false !== $result) {
            $this->return_client(1, $result);
        }
        $this->return_client(0, null, $this->errors);  
    }
    
    /**
     * @财务列表
     */
    public function finance_list(){
        $page = $this->params['page'] ? $this->params['page'] : 1;
        $status = key_exists('status',$this->params)?$this->params['status']:'';
        $result = parent::finance_list($page,$this->token['uid'],$status);
        if(FALSE !== $result){
            $this->return_client(1,$result);
        }
        $this->return_client(0,null,$this->errors);
    }
    
    /**
     * @邻售首页商铺列表
     * @获取店铺列表
     */
    public function get_shoplist()
    {
        $list = $this->shoplist();
        if(FALSE !== $list){
            $this->return_client(1,$list);
        }
        $this->return_client(0,null,$this->errors);
    }
    
    
    
    

}

/* End of file user.php */
/* Location: ./service/controllers/user.php */
