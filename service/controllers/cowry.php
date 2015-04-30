<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * 宝贝接口
 * @author rjy
 * Date: 13-11-5
 * Time: 下午3:32
 */
class Cowry extends Cowry_Controller {

    function __construct()
    {
        parent::__construct();
        $this->lang->load('cowry');
        $this->load->library('form_validation');
    }


    /**
     * 添加宝贝
     */
    public function add_cowry()
    {
        if(  $this->_validate_addcowry() == FALSE){
            $this->return_client(0,NULL,strip_tags($this->errors));
        }
        //宝贝库存最大9999
        //$this->filter_params['number']=$this->filter_params['number']>=MAX_COWRY?MAX_COWRY:$this->filter_params['number'];
        $result = $this->addcowry($this->filter_params,$this->token['uid']);

        if( $result ){
            $this->return_client(1,$result,$this->lang->line('cowry_add_success'));
        }else{
            $this->return_client(0,NULL,strip_tags($this->errors));
        }
        //return FALSE;
    }
    
    
    /**
     * 编辑宝贝
     */
    public function modify_cowry(){
    	
    	if(!empty($this->params['cid']) && !empty($this->params['aid'])){
    	   $this->load->model('user_model', 'user');
            $user = $this->user->get_userinfo($this->token['uid']);
            if($user['status']==0){
                $this->errors=$this->lang->line('business_forbidden');
                $this->return_client(0,null,$this->errors);
            }
    	    $this->load->model('order_model', 'order');
            if(!$this->order->get_adress_inf($this->params['aid'])){
                $this->errors = '宝贝地址不存在或被删除了！';
                $this->return_client(0,null,$this->errors);
            }
            if(empty($this->params['lon']) || empty($this->params['lat'])){
                $this->params['lon'] = '104.072277';
                $this->params['lat'] = '30.663333';
            }
            $this->filter_params = $this->params;
            //宝贝库存最大9999
            //$this->filter_params['number']=$this->filter_params['number']>=MAX_COWRY?MAX_COWRY:$this->filter_params['number'];
    		$img = $this->params['cowimg'];
    		if(!empty($img) && is_array($img)){
    			$img_tmp = array_values($img);
                $this->filter_params['img'] = $img_tmp;
    			$this->filter_params['cover_image'] = $img[0];//保存第一张图片。页面宝贝显示
    			$this->filter_params['cowimg'] = $img;
    		}
    		$result = $this->edit_cowry();
    		if($result){
                $this->return_client(1,$result,$this->lang->line('cowry_edit_success'));
    		}else {
                $this->return_client(0,null,$this->errors);
    		}
    	}
        $this->return_client(0,null,$this->lang->line('request_param_errors'));
    	
    }
    
    
    /**
     * 添加宝贝 数据验证
     */
    private function _validate_addcowry()
    {
        if($this->form_validation->run('addcowry',$this->params) === FALSE){
            $this->errors = $this->form_validation->error_string();
            return FALSE;
        }else{
            $this->load->model('user_model', 'user');
            $user = $this->user->get_userinfo($this->token['uid']);
            if($user['status']==0){
                $this->errors=$this->lang->line('business_forbidden');
                return false;
            }
            //判断可售宝贝数量
            if( $this->params['status'] == 'up'){
                $this->load->model('cowry_model','cowry');
                $count = $this->cowry->get_up_cowry_num($this->token['uid']);
                if( $count['count'] >=$this->profile['max']){
                    $string = $this->lang->line('cowry_add_up');
                    $pattern = '/\d+/i';
                    $this->errors = preg_replace($pattern, $this->profile['max'], $string);
                    return FALSE;
                }
            }
            $this->load->model('order_model', 'order');
            if(!$this->order->get_adress_inf($this->params['aid'])){
                $this->errors = '宝贝地址不存在或被删除了！';
                return FALSE;
            }
            $this->filter_params = $this->params;
            return TRUE;
        }
    }
    

