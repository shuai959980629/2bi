<?php
if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
/**
 *@后台管理-财务管理
 *@version v-1.0
 *@author zhoushuai
 *@copyright 2014-06-18
 */
class Finance extends Admin_Controller{

	
	
    private $alipay_config;
    
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * @财务处理
     */
    public function index() {
	    $this->page_data['title']='邻售后台财务处理';
        $this->page_data['current']='finance';
        $where = '';
        $this->get_finance(1,$where);
        $this->cache_data('all', $where);
        $this->cache->memcached->delete('filter');
        $this->cache->memcached->delete('query');
        $this->load->view ('finance',$this->page_data);
	}
    
    
     /**
     * @获取财务列表
     * @author zhoushuai
     * @param int  offset ：页码
     * @param int  page ：条数
     * @param string  where:查询条件
     */
    private function get_finance($offset,$where,$page=0){
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        //每页显示数量
        $page = $page ? $page : 8;
        $this->load->model('finance_model', 'finance');
        //财务列表
        $finance_list=$this->finance->get_finance_list($where,$page,$page*($offset-1));
        //获取财务总数
        $finance_count = count($this->finance->get_finance_list($where,0,0));
        //分页代码
        $page_html = $this->get_page($finance_count, $offset, 'finance_list_page','method',$page);
        
        $this->page_data['finance_list'] = $finance_list;
        $this->page_data['page_html'] = $page_html;
        $this->page_data['page_type']='finance';
    }
 
    /**
     * @获取财务列表分页
     * @author zhoushuai
     * @param int  offset ：页码
     * @param int  page ：条数
     * @param string  where:查询条件
     */
    public function finance_list(){
        $offset = $this->input->post('offset') ? $this->input->post('offset') : 1;//页码
        $type = $this->input->post('type');
        $where = $this->get_session_data($type);
        $this->get_finance($offset,$where);
        echo $this->load->view ('lists',$this->page_data);
    }
    
