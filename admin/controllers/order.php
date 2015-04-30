<?php
if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
/**
 *@后台管理-订单管理
 *@version v-1.0
 *@author zhoushuai
 *@copyright 2014-06-18
 */
class Order extends Admin_Controller{

	
	
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * @订单处理
     */
    public function index() {
	    $this->page_data['title']='邻售后台订单处理';
        $this->page_data['current']='order';
        /**
         * @第一步：获取订单列表。分页
         */
        $where = 'o.status != 0 AND o.status != 1';
        $this->get_order(1,$where);
        $this->cache_data('all', $where);
        $this->cache->memcached->delete('filter');
        $this->cache->memcached->delete('query');
        $this->load->view ('order',$this->page_data);
	}
    
    
    /**
     * @获取订单列表
     * @author zhoushuai
     * @param int  offset ：页码
     * @param int  page ：条数
     * @param string  where:查询条件
     */
    private function get_order($offset,$where,$page=0){
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        //每页显示数量
        $page = $page ? $page : 8;
        $this->load->model('order_model', 'order');
        //订单列表
        $order_list=$this->order->get_order_list($where,$page,$page*($offset-1));
        //获取订单总数
        $order_count = count($this->order->get_order_list($where,0,0));
        //分页代码
        $page_html = $this->get_page($order_count, $offset, 'order_list_page','method',$page);
        $this->page_data['order_list'] = $order_list;
        $this->page_data['page_html'] = $page_html;
        $this->page_data['page_type']='order';
    }
    
    /**
     * @获取订单列表分页
     * @author zhoushuai
     * @param int  offset ：页码
     * @param int  page ：条数
     * @param string  where:查询条件
     */
    public function order_list(){
        $offset = $this->input->post('offset') ? $this->input->post('offset') : 1;//页码
        $type = $this->input->post('type');
        $where = $this->get_session_data($type);
        $this->get_order($offset,$where);
        echo $this->load->view ('lists',$this->page_data);
    }
    
    
    /**
     * @根据订单编号查询订单信息
     */
    public function query(){
        $out_trade_no=trim($this->input->post('out_trade_no'));
        $where = "o.status != 0 AND o.status != 1 AND o.order_no = {$out_trade_no}";
        $this->get_order(1,$where);
        $this->cache_data('query', $where);
        echo $this->load->view ('lists',$this->page_data);
    }
    
    
    /**
     * @筛选订单 
     */
     public function filter(){
        $status=trim($this->input->post('status'));
        $end=$this->input->post('end');
        $begin=$this->input->post('begin');
        $payment = trim($this->input->post('payment'));
        $where = '';
        if(isset($payment)){
            if($payment=='offline'){
                $where = "o.payment = 'offline'";
            }else{
                $where = "o.payment = 'online'";
            }
        }
        if(isset($status)){
            if($status!=-1){
                $where .= " AND o.status =  {$status}";
            }else{
                $where .= " AND o.status != 0 AND o.status != 1";
            }
        }
        if(!empty($begin)){
            if (empty($where))
            {
                $where  ="DATE_FORMAT(o.created,'%Y-%m-%d') >= '{$begin}'";
            }else{
                $where .=" AND DATE_FORMAT(o.created,'%Y-%m-%d') >= '{$begin}'";
            }
        }
        if(!empty($end)){
            if (empty($where))
            {
                $where  ="DATE_FORMAT(o.created,'%Y-%m-%d') <= '{$end}'";
            }else{
                $where .=" AND DATE_FORMAT(o.created,'%Y-%m-%d') <= '{$end}'";
            } 
        }
        $this->get_order(1,$where);
        $this->cache_data('filter', $where);
        echo $this->load->view ('lists',$this->page_data);
     }
    
    /**
     * @线下交易
     */
    public function offline_order(){
        $payment=trim($this->input->post('payment'));
        $where = array();
        if(!empty($payment)){
            $where = array('o.payment'=>$payment);
        }
        $this->get_order(1,$where);
        $this->cache_data('offline', $where);
        echo $this->load->view ('lists',$this->page_data);
    }
    
    /**
     * @投诉处理
     */
    public function complaint(){
        $data=trim($this->input->post('data'));
        if(empty($data)){
            $this->errors='投诉处理操作失败！';
            $this->return_status(0, $this->errors);
        }
        $data = json_decode($data,true);
        $this->load->model('order_model', 'order');
        $oid = $data['oid'];
        $data = array(
            'cpt_comment'=>$data['cpt_comment'],
            'status'=>3 //3:投诉中
        );
        $res = $this->order->modify_order($data,$oid);
        if($res){
            $this->return_status(1,'投诉处理操作成功！');
        }
        $this->return_status(0,'投诉处理操作失败！');
    }
    