    /**
     * 删除宝贝
     */
    public function delete_cowry()
    {
        if(  $this->_validate_delete() == FALSE){
            $this->return_client(0,NULL,strip_tags($this->errors));
        }
        $result = parent::delete_cowry($this->filter_params,$this->token['uid']);

        if( $result ){
            $this->return_client(1,NULL,$this->lang->line('cowry_delete_success'));
        }else{
            $this->return_client(0,NULL,$this->errors);
        }
    }
    
    
    /**
     * 删除宝贝 数据
     */
    private function _validate_delete()
    {
        if($this->form_validation->run('deletecowry',$this->params) === FALSE){
            $this->errors = $this->form_validation->error_string();
            return FALSE;
        }else{
            $this->load->model('user_model', 'user');
            $user = $this->user->get_userinfo($this->token['uid']);
            if($user['status']==0){
                $this->errors=$this->lang->line('business_forbidden');
                return FALSE;
            }
            $this->filter_params = $this->params;
            return TRUE;
        }
    }
    

    /**
     * 宝贝详细
     */
    public function detail_cowry()
    {
        if(  $this->_validate_detail() == FALSE){
            parent::return_client(0,NULL,strip_tags($this->errors));
        }
        $result = parent::detail_cowry($this->filter_params['cid'],$this->filter_params['uid']);

        if( $result ){
            parent::return_client(1,$result,NULL);
        }else{
            if($this->errors){
                parent::return_client(0,NULL,$this->errors);
            }else{
                parent::return_client(0,NULL,$this->lang->line('cowry_detail_fail'));
            }  
        }
    }
    
    
    /**
     * 宝贝详细 数据验证
     */
    private function _validate_detail()
    {
        if($this->form_validation->run('detailcowry',$this->params) === FALSE){
            $this->errors = $this->form_validation->error_string();
            return FALSE;
        }else{
            //宝贝是否存在
            /*
            $this->load->model('cowryowner_model','owner');
            $result = $this->owner->is_onwer($this->params['cid'],$this->params['uid']);
            */
            $this->load->model('user_model', 'user');
            $user = $this->user->get_userinfo($this->params['uid']);
            if($user['status']==0){
                $this->errors = $this->lang->line('cowry_deleted');;
                return FALSE;
            }
            $this->load->model('cowry_model','cowry');
            $result = $this->cowry->is_cowry($this->params['cid']); 
            if( !$result ){
                $this->errors = $this->lang->line('cowry_false');
                return FALSE;
            }
            $this->filter_params = $this->params;
            return TRUE;
        }
    }


    /**
     * 进贡宝贝   v_1.1已删除
     */
    public function delicate_cowry()
    {
        if(  $this->_validate_delicate() === FALSE){
            parent::return_client(0,NULL,strip_tags($this->errors));
        }
        $result = parent::delicate_cowry($this->filter_params,$this->token['uid']);

        if( $result ){
            parent::return_client(1,NULL,$this->lang->line('cowry_delicate_success'));
        }else{
            parent::return_client(0,NULL,$this->lang->line('cowry_delicate_fail'));
        }
    }


    /**
     * 进贡宝贝 数据验证
     */
    private function _validate_delicate()
    {
        if($this->form_validation->run('delicatecowry',$this->params) === FALSE){
            $this->errors = $this->form_validation->error_string();
            return FALSE;
        }else{
            $this->filter_params = $this->params;
            //验证是否是成员
            $this->load->model('bb_info_model','bb');
            $member = $this->bb->is_member($this->token['uid'],$this->filter_params['bid']);
            if( !$member ){
                $this->errors = $this->lang->line('cowry_delicate_member');
                return FALSE;
            }
            //是否是宝贝所有者
            $this->load->model('cowryowner_model','owner');
            $num = $this->owner->is_onwer($this->filter_params['cid'],$this->token['uid']);
            if( !$num ){
                $this->errors = $this->lang->line('cowry_delicate_owner');
                return FALSE;
            }
            //已有宝贝是否达到进贡数量
            if( $num['num'] < $this->filter_params['number']){
                $this->errors = $this->lang->line('cowry_delicate_number');
                return FALSE;
            }
            return TRUE;
        }
    }


