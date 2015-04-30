<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * 订单相关接口
 *
 * @author rjy
 * @date 2013-12-17 14:30
 */
class Order extends Order_Controller {


    public function __construct(){

        parent::__construct();

        $this->lang->load('order');
        $this->load->library('form_validation');
    }

    /**
     * 邻售首页（附近的宝贝）
     */
    public function get_cowrylist()
    {
        $list = $this->cowrylist();
        if(FALSE !== $list){
            $this->return_client(1,$list);
        }
        $this->return_client(0,null,$this->errors);
    }

    /**
     * @生成订单，
     */
    public function add_order()
    {
        if(  $this->_validate_add_order() == FALSE){
            $this->return_client(0,NULL,strip_tags($this->errors));
        }
        $result = parent::add($this->filter_params,$this->token['uid']);
        if( $result ){
            $this->return_client(1,$result,NULL);
        }else{
            $this->return_client(0,NULL,$this->errors);
        }
    }
    /*
    * 生成订单 数据验证
    */
    private function _validate_add_order()
    {
        
        if( empty($this->params['uid']) || empty($this->params['total_price']) || empty($this->params['total_num'])|| empty($this->params['payment']) ){
            $this->errors = $this->lang->line('request_param_errors');
            return FALSE;
        }else{
            //宝贝是否存在,宝贝是否下架
            $this->load->model('cowryowner_model','owner');
            foreach($this->params['data'] as $item){
                if($this->form_validation->run('add_order',$item) === FALSE){
                    $this->errors = $this->form_validation->error_string();
                    return FALSE;
                }
                //宝贝是否存在,宝贝是否下架
                $return = $this->owner->is_exist($item['cid'],$this->params['uid']);
                if($return===FALSE){
                   $this->errors = $this->lang->line('add_order_lose');
                   return FALSE; 
                }
                if($return['status'] == 'down'){
                    $this->errors = $this->lang->line('add_order_down');
                    return FALSE;
                }
                //已有宝贝是否达到购买数量
                if($return['num'] < $item['buy_num']){
                    $this->errors = $this->lang->line('add_order_number');
                    return FALSE;
                }
            }
            
            $this->filter_params = $this->params;
            return TRUE;
        }
    }
    
    /**
     * @生成虚拟订单
     */
    public function v_order(){
        if($this->_validate_v_order() == FALSE){
            $this->return_client(0,NULL,strip_tags($this->errors));
        }
        $result = parent::add_v_order($this->filter_params,$this->token['uid']);
        if( $result ){
            $this->return_client(1,$result,NULL);
        }else{
            $this->return_client(0,NULL,$this->errors);
        }
        
        
    }
    private function _validate_v_order(){
        if($this->form_validation->run('v_order',$this->params) === FALSE){
            $this->errors = $this->form_validation->error_string();
            return FALSE;
        }else{
            //宝贝是否存在,宝贝是否下架
            $this->load->model('cowryowner_model','owner');
            $return = $this->owner->is_exist($this->params['cid'],$this->params['uid']);
            if($return===FALSE){
               $this->errors = $this->lang->line('add_order_lose');
               return FALSE; 
            }
            if($return['status'] == 'down'){
                $this->errors = $this->lang->line('add_order_down');
                return FALSE;
            }
            $this->filter_params = $this->params;
            return TRUE;
        }
       
        
        
    }
    
    /**
     * @修改订单ModifyOrder
     */
    public function modify_order(){
        if($this->validation_modify() == FALSE){
            $this->return_client(0,NULL,strip_tags($this->errors));
        }
        $result = parent::modify_order();
        if( $result ){
            $this->return_client(1,$result,NULL);
        }else{
            $this->return_client(0,NULL,$this->errors);
        }
    }
    
    private function validation_modify(){
        if (empty($this->params)) {
            //返回错误
            $this->errors = $this->lang->line('user_login_param_error');
            return false;
        } else {
            if (!in_array($this->params['method'], array('virtual','real'))) {
                $this->errors = '请传入订单类型！';
                return false;
            } else {
                //验证数据完整性
                $group = $this->params['method'] == 'real' ? 'modify_real_order' : 'modify_virtual_order';
                if (false !== $this->form_validation->run($group, $this->params['data'])) {
                    $this->filter_params['method'] = $group;
                    $this->filter_params['data'] = $this->params['data'];
                    return true;
                } else {
                    $this->errors = $this->form_validation->error_string();
                }
            }
        }

        return false;        
    }
    
    /**
     * @取消订单，修改订单状态
     * 1:虚拟订单, 2:已付款,3:投诉中,4:投诉完成（仲裁完成）5:已收货(订单完成),6:取消，
     */
    public function cancel_order(){
        $oid = intval($this->params['oid'])?intval($this->params['oid']):false;
        if(!$oid){
            $this->errors = "请传入需要 删除的订单id！";
         }else{
            $result = parent::cancel_order($this->params['oid']);
            if(FALSE !== $result){
                $this->return_client(1,$result);
            }
         }
         $this->return_client(0,null,$this->errors );
        
    }
    
