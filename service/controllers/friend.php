<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * 好友接口
 *
 * @author rjy
 * @date 2013-11-01 11:38
 */
class Friend extends Friend_Controller {

    function __construct()
    {
        parent::__construct();
        $this->lang->load('friend');
        $this->load->library('form_validation');
    }

    /*
     * 好友列表
     */
    public function get_friendlist()
    {
        $result = parent::friendlist($this->token['uid']);

        if(FALSE !== $result){
            $this->return_client(1,$result);
        }
        $this->return_client(0,null,$this->errors);

    }

    /*
     * 删除好友
     */
    public function delete_friend()
    {
        $friend = $this->_validate_deletefriend();
        if( $friend == FALSE){
            parent::return_client(0,NULL,strip_tags($this->errors));
        }
        $result = parent::deletefriend($friend);

        if( $result ){
            parent::return_client(1,NULL,$this->lang->line('friend_delete_success'));
        }else{
            parent::return_client(0,NULL,$this->lang->line('friend_delete_fail'));
        }
    }
    /*
     * 删除好友 数据验证
     */
    private function _validate_deletefriend()
    {
        if($this->form_validation->run('deletefriend',$this->params) === FALSE){
            $this->errors = $this->form_validation->error_string();
            return FALSE;
        }else{
            $this->filter_params = $this->params;
            $this->load->model('friend_model', 'friend');
            $this->load->model('user_model', 'user');
            //是否是自己
            if( $this->filter_params['uid'] == $this->token['uid'] ){
                $this->errors = $this->lang->line('friend_delete_self');
                return FALSE;
            }
            //是否非法用户
            $user = $this->user->user_exit($this->filter_params['uid']);
            if( empty($user) OR empty($user['uid']) ){
                $this->errors = $this->lang->line('friend_user');
                return FALSE;
            }
            //是否黑名单
            $black = $this->friend->is_friend($this->token['uid'],$this->filter_params['uid'],'black');
            if( !empty($black) && !empty($black['id_friends']) ){
                $this->errors = $this->lang->line('friend_delete_black');
                return FALSE;
            }
            //是否已添加
            $this->load->model('friend_model', 'friend');
            $friend = $this->friend->is_friend($this->token['uid'],$this->filter_params['uid'],'good');
            if( empty($friend) OR empty($friend['id_friends']) ){
                $this->errors = $this->lang->line('friend_delete_friend');
                return FALSE;
            }
            return $friend['id_friends'];
        }

    }

    /*
     * 加入黑名单
     */
    public function add_blacklist()
    {
        if(  $this->_validate_addblack() == FALSE){
            parent::return_client(0,NULL,strip_tags($this->errors));
        }
        $result = parent::addblack($this->token['uid'],$this->filter_params['uid']);

        if( $result ){
            parent::return_client(1,NULL,$this->lang->line('friend_add_success'));
        }else{
            parent::return_client(0,NULL,$this->lang->line('friend_add_fail'));
        }
    }
    /*
     * 加入黑名单 数据
     */
    private function _validate_addblack()
    {
        if($this->form_validation->run('addblack',$this->params) === FALSE){
            $this->errors = $this->form_validation->error_string();
            return FALSE;
        }else{
            $this->filter_params = $this->params;
            $this->load->model('user_model', 'user');
            //是否是自己
            if( $this->filter_params['uid'] == $this->token['uid'] ){
                $this->errors = $this->lang->line('friend_delete_self');
                return FALSE;
            }
            //是否非法用户
            $user = $this->user->user_exit($this->filter_params['uid']);
            if( empty($user) OR empty($user['uid']) ){
                $this->errors = $this->lang->line('friend_user');
                return FALSE;
            }
            //是否是黑名单
            $this->load->model('friend_model','friend');
            $black = $this->friend->is_friend($this->token['uid'],$this->filter_params['uid'],'black');
            if( !empty($black) && !empty($black['id_friends']) ){
                $this->errors = $this->lang->line('friend_add_black');
                return FALSE;
            }
            return TRUE;
        }
    }