    /**
     * 给好友赠送宝贝
     */
    public function donate_cowry()
    {
        if(  $this->_validate_donate() === FALSE){
            parent::return_client(0,NULL,strip_tags($this->errors));
        }
        $result = parent::donate_cowry($this->filter_params,$this->token['uid']);

        if( $result ){
            parent::return_client(1,NULL,$this->lang->line('cowry_donate_success'));
        }else{
            parent::return_client(0,NULL,$this->lang->line('cowry_donate_fail'));
        }
    }


    /**
     * 赠送宝贝 数据验证
     */
    private function _validate_donate()
    {
        if($this->form_validation->run('donatecowry',$this->params) === FALSE){
            $this->errors = $this->form_validation->error_string();
            return FALSE;
        }else{
            $this->filter_params = $this->params;
            //验证是否是好友
            $this->load->model('friend_model','friend');
            $member = $this->friend->is_friend($this->token['uid'],$this->filter_params['uid'],'good');
            if( !$member ){
                $this->errors = $this->lang->line('cowry_donate_friend');
                return FALSE;
            }
            //是否是宝贝所有者
            $this->load->model('cowryowner_model','owner');
            $num = $this->owner->is_onwer($this->filter_params['cid'],$this->token['uid']);
            if( !$num ){
                $this->errors = $this->lang->line('cowry_donate_owner');
                return FALSE;
            }
            //已有宝贝是否达到赠送数量
            //if( $num['num'] < $this->filter_params['number']){
            //    $this->errors = $this->lang->line('cowry_donate_number');
            //    return FALSE;
            //}
            return TRUE;
        }
    }

    /**
     * 宝贝转换
     */
    public function convert_cowry()
    {
        if(  $this->_validate_convert() === FALSE){
            parent::return_client(0,NULL,strip_tags($this->errors));
        }
        $result = parent::convert($this->filter_params['oid'],$this->token['uid']);

        if( $result ){
            $this->return_client(1,NULL,$this->lang->line('cowry_convert_success'));
        }else{
            $this->return_client(0,NULL,$this->lang->line('cowry_convert_fail'));
        }
    }

    /**
     * 宝贝转换 数据验证
     */
    private function _validate_convert()
    {
        if($this->form_validation->run('manage_order',$this->params) === FALSE){
            $this->errors = $this->form_validation->error_string();
            return FALSE;
        }else{
            //订单状态
            $this->load->model('order_model','order');
            $status = $this->order->get_order_status($this->params['oid']);
            if( $status != 5 ){
                $this->return_client(0,NULL,$this->lang->line('request_param_errors'));
            }
            //是否订单买家
            $member = $this->order->get_member($this->params['oid']);
            if( $this->token['uid'] != $member['buyer'] ){
                $this->return_client(0,NULL,$this->lang->line('order_detail_errors'));
            }
            $this->filter_params = $this->params;
            return TRUE;
        }
    }

    /**
     * 获取宝贝基本信息
     */
    public function baseinfo()
    {
        if(  $this->_validate_detail() == FALSE){
            $this->return_client(0,NULL,strip_tags($this->errors));
        }
        $result = parent::baseinfo($this->filter_params['cid'],$this->filter_params['uid']);

        if( $result ){
            $this->return_client(1,$result,NULL);
        }else{
            $this->return_client(0,NULL,$this->errors);
        }
    }

    /**
     * 获取线下宝贝列表
     */
    public function get_down_cowry()
    {
        $this->load->model('user_model', 'user');
        $user = $this->user->get_userinfo($this->token['uid']);
        if($user['status']==0){
            $this->errors = $this->lang->line('business_forbidden');
            $this->return_client(0,null,$this->errors);
        }
        $page = $this->params['page'] ? $this->params['page'] : 1;
        $result = parent::get_cowrylist($page,$this->token['uid'],'down');
        if(FALSE !== $result){
            $this->return_client(1,$result);
        }
        $this->return_client(0,null,$this->errors);
    }
    