    /**
     * @仲裁
     */
    public function arbitration(){
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        $data=trim($this->input->post('data'));
        if(empty($data)){
            $this->errors='仲裁处理操作失败！';
            $this->return_status(0, $this->errors);
        }
        $data = json_decode($data,true);
        $this->load->model('order_model', 'order');
        $oid = $data['oid'];
        $modify = array(
            'cpt_comment'=>$data['cpt_comment'],
            'cpt_result'=>$data['cpt_result']
        );
        
        if($data['cpt_result']==1){
            //1：付款给卖家
            $username = empty($data['vendor_username'])?$data['vendor_nickname']:$data['vendor_username'];
            $nickname = $data['vendor_nickname'];
            $role = '卖家';
            $uid = $data['vendor'];
        }elseif($data['cpt_result']==2){
            //2：付款给买家
            $username = empty($data['buyer_username'])?$data['buyer_nickname']:$data['buyer_username'];
            $nickname = $data['buyer_nickname'];
            $role = '买家';
            $uid = $data['buyer'];
    
        }
        $this->load->model('finance_model','finance');
        $auditing = array(
            'id_2buser'=>$uid,
            'role'=>$role,
            'username'=>$username,
            'nickname'=>$nickname,
            'id_orders'=>$data['oid'],
            'out_trade_no'=>$data['order_no'],
            'trade_no'=>$data['trade_no'],
            'sum'=>$data['total_price'],
            'order_created'=>$data['created'],
            'status'=>0,
            'result'=>$data['cpt_result'],
            'comment'=>$data['cpt_comment'],
            'operator'=>$this->users['realname'],
            'created'=>date('Y-m-d H:i:s', time()),
        );
        //2.3.4auditing 投诉处理订单审核记录
        $res1 = $this->finance->insert_auditing($auditing);
        if($res1){
            //仲裁，记录仲裁结果
            $res2=$this->order->modify_order($modify,$oid);
            if($res2){
                $this->return_status(1,'仲裁处理操作成功！');
            }
        }
        $this->return_status(0,'仲裁处理操作失败！');
    }
    
    
    /**
     * @订单审核
     */
    public function review(){
        $this->page_data['title']='邻售后台订单审核';
        $this->page_data['current']='review';
        $where = '';
        $this->get_review(1,$where);
        $this->cache_data('all', $where);
        $this->load->view ('order_review',$this->page_data);
    }                        
 
 
   /**
     * @获取订单审核列表
     * @author zhoushuai
     * @param int  offset ：页码
     * @param int  page ：条数
     * @param string  where:搜索条件
     */
    private function get_review($offset,$where,$page=0){
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        //每页显示数量
        $page = $page ? $page : 8;
        $this->load->model('order_model', 'order');
        //订单列表
        $review_list=$this->order->get_review_list($where,$page,$page*($offset-1));
        //debug($review_list);
        //exit;
        //获取订单总数
        $review_count = count($this->order->get_review_list($where,0,0));
        //分页代码
        $page_html = $this->get_page($review_count, $offset, 'review_list_page','method',$page);
        
        $this->page_data['review_list'] = $review_list;
        $this->page_data['page_html'] = $page_html;
        $this->page_data['page_type']='review';
        //debug($this->page_data);
    }
 
    /**
     * @获取订单审核列表分页
     * @author zhoushuai
     * @param int  offset ：页码
     * @param int  page ：条数
     * @param string  where:搜索条件
     */
    public function review_list(){
        $offset = $this->input->post('offset') ? $this->input->post('offset') : 1;//页码
        $type = $this->input->post('type');
        $where = $this->get_session_data($type);
        $this->get_review($offset,$where);
        echo $this->load->view ('lists',$this->page_data);
    }
 