    /*
     * 移除黑名单
     */
    public function delete_blacklist()
    {
        $black = $this->_validate_deleteblack();
        if( $black == FALSE){
            parent::return_client(0,NULL,strip_tags($this->errors));
        }
        $result = parent::deletefriend($black);

        if( $result ){
            parent::return_client(1,NULL,$this->lang->line('friend_delblack_success'));
        }else{
            parent::return_client(0,NULL,$this->lang->line('friend_delblack_fail'));
        }
    }
    /*
     * 移除黑名单
     */
    private function _validate_deleteblack()
    {
        if($this->form_validation->run('delblack',$this->params) === FALSE){
            $this->errors = $this->form_validation->error_string();
            return FALSE;
        }else{
            $this->filter_params = $this->params;
            $this->load->model('user_model', 'user');
            //是否是自己
            if( $this->filter_params['uid'] == $this->token['uid'] ){
                $this->errors = $this->lang->line('friend_delete_self');
                return FALSE;
            }
            //是否非法用户
            $user = $this->user->user_exit($this->filter_params['uid']);
            if( empty($user) OR empty($user['uid']) ){
                $this->errors = $this->lang->line('friend_user');
                return FALSE;
            }
            //是否是黑名单
            $this->load->model('friend_model','friend');
            $black = $this->friend->is_friend($this->token['uid'],$this->filter_params['uid'],'black');
            if( empty($black) && empty($black['id_friends']) ){
                $this->errors = $this->lang->line('friend_delblack_black');
                return FALSE;
            }
            return $black['id_friends'];
        }
    }
    /*
     * 获取黑名单列表
     */
    public function get_blacklist()
    {
        if(  $this->_validate_blacklist() == FALSE){
            parent::return_client(0,NULL,strip_tags($this->errors));
        }
        $result = parent::blacklist($this->token['uid']);

        if(FALSE !== $result){
            $this->return_client(1,$result);
        }
        $this->return_client(0,null,$this->errors);

    }
    /*
     * 获取黑名单列表 数据验证
     */
    private function _validate_blacklist()
    {
        if($this->form_validation->run('blacklist',$this->params) === FALSE){
            $this->errors = $this->form_validation->error_string();
            return FALSE;
        }else{
            $this->filter_params = $this->params;
            if( empty($this->params['page']) )
                $this->filter_params['page'] = 1;
            return TRUE;
        }
    }

    /*
     * 获取可能感兴趣的人
     */
    public function get_interest()
    {
        $result = parent::interest($this->token['uid']);

        if(FALSE !== $result){
            $this->return_client(1,$result);
        }
        $this->return_client(0,null,$this->lang->line('friend_interest_fail'));

    }

    /*
     * 财主榜
     */
    public function get_richlist()
    {
        if(  $this->_validate_richlist() == FALSE){
            parent::return_client(0,NULL,strip_tags($this->errors));
        }
        $result = parent::ranklist($this->filter_params,'rich',$this->token['uid']);

        if( $result ){
            parent::return_client(1,$result,NULL);
        }else{
            parent::return_client(0,NULL,$this->lang->line('friend_ranking'));
        }
        return FALSE;
    }
    /*
     * 财主榜/善人榜 数据验证
     */
    private function _validate_richlist()
    {
        if($this->form_validation->run('richlist',$this->params) === FALSE){
            $this->errors = $this->form_validation->error_string();
            return FALSE;
        }else{
            $this->filter_params = $this->params;
            if( empty($this->params['page']) )
                $this->filter_params['page'] = 1;
            if( empty($this->params['type']) )
                $this->filter_params['type'] = 0;
            return TRUE;
        }
    }
    /*
     * 善人榜
     */
    public function get_welllist()
    {
        if(  $this->_validate_richlist() == FALSE){
            parent::return_client(0,NULL,strip_tags($this->errors));
        }
        $result = parent::ranklist($this->filter_params,'good',$this->token['uid']);

        if( $result ){
            parent::return_client(1,$result,NULL);
        }else{
            parent::return_client(0,NULL,$this->lang->line('friend_ranking'));
        }
        return FALSE;
    }


    /*
     * 获取用户关系
     */
    public function get_relation()
    {
        if( empty($this->params['uid']) ){
            $this->return_client(0,NULL,strip_tags($this->lang->line('request_param_errors')));
        }
        $result = parent::get_relation($this->params['uid']);

        if(FALSE !== $result){
            $this->return_client(1,$result);
        }
        $this->return_client(0,null,$this->errors);
    }









}
/* End of file friend.php */
/* Location: ./service/controllers/friend.php */