    /**
     * 获取上架宝贝列表
     */
    public function get_up_cowry(){
        $this->load->model('user_model', 'user');
        $user = $this->user->get_userinfo($this->params['uid']);
        if($user['status']==0){
            $this->errors = $this->lang->line('business_forbidden');
            $this->return_client(0,null,$this->errors);
        }
        if($this->params['uid']){
            $page = $this->params['page'] ? $this->params['page'] : 1;
            $result = parent::get_cowrylist($page,$this->params['uid'],'up');
            if(FALSE !== $result){
                $this->return_client(1,$result);
            }
        }else{
            $this->errors = '请求参数错误。';
        }
        
        $this->return_client(0,null,$this->errors);
    }
	
	
	/**
     * 5.4.10.用户自荐专题宝贝列表（上架）
     */
    public function get_recom_cowry(){
        $this->load->model('user_model', 'user');
        $user = $this->user->get_userinfo($this->params['uid']);
        if($user['status']==0){
            $this->errors = $this->lang->line('business_forbidden');
            $this->return_client(0,null,$this->errors);
        }
        if($this->params['uid'] && $this->params['tid']){
            $page = $this->params['page'] ? $this->params['page'] : 1;
            $result = parent::get_recom_cowry($page,$this->params['uid'],$this->params['tid'],'up');
            if(FALSE !== $result){
                $this->return_client(1,$result);
            }
        }else{
            $this->errors = '请求参数错误。';
        }
        
        $this->return_client(0,null,$this->errors);
    }
	
	
	
	
    /**
     * 购物车接口
     */
    public function shopping_cart(){
        //detail_cowry
        if(empty($this->params['data'])){
            $this->return_client(0,NULL,$this->lang->line('request_param_errors'));
        }
        $shoping_list = $this->params['data'];
        $data = array();
        for($i=0;$i<count($shoping_list);$i++){
            $this->load->model('user_model', 'user');
            $user = $this->user->get_userinfo($shoping_list[$i]['uid']);
            if($user['status']==0){
                $shoping_list[$i]['state'] = 0;
            }else{
                //根据所有者id，宝贝id，获取宝贝的up/down。库存。
                $this->load->model('cowry_model','cowry');
                $exist = $this->cowry->is_cowry($shoping_list[$i]['cid']);
                if(!$exist){
                    $shoping_list[$i]['state'] = 0;
                }else{
                    //商家是否拥有该宝贝
                    $this->load->model('cowry_model','cowry');
                    $result = $this->cowry->get_cowry_baseinfo($shoping_list[$i]['cid'],$shoping_list[$i]['uid']); 
                    if(!$result){
                        $shoping_list[$i]['state'] = 0;
                    }else{
                        $shoping_list[$i]['state'] = 1;
                        if($result['status']=='down'){
                            $shoping_list[$i]['state'] = 2;
                        }
                        $shoping_list[$i]['description'] = $result['description'];
                        $shoping_list[$i]['price'] = $result['price'];
                        $shoping_list[$i]['status'] = $result['status'];
                        if($result['num']<0){
                            $result['num'] = 0;
                        }elseif($result['num']>=9999){
                            $result['num'] = 9999;
                        }
                        $shoping_list[$i]['num'] = $result['num'];
                    }
                }        
            }  
            $data[] =$shoping_list[$i] ;
        }
        if(!empty($data)){
            $this->return_client(1,$data);
        }
        $this->return_client(0,null,'购物车宝贝信息获取失败！');
    }
    
    /**
     * @获取宝贝标签
     */
    public function tag(){
        $tag = parent::get_tag();
        if (false !== $tag) {
           parent::return_client(1, $tag);
        } else {
            parent::return_client(0, null, $this->errors);
        }
    }
    
    /**
     * @根据标签获取宝贝列表
     */
    public function get_cowry_by_tag(){
        $page = $this->params['page'] ? $this->params['page'] : 1;
        $gid = intval($this->params['gid'])?intval($this->params['gid']):false;
        if(!$gid){
            $this->errors = "请传入需要查询的标签id！";
        }else{
            $result = parent::get_cowry_by_tag($this->params['gid'],$page);
            if(FALSE !== $result){
                $this->return_client(1,$result);
            }
        }
        $this->return_client(0,null,$this->errors );
    }
    
    
    /**
     * 分享
     */
     public function share(){
        $this->load->library('input');
        $cid = $this->input->get('cid');//宝贝id
        $uid  = $this->input->get('uid');//uid
        if($cid && $uid){
            $result = parent::detail_cowry($cid,$uid);
            if(empty($result)){
                show_404();
            }
            unset($result['other']);
            $result['host']= $_SERVER['HTTP_HOST'];
            $result['link'] = '/app';
            $result['plat']=$this->plat();
            $this->load->view('share',$result);
        }else{
            show_404();
        }
        
     }
    private function plat(){ 
       $plat = 'web';
       $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
       if(strpos($agent,'iphone') || strpos($agent,'ipad') ){
            $plat = 'ios';
       }elseif(strpos($agent,'android')){
            $plat= 'android';
       }
       return $plat;
    }
    