    /**
     * @正在处理的订单列表（统计）
     * 2:已付款,3:投诉中,
     */
    public function ordering(){
        $result = parent::ordering($this->token['uid']);
        if(FALSE !== $result){
            $this->return_client(1,$result);
        }
        $this->return_client(0,null,$this->errors);
    }
    

    /**
     * @我的订单列表（v2.0）
     * 1:虚拟订单, 2:已付款(线下支付订单待确认),3:投诉中,4:投诉完成（仲裁完成）5:已收货(订单完成,线下支付订单已确认),6:取消
     */
    public function get_orderlist(){
        $page = $this->params['page'] ? $this->params['page'] : 1;
        $status = key_exists('status',$this->params)?$this->params['status']:'';
        $result = parent::orderlist($page,$this->token['uid'],$status);
        if(FALSE !== $result){
            $this->return_client(1,$result);
        }
        $this->return_client(0,null,$this->errors);
    }
    
    /**
     * @咨询聊天时候的订单列表。。
     * 1:虚拟订单, 2:已付款(线下支付订单待确认),3:投诉中,4:投诉完成（仲裁完成）5:已收货(订单完成,线下支付订单已确认),6:取消
     */
    public function get_chat_orderlist(){
        $page = $this->params['page'] ? $this->params['page'] : 1;
        $status = key_exists('status',$this->params)?$this->params['status']:FALSE;
        $objectid = key_exists('uid',$this->params)?$this->params['uid']:FALSE;//咨询聊天的对象id
        if(!$objectid || !$status){
            $this->errors = '参数错误！';
        }else{
            $result = parent::get_chat_orderlist($page,$this->token['uid'],$status,$objectid);
            if(FALSE !== $result){
                $this->return_client(1,$result);
            }
        }
        $this->return_client(0,null,$this->errors);
    }
    
     /**
      * @订单快照(v2.0)
      *  订单编号
    *  宝贝信息：宝贝图片+宝贝简介+价格+数量+总价
    *  收货信息：电话+收货地址
      */
     public function get_order_detail(){
        $oid = intval($this->params['oid'])?intval($this->params['oid']):false;
        if(!$oid){
            $this->errors = "请传入需要查询的订单id！";
         }else{
            $result = parent::get_order_detail($this->params['oid']);
            if(FALSE !== $result){
                $this->return_client(1,$result);
            }
         }
         $this->return_client(0,null,$this->errors );
     }
     
     /**
      * @订单详情
      */
     public function get_order_inf(){
         $oid = intval($this->params['oid'])?intval($this->params['oid']):false;
         if(!$oid){
            $this->errors = "传入参数错误！";
         }else{
            $result = parent::get_order_infor($this->params['oid']);
            if(FALSE !== $result){
                $this->return_client(1,$result);
            }
         }
         $this->return_client(0,null,$this->errors );
     }
     

    /**
     * @获取地址列表
     */
    public function get_address()
    {
        $result = parent::get_addresslist($this->token['uid']);

        if(FALSE !== $result){
            $this->return_client(1,$result);
        }
        $this->return_client(0,null,$this->errors);

    }

    /**
     * @添加地址
     */
    public function add_address()
    {
        if(  $this->_validate_add_address() == FALSE){
            $this->return_client(0,NULL,strip_tags($this->errors));
        }
        $result = parent::add_address($this->filter_params,$this->token['uid']);

        if( $result ){
            $this->return_client(1,$result,NULL);
        }else{
            $this->return_client(0,NULL,$this->lang->line('modify_order_fail'));
        }
    }

    /**
     * @添加地址 数据验证
     */
    private function _validate_add_address()
    {
        if($this->form_validation->run('add_address',$this->params) === FALSE){
            //$this->errors = $this->form_validation->error_string();
            $this->errors = $this->lang->line('request_param_errors');
            return FALSE;
        }else{
            //地址数 是否已达上限
            $this->load->model('order_model','order');
            //$count = $this->order->get_connect_num($this->token['uid']);
            $count = $this->order->get_address_num(array('id_2buser' => $this->token['uid'],'default !=' =>'-1'));
            if( $count >= 6){
                $this->errors = $this->lang->line('add_address_count');
                return FALSE;
            }
            $this->filter_params = $this->params;
            return TRUE;
        }
    }

    /**
     * @删除地址
     */
    public function del_address()
    {
        $result = parent::delete_address($this->params['aid'],$this->token['uid']);

        if( $result ){
            $this->return_client(1,NULL,NULL);
        }else{
            $this->return_client(0,NULL,$this->errors);
        }
    }