    /**
     * @根据订单编号查询审核订单信息
     */
    public function review_query(){
        $out_trade_no=trim($this->input->post('out_trade_no'));
        $where = "out_trade_no = {$out_trade_no}";
        $this->get_review(1,$where);
        $this->cache_data('review_query', $where);
        echo $this->load->view ('lists',$this->page_data);
    }
    
    
    /**
     * @筛选审核订单 
     */
     public function review_filter(){
        $status=trim($this->input->post('status'));
        $end=$this->input->post('end');
        $begin=$this->input->post('begin');
        $where = '';
        if(isset($status)){
            if($status!=-1){
                $where = "status =  {$status}";
            }
        }
        if(!empty($begin)){
            if (empty($where))
            {
                $where  ="DATE_FORMAT(created,'%Y-%m-%d') >= '{$begin}'";
            }else{
                $where .=" AND DATE_FORMAT(created,'%Y-%m-%d') >= '{$begin}'";
            }
        }
        if(!empty($end)){
            if (empty($where))
            {
                $where  ="DATE_FORMAT(created,'%Y-%m-%d') <= '{$end}'";
            }else{
                $where .=" AND DATE_FORMAT(created,'%Y-%m-%d') <= '{$end}'";
            } 
        }
        $this->get_review(1,$where);
        $this->cache_data('review_filter', $where);
        echo $this->load->view ('lists',$this->page_data);
     }
 
    /**
     * @修改仲裁
     */
    public function modify_arbitration(){
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        $data=trim($this->input->post('data'));
        if(empty($data)){
            $this->errors='修改失败！';
            $this->return_status(0, $this->errors);
        }
        $data = json_decode($data,true);
        $this->load->model('order_model', 'order');
        $oid = $data['id_orders'];
        $modify = array(
            'cpt_comment'=>$data['comment'],
            'cpt_result'=>$data['result']
        );
        $where = "o.order_no = {$data['out_trade_no']}"; 
        $order_list=$this->order->get_order_list($where,1,0);
        if($data['result']==1){
            //1：付款给卖家
            $username = empty($order_list[0]['vendor_username'])?$order_list[0]['vendor_nickname']:$order_list[0]['vendor_username'];
            $nickname = $order_list[0]['vendor_nickname'];
            $role = '卖家';
            $uid = $order_list[0]['vendor'];
        }elseif($data['result']==2){
            //2：付款给买家
            $username = empty($order_list[0]['buyer_username'])?$order_list[0]['buyer_nickname']:$order_list[0]['buyer_username'];
            $nickname = $order_list[0]['buyer_nickname'];
            $role = '买家';
            $uid = $order_list[0]['buyer'];
    
        }
        $this->load->model('finance_model','finance');
        $auditing = array(
            'id_2buser'=>$uid,
            'role'=>$role,
            'username'=>$username,
            'nickname'=>$nickname,
            'result'=>$data['result'],
            'comment'=>$data['comment'],
            'operator'=>$this->users['realname'],
            'created'=>date('Y-m-d H:i:s', time()),
        );
        $where = array('id_auditing'=>$data['id_auditing']);
        //2.3.4auditing 投诉处理订单审核记录
        $res1 = $this->finance->modify_auditing($auditing,$where);
        if($res1){
            //仲裁，仲裁，记录仲裁结果 修改记录。
            $res2=$this->order->modify_order($modify,$oid);
            if($res2){
                $this->return_status(1,'修改成功！');
            }
        }
        $this->return_status(0,'修改失败！');
    }
 
    /**
     * @审核通过
     */
    public function approve(){
        
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        $data=trim($this->input->post('data'));
        if(empty($data)){
            $this->errors='审核失败！';
            $this->return_status(0, $this->errors);
        }
        $data = json_decode($data,true);
        $this->load->model('finance_model','finance');
        $this->load->model('order_model', 'order');
        $finance = array(
            'id_2buser'=>$data['id_2buser'],
            'order_no'=>$data['out_trade_no'],//交易订单编号
            'sum'=>$data['sum'],
            'status'=>0,//0:待结算 
            'comment'=>0,//0：投诉仲裁处理
            'order_created'=>$data['order_created'],
            'created'=>date('Y-m-d H:i:s', time()),
        );
        $res1=$this->finance->insert_finance($finance);
        if($res1){
            $auditing = array(
                'status'=>1,
                'operator'=>$this->users['realname'],
            );
            $where = array('id_auditing'=>$data['id_auditing']);
            //2.3.4auditing 投诉处理订单审核记录
            $res2 = $this->finance->modify_auditing($auditing,$where);
            if($res2){
                $oid = $data['id_orders'];
                $modify = array(
                    'status'=>4 //仲裁完成。待审核。审核通过即可仲裁完成4
                );
                //仲裁，仲裁，记录仲裁结果 修改记录。
                $res3=$this->order->modify_order($modify,$oid);
                if($res3){
                    $this->return_status(1,'审核通过！');
                }
            }
        }
        $this->return_status(0,'审核失败！');
    }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
    
   
 }
?>