<?php
if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
/**
 *@后台商户管理
 *@version v-1.0
 *@author zhoushuai
 *@copyright 2014-06-18
 */
class Merchant extends Admin_Controller{

	
	
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index() {
	    $this->page_data['title']='邻售商家商户管理';
        $this->page_data['current']='merchant';
        $uid=$this->input->get('uid');
        $this->load->model('user_model','user');
        if(!empty($uid)){
            $where=array('u.id_2buser'=>$uid);
        }else{
            $where=array('u.status'=>0);
        }
        $this->get_merchant(1,$where);
        $this->cache_data('merchat', $where);
        $this->cache->memcached->delete('filter');
        $this->cache->memcached->delete('query');
        $this->load->view ('merchant',$this->page_data);
	}
    
    
    
    
    
    
    /**
     * 禁用商户
     */
    public function upuser(){
        $status=$this->input->post('status');
        $uid=$this->input->post('uid');
        if(!isset($status)||empty($uid)){
            $this->errors='操作失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('user_model','user');
        $this->load->model('admin_model','admin');
        $data['status'] = $status;
        $result=$this->user->modify_user($data,$uid);
        if( $result ){
            /**
             * @禁用商户向客户端发送消息。提醒商户
             */
            if($status==0){
                $this->send_forbidden_to_client($uid);
            }
            $this->return_status(1,'操作成功！');
        }else{
            $this->return_status(0,'操作失败！');
        }
    }
    /**
     *@author zhoushuai
     *@param uid 商户id
     */
    private function send_forbidden_to_client($uid){
        $tcp = _get_tcp_config();
        $url= 'http://'.$tcp['hostname'].':'.$tcp['port'].'/LinshouTcp.svc/forbidden/'.$uid;
        $return = $this->send_msg_to_client($url);
        //debug($return);
    }
    
    
    /**
     * 查询商户
     */
     public function queryuser(){
        $key=$this->input->post('key');
        $type=$this->input->post('type');
        if(!isset($key)||empty($type)){
            $this->errors='查询失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('user_model','user');
        switch($type){
            case 'username':
                $where = array('u.username'=>$key);
                break;
            case 'nickname':
                $where = "u.nickname like '%{$key}%'";
                break;
            case 'phone':
                $where = array('b.phone_number'=>$key);
                break;
        }
        $this->get_merchant(1,$where);
        $this->cache_data('query', $where);
        echo $this->load->view ('lists',$this->page_data);
     }
     
     /**
      * 筛选商户 
      */
     public function filteruser(){
        $this->load->model('user_model','user');
        $address=trim($this->input->post('address'));
        $end=$this->input->post('end');
        $begin=$this->input->post('begin');
        if(!empty($address)){
           $where = "c.address like '%{$address}%' AND c.default=1 ";
        }
        if(!empty($begin)){
            if (empty($where))
            {
                $where  ="DATE_FORMAT(u.created,'%Y-%m-%d') >= '{$begin}'";
            }else{
                $where .=" AND DATE_FORMAT(u.created,'%Y-%m-%d') >= '{$begin}'";
            }
        }
        if(!empty($end)){
            if (empty($where))
            {
                $where  ="DATE_FORMAT(u.created,'%Y-%m-%d') <= '{$end}'";
            }else{
                $where .=" AND DATE_FORMAT(u.created,'%Y-%m-%d') <= '{$end}'";
            } 
        }
        $this->get_merchant(1,$where);
        $this->cache_data('filter', $where);
        echo $this->load->view ('lists',$this->page_data);
     }
    
    
    /**
     * @获取商户列表
     * @author zhoushuai
     * @param int  offset ：页码
     * @param int  page ：条数
     * @param string  where:查询条件
     */
    public function get_merchant($offset,$where,$page=0){
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        //每页显示数量
        $page = $page ? $page : 8;
        $this->load->model('user_model','user');
        //商户列表
        $merchant_list=$this->user->get_user_list($where,$page,$page*($offset-1));
        //获取商户总数
        $merchant_count = count($this->user->get_user_list($where,0,0));
        //分页代码
        $page_html = $this->get_page($merchant_count, $offset, 'merchant_list_page','method',$page);
        $this->page_data['merchant_list'] = $merchant_list;
        $this->page_data['page_html'] = $page_html;
        $this->page_data['page_type']='merchant';
        //debug($this->page_data);
    }
    
    
    
    /**
     * @获取商户列表分页
     * @author zhoushuai
     * @param int  offset ：页码
     * @param int  page ：条数
     * @param string  where:查询条件
     */
    public function list_merchant(){
        $offset = $this->input->post('offset') ? $this->input->post('offset') : 1;//页码
        $type = $this->input->post('type');
        $where = $this->get_session_data($type);
        $this->get_merchant($offset,$where);
        echo $this->load->view ('lists',$this->page_data);
    }
    
    /**
     * @商铺认证
     * @author zhoushuai
     */
    public function auth(){
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        $data=trim($this->input->post('data'));
        $name=trim($this->input->post('name'));
        $description=trim($this->input->post('description'));
        $address=trim($this->input->post('address'));
        $phone =trim($this->input->post('phone'));
        if(empty($data)||empty($name)||empty($description)||empty($address)||empty($phone) ){
            $this->errors='商铺认证操作失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('user_model','user');
        $data = json_decode($data,true);
        //商铺认证已经通过？？？
        $where = array('id_2buser'=>$data['uid']);
        $isShop = $this->user->query_shop($where);
        if($isShop){
            $this->return_status(1,'商铺认证已经通过！');
            exit();
        }
        $isExt1=$this->user->nickname_exit($name);
        if($isExt1 && $isExt1['id_2buser']!= $data['uid']){
            $this->return_status(0,'店铺名称已经存在，请重新填写！');
        }
        $where1 = array('name'=>$name);
        $isExt = $this->user->query_shop($where1);
        if($isExt && $isExt['id_2buser']!= $data['uid']){
            $this->return_status(0,'店铺名称已经存在，请重新填写！');
            exit();
        }
        //获取地址经纬度坐标
        $addArray = $this->get_lat_lng($address);
        if($addArray['status']!=0){
            $this->errors='商铺认证操作失败！';
            $this->return_status(0, $this->errors);
        }
        $shop = array(
            'latitude'=>$addArray['result']['location']['lat'],
            'longitude'=>$addArray['result']['location']['lng'],
            'phone'=>$phone,
            'address'=>$address,
            'description'=>$description,
            'name'=>$name,
            'id_2buser'=>$data['uid'],
            'image'=>empty($data['favicon'])?'/attachment/defaultimg/head.jpg':trim($data['favicon'])
        );
        $res2=$this->user->insert_shop($shop);
        if($res2){
            //修改商户昵称为店铺名称 普通用户升级店铺
            $res1=$this->update_nickname($name,$data['uid']);
            if(!$res1){
                $this->errors='商铺认证信息修改失败！';
                $this->return_status(0, $this->errors);
            }
            $this->return_status(1,'商铺认证操作成功！');
        }else{
            $this->errors='商铺认证操作失败！';
            $this->return_status(0, $this->errors);
        }
    }
    
    /**
     * @修改商铺认证信息
     * @author zhoushuai
     */
    public function updateauth(){
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        $data=trim($this->input->post('data'));
        $name=trim($this->input->post('name'));
        $description=trim($this->input->post('description'));
        $address=trim($this->input->post('address'));
        $phone =trim($this->input->post('phone'));
        if(empty($data)||empty($name)||empty($description)||empty($address)||empty($phone) ){
            $this->errors='商铺认证信息修改失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('user_model','user');
        $shop = array();
        $data = json_decode($data,true);
        if($name!=$data['nickname']){
            $where1 = array('name'=>$name);
            $isExt1=$this->user->nickname_exit($name);
            if($isExt1){
                $this->return_status(0,'店铺名称已经存在，请重新填写！');
            }
            $isExt = $this->user->query_shop($where1);
            if($isExt){
               $this->return_status(0,'店铺名称已经存在，请重新填写！');
            }
            //修改商户昵称为店铺名称
            $res1=$this->update_nickname($name,$data['uid']);
            if(!$res1){
                $this->errors='商铺认证信息修改失败！';
                $this->return_status(0, $this->errors);
            }
            $shop['name']=$name;
        }
        ////获取地址经纬度坐标
        if($address!=$data['address']){
            $addArray = $this->get_lat_lng($address);
            if($addArray['status']!=0){
                $this->errors='商铺认证信息修改失败！';
                $this->return_status(0, $this->errors);
            }
            $shop['latitude']=$addArray['result']['location']['lat'];
            $shop['longitude']=$addArray['result']['location']['lng'];
            $shop['address']=$address;
        }
        //电话号码
        if($phone!=$data['phone']){
            $shop['phone']=$phone;
        }
        
        if($description!=$data['description']){
            $shop['description']=$description;
        }
        if(!empty($shop)){
            $where = array('id_shop'=>$data['sid']);
            $res2 = $this->user->modify_shop($where,$shop);
            if($res2){
                $this->return_status(1,'商铺认证信息修改成功！');
            }else{
                $this->errors='商铺认证信息修改失败！';
                $this->return_status(0, $this->errors);  
            }
        }else{
            $this->return_status(1,'商铺认证信息修改成功！');
        } 
    }
    
    /**
     * @取消认证商铺
     */
    
    public function cancelauth(){
        $uid=$this->input->post('uid');
        $sid=$this->input->post('sid');
        if(empty($sid)||empty($uid)){
            $this->errors='操作失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('user_model','user');
        $user = array('type'=>'normal');
        $res = $this->user->modify_user($user,$uid);
        if($res){
            //删除商铺列表中的信息
            $where = array('id_shop'=>$sid,'id_2buser'=>$uid);
            $res1=$this->user->del_shop($where);
            if($res1){
                $this->return_status(1,'操作成功！');
            }
        }
        $this->errors='操作失败！';
        $this->return_status(0, $this->errors);
    }
    
    
    private function update_nickname($name,$uid){
        $user = array(
            'nickname'=>$name,
            'type'=>'shop'
        );
        $res=$this->user->modify_user($user,$uid);
        if(!$res){
            return false;
        }
        return true;
    }
    
    
    private function get_lat_lng($address){
        $cacert = ROOT_PATH. 'attachment/key/cacert.pem';
        $url = 'http://api.map.baidu.com/geocoder/v2/?address='.$address.'&output=json&ak=1edcc05cdfc261ed49e9b2a7c33554fb';
        $result = getHttpResponseGET($url,$cacert);
        $addArray = json_decode($result,true);
        return $addArray; 
    }
    
    
    
    
 }
 
 ?>