    /**
     * @编辑地址
     */
    public function modify_address()
    {
        if($this->form_validation->run('add_address',$this->params) === FALSE){
            $this->return_client(0,NULL,$this->lang->line('request_param_errors'));
        }
        $result = parent::add_address($this->params,$this->token['uid']);

        if( $result ){
            $this->return_client(1,$result,NULL);
        }else{
            $this->return_client(0,NULL,$this->lang->line('modify_order_fail'));
        }
    }
    
    /**
     * @确认订单。确认收货
     */
    public function confirm_order(){
        $oid = intval($this->params['oid'])?intval($this->params['oid']):false;
        if(!$oid){
            $this->errors = "传入参数错误！";
        }else{
            $result = parent::confirm_order($this->params['oid']);
            if(FALSE !== $result){
                $this->return_client(1,$result);
            }
        }
        $this->return_client(0,null,$this->errors ); 
    }
    
    /**
     * @author zhoushuai
     * @核对订单信息。查询订单交易是否完成，完成交易修改状态。
     * @超过30分钟未完成的交易。退还库存。删除订单记录
     */
    public function check(){
        $end = date("Y-m-d H:i:s",strtotime("-30 minute"));
        $this->load->model('order_model', 'order');
        $where = "o.status =  0 AND DATE_FORMAT(o.created,'%Y-%m-%d %H:%i:%s') <= '{$end}'";
        $orderlist = $this->order->query_order_list($where);
        if($orderlist){
            foreach($orderlist as $Key=>$val){
                $this->single_trade_query($val);
            }
        }
        exit('finish');
    }
    
    
    
    /**
     * @单笔订单查询
     */
    private function single_trade_query($order){
        //获取支付配置
        $alipay_config = _get_alipay_config();
        //更换签名验证MD5
        $alipay_config['sign_type'] = 'MD5';
        //$trade_no = '';
        //$out_trade_no = '14487108160828';//1458272380827,1448738160828
        //构造要请求的参数数组，无需改动
        $parameter = array(
        		"service" => "single_trade_query",
        		"partner" => trim($alipay_config['partner']),
        		"trade_no"	=> $order['trade_no'],//支付宝交易号
        		"out_trade_no"	=> $order['order_no'],//订单号
        		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
        );
        //提交参数到支付宝。支付 页面跳转
        $this->load->library('alipaysubmit', $alipay_config,'alisubmit');
        $html_text = $this->alisubmit->buildRequestHttp($parameter);
        //解析XML
        $doc = new DOMDocument();
        $doc->loadXML($html_text);
        /**
         * @交易状态
         * TRADE_FINISHED 交易成功结束
         * TRADE_CLOSED 交易中途关闭（已结束，未成功完成）
         */
        if( ! empty($doc->getElementsByTagName( "alipay" )->item(0)->nodeValue) ){
            $alipay = simplest_xml_to_array($html_text);
            if($alipay['is_success']=='T' && ($alipay['response']['trade']['trade_status']=='TRADE_FINISHED' || $alipay['response']['trade']['trade_status']=='TRADE_SUCCESS')){
                /**
                 * @交易支付完成修改订单状态
                 */
                $data = array(
                    'out_trade_no'=>$alipay['response']['trade']['out_trade_no'],
                    'trade_no'=>$alipay['response']['trade']['trade_no'],
                    'trade_status'=>$alipay['response']['trade']['trade_status'],
                    'vendor_email'=>$alipay['response']['trade']['seller_email'],
                    'buyer_email'=>$alipay['response']['trade']['buyer_email']
                );
                $res = parent::_complete_order($data);

            }else{
                /**
                 * @支付交易关闭。或创建预购买订单。15分钟后未支付，删除订单。退还库存
                 */
                $res1 = parent::_delete_order($order);
            }
        }
    }
    
    
    /**
     * @author zhoushuai
     * @接口说明：线下交易超过3天未完成的订单，则系统自动修改订单状态为【取消】
     * @接口地址：http://api.linshou.com/order/offline 
     * @请求方式：GET
     * @用    途：线下交易完成。订单状态改为取消。
     * @6:取消
     */
    public function offline(){
        $end = date("Y-m-d ",strtotime("-3 days"));
        $this->load->model('order_model', 'order');
        $where = "o.payment = 'offline' AND o.status = 2 AND DATE_FORMAT(o.created,'%Y-%m-%d') <= '{$end}'";
        $orderlist = $this->order->query_order_list($where);
        if($orderlist){
            $data = array();
            foreach($orderlist as $Key=>$val){
                //$data = array('status' => 6, 'created' => date('Y-m-d H:i:s', time()));
                //$this->order->modify_order($data, $val['oid']);
                $data[] = array('status' => 6,'id_orders'=>$val['oid'],'created' => date('Y-m-d H:i:s', time())); 
            }
            $this->order->modify_batch_order($data,'id_orders');
        }
        exit('finish');
    }
    
    /**
     */
    
    


}

/* End of file Order.php */
/* Location: ./service/controllers/order.php */