    private function android_version(){
        $this->load->model('app_version_model','app');
        $where = "client_type = 'android'";
        $app = $this->app->check_update($where);
        if($app['url']){
            if(ENVIRONMENT=='production'){
                return 'http://api.linshou.com/'.$app['url'];
            }else{
                return '/'.$app['url'];
            }
        }else{
            return 'http://www.linshou.com/';
        }
    }


    /**
     * zxx
     * 添加评论及回复信息
     */
    public function add_cowry_comment()
    {
        if(  $this->_validate_addcomment() == FALSE){
            $this->return_client(0,NULL,strip_tags($this->errors));
        }

        $result = $this->add_comment($this->filter_params);
        if( $result ){
            $this->return_client(1,$result,$this->lang->line('comment_add_success'));
        }else{
            $this->return_client(0,NULL,strip_tags($this->errors));
        }
        //return FALSE;
    }

    /**
     * zxx
     * 添加评论及回复的 数据验证
     */
    private function _validate_addcomment()
    {
        if($this->form_validation->run('addcomment',$this->params) === FALSE){
            $this->errors = $this->form_validation->error_string();
            return FALSE;
        }else{
            $this->filter_params = $this->params;
            return TRUE;
        }
    }

    /**
     * zxx
     * 获取评论及回复信息
     */
    public function get_cowry_comment()
    {
        if(  $this->_validate_getcomment() == FALSE){
            $this->return_client(0,NULL,strip_tags($this->errors));
        }

        $result = $this->get_comment($this->filter_params);
        if( $result ){
            $this->return_client(1,$result,$this->lang->line('comment_get_success'));
        }else{
            $this->return_client(0,NULL,strip_tags($this->errors));
        }
        //return FALSE;
    }

    /**
     * zxx
     * 获取评论及回复的 数据验证
     */
    private function _validate_getcomment()
    {
        if($this->form_validation->run('getcomment',$this->params) === FALSE){
            $this->errors = $this->form_validation->error_string();
            return FALSE;
        }else{
            $this->filter_params = $this->params;
            return TRUE;
        }
    }
	
	/**
	 *@author zhoushuai
	 *@新增点赞功能
	 *@显示点赞总数，当点击后总数加1，按钮变成实心，再次点击减1按钮变成空心，可反复点击
	 */
	public function zan(){
		if($this->_validate_zan_deny() === TRUE){
            $result = parent::zan($this->filter_params['cid']);
			if($result === TRUE){
				$this->return_client(1,NULL,NULL);
			}
        }
		$this->return_client(0,NULL,strip_tags($this->errors));
    }
	
	/**
	 *@author zhoushuai
	 *@取消赞
	 *@显示点赞总数，当点击后总数加1，按钮变成实心，再次点击减1按钮变成空心，可反复点击
	 */
	public function deny(){
		if($this->_validate_zan_deny() === TRUE){
            $result = parent::deny($this->filter_params['cid']);
			if($result === TRUE){
				$this->return_client(1,NULL,NULL);
			}
        }
		$this->return_client(0,NULL,strip_tags($this->errors));
	}
	
	
	/**
     * @author zhoushuai
     * @新增点赞功能 数据验证
     */
    private function _validate_zan_deny()
    {
        if($this->form_validation->run('zan',$this->params) === FALSE){
            $this->errors = $this->form_validation->error_string();
            return FALSE;
        }else{
            $this->filter_params = $this->params;
            return TRUE;
        }
    }
	
}
/* End of file cowry.php */
/* Location: ./service/controllers/cowry.php */