    /**
     * @查询财务
     */
     public function query_finance(){
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
            case 'out_trade_no':
                $where = array('f.order_no'=>$key);
                break;
        }
        $this->get_finance(1,$where);
        $this->cache_data('query', $where);
        echo $this->load->view ('lists',$this->page_data);
     }
    
    public function filter_finance(){
        $status=trim($this->input->post('status'));
        $end=$this->input->post('end');
        $begin=$this->input->post('begin');
        $where = '';
        if(isset($status)){
            if($status!=-1){
                $where = "f.status =  {$status}";
            }
        }
        if(!empty($begin)){
            if (empty($where))
            {
                $where  ="DATE_FORMAT(f.created,'%Y-%m-%d') >= '{$begin}'";
            }else{
                $where .=" AND DATE_FORMAT(f.created,'%Y-%m-%d') >= '{$begin}'";
            }
        }
        if(!empty($end)){
            if (empty($where))
            {
                $where  ="DATE_FORMAT(f.created,'%Y-%m-%d') <= '{$end}'";
            }else{
                $where .=" AND DATE_FORMAT(f.created,'%Y-%m-%d') <= '{$end}'";
            } 
        }
        $this->get_finance(1,$where);
        $this->cache_data('filter', $where);
        echo $this->load->view ('lists',$this->page_data);
    }
    
    /**
     * @今日结算
     * @点击今日用户结算，则筛选出从本日至前3日内和大于3日，
     * @需要结算预付款给卖家的款项和运营/客服 投诉仲裁处理后提交需退款/打款给卖家/买家的款项。
     * //上周
     * $mon = date('Y-m-d', strtotime('-1 week Sunday -6 days')); 
     * $sun = date('Y-m-d', strtotime('-1 week Sunday'));
     */
    
    public function todayFinance(){ 
        //前几天时间
        $day = date('Y-m-d', strtotime('-3 days'));
        $today = date('Y-m-d',time());
        $where  ="DATE_FORMAT(f.created,'%Y-%m-%d') <= '{$day}' AND (f.status=2 OR f.status=0)";
        $this->get_finance(1,$where);
        $this->cache_data('today', $where);
        echo $this->load->view ('lists',$this->page_data);
    }
    
    
    
    
    
    
    /**
     *@单笔订单结算操作
     */
    public function settle(){
       $financeStr=trim($this->input->post('finance'));
       $finance = json_decode($financeStr,true);
       $this->load->model('finance_model', 'finance');
       $where=array('id_finance'=>$finance['fid']);
       $result = $this->finance->select_finance($where);
       $trade_no = empty($result['trade_no'])?create_trade_no():$result['trade_no'];
       $batch[0] = array(
            'fid'=>$finance['fid'],//订单账务id
            'sum'=>$finance['sum'],//单笔交易金额
            'trade_no'=>$trade_no,//流水号
            'alipay_account'=>$finance['alipay_account'],//收款方的支付宝帐号
            'alipay_name'=>$finance['alipay_name'],//收款方的支付宝姓名
            'comment'=>$this->get_comment($finance['comment'])//单笔交易支付备注说明
       ); 
       $this->return_status(1,'成功',$this->submit_batch($batch));
    }
    
    /**
     * @批量结算
     */
    public function batch_pay(){
        $finance = $batch = array();
        $financeStr=trim($this->input->post('finance'));
        $financeList= explode('|',$financeStr);
        for($i=0;$i<count($financeList);$i++){
            $finance[] = json_decode($financeList[$i],true);
        }
        $this->load->model('finance_model', 'finance');
        for($i=0;$i<count($finance);$i++){
            $where=array('id_finance'=>$finance[$i]['fid']);
            $result = $this->finance->select_finance($where);
            $trade_no = empty($result['trade_no'])?create_trade_no():$result['trade_no'];
            $batch[] = array(
                'fid'=>$finance[$i]['fid'],//订单账务id
                'sum'=>$finance[$i]['sum'],//单笔交易金额
                'trade_no'=>$trade_no,//流水号
                'alipay_account'=>$finance[$i]['alipay_account'],//收款方的支付宝帐号
                'alipay_name'=>$finance[$i]['alipay_name'],//收款方的支付宝姓名
                'comment'=>$this->get_comment($finance[$i]['comment'])//单笔交易支付备注说明
            );
        }
        $this->return_status(1,'成功',$this->submit_batch($batch));
        
    }
    
     
    /**
     * @第一步：
     * @根据支付宝参数。记录产生的每笔账务订单交易号-流水号
     * @param $batch array 批量支付订单数组
     */ 
    private function rec_trade_no($batch){
        $this->load->model('finance_model', 'finance');
        for($i=0;$i<count($batch);$i++){
            $data=array('trade_no'=>$batch[$i]['trade_no']);
            $where=array('id_finance'=>$batch[$i]['fid']);
            $batch[$i]['state']=$this->finance->modify_finance($data,$where);
        }
        return $batch;
    }
    
    /**
     * @第二步：
     * @构造要请求支付宝的参数数组
     * @param $batch array 批量支付订单数组
     */
    private function create_param($batch){
        
        //服务器异步通知页面路径
        $notify_url = "http://".DOMAIN_URL."pay/notify.html";
        
        //付款当天日期:格式：年[4位]月[2位]日[2位]，如：20100801
        $pay_date = date('Ymd',time());
        
        //批次号
        $batch_no = create_batch_no();
         
        //付款总金额
        $batch_fee = $this->get_batch_fee($batch);
        //必填，即参数detail_data的值中所有金额的总和

        //付款笔数
        $batch_num = count($batch);
        //必填，即参数detail_data的值中，“|”字符出现的数量加1，最大支持1000笔（即“|”字符出现的数量999个）
        
        //付款详细数据
        $detail_data = $this->create_detail_data($batch);
        
        //请求参数数组     
        $parameter = array(
        		"service" => "batch_trans_notify",
        		"partner" => trim($this->alipay_config['partner']),
        		"notify_url"	=> $notify_url,
        		"email"	=> $this->alipay_config['email'],
        		"account_name"	=> $this->alipay_config['account_name'],
        		"pay_date"	=> $pay_date,
        		"batch_no"	=> $batch_no,
        		"batch_fee"	=> $batch_fee,
        		"batch_num"	=> $batch_num,
        		"detail_data"	=> $detail_data,
        		"_input_charset"	=> trim(strtolower($this->alipay_config['input_charset']))
        );
        return $parameter;
    }
    
    /**
     * @第三步：
     * @提交参数到支付宝。支付
     * @param $batch array 批量支付订单数组
     */
    private function submit_batch($batch){
        //获取支付配置
        $this->alipay_config = _get_alipay_config();
        //更换签名验证MD5
        $this->alipay_config['sign_type'] = 'MD5';
        //根据支付宝参数。记录产生的每笔账务订单交易号-流水号
        $param = $this->rec_trade_no($batch);

        //构造要请求支付宝的参数数组
        $parameter = $this->create_param($param);

        //提交参数到支付宝。支付 页面跳转
        $this->load->library('alipaysubmit', $this->alipay_config,'alisubmit');
        $html_text = $this->alisubmit->buildRequestForm($parameter,"post", "确认");
        return $html_text;
    }
    
    
    /**
     * @付款详细数据
     * @格式：流水号1^收款方帐号1^真实姓名^付款金额1^备注说明1|流水号2^收款方帐号2^真实姓名^付款金额2^备注说明2....
     */
    private function create_detail_data($batch){
        $detail_data ='';
        for($i=0;$i<count($batch);$i++){
            if($batch[$i]['state']){
               $detail_data = $detail_data."{$batch[$i]['trade_no']}^{$batch[$i]['alipay_account']}^{$batch[$i]['alipay_name']}^{$batch[$i]['sum']}^{$batch[$i]['comment']}|"; 
            }
        }
        //$detail_data = substr($detail_data,0,count($detail_data)-2);
        return $detail_data;
    }
    
    /**
     * @获取财务支出备注
     * 0：投诉仲裁处理，1：正常交易（来源）,2:取消订单
     */
    private function get_comment($comment){
        switch($comment){
             case 0:
                return '投诉仲裁处理';
                break;
             case 1:
                return '正常交易完成';
                break;  
             case 2:
                return '卖家取消订单';
                break;
        }
    }
    
    /**
     *@获取付款总金额
     */
    private function get_batch_fee($batch){
        $batch_fee = 0;
        for($i=0;$i<count($batch);$i++){
            $batch_fee=$batch_fee+$batch[$i]['sum'];
        }
        return $batch_fee;
    }
    
    
    public function manage(){
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        $fid=trim($this->input->post('fid'));
        $curStatu=trim($this->input->post('curStatu'));
        $status=trim($this->input->post('status'));
        if(!isset($fid)||!isset($curStatu)||!isset($status)){
            $this->errors='操作失败！';
            $this->return_status(0, $this->errors);
        }
        if($curStatu==$status){
            $this->return_status(1,'财务记录状态没有发生变动！');
        }
        $this->load->model('finance_model', 'finance');
        $where = array('id_finance'=>$fid);
        $data = array('status'=>$status);//状态：0:待结算,1:支付宝处理中,2:结算失败,3:已结算
        $res2 = $this->finance->modify_finance($data,$where);
        if($res2){
            $this->return_status(1,'修改成功！');
        }else{
            $this->errors='修改失败！';
            $this->return_status(0, $this->errors);  
        }
    }
    
    
    
    
    
                         
    
   
 }
 ?>