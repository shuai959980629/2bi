<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @邻售后台支付
 * @author zhoushuai
 * @date 2014-08-04 9:30
 */
class Pay extends Admin_Controller 
{


    public function __construct()
    {
        parent::__construct();
    }
    
   
    
    /**
     * @支付宝批量支付完成服务器异步通知
     */
     public function notify(){
         /*
         $_POST= array (
                  'sign' => 'a20e08449bf9d2eb6743d6060817dad1',
                  'notify_time' => '2014-09-03 11:11:23',
                  'pay_user_id' => '2088311305072626',
                  'fail_details' => '1487873910903^18683434013^刘刚^0.01^F^ACCOUN_NAME_NOT_MATCH^20140903409312378^20140903111123|',
                  'pay_user_name' => '成都赏金猎人网络科技有限公司',
                  'sign_type' => 'MD5',
                  'notify_type' => 'batch_trans_notify',
                  'pay_account_no' => '20883113050726260156',
                  'notify_id' => '2f78cac852b46c8feb765e61cfb209akmo',
                  'batch_no' => '201409032743566',
           );
           */
		   $alipay_config = _get_alipay_config();
           //更换签名验证MD5
           $alipay_config['sign_type'] = 'MD5';
           
           $this->load->library('notify', $alipay_config);
           $verify_result = $this->notify->verifyNotify();
           if($verify_result){
                $this->load->model('finance_model', 'finance');
            	//批量付款数据中转账成功的详细信息
                if(key_exists('success_details',$_POST)&&$_POST['success_details']!=''){
                    $success_details = $_POST['success_details'];
                    //支付成功--
                    $this->handle_success($success_details);
                }
                //批量付款数据中转账失败的详细信息
                if(key_exists('fail_details',$_POST)&&$_POST['fail_details']!=''){
                    $fail_details = $_POST['fail_details'];
                    //支付失败
                    $this->handle_fail($fail_details);
                }
            	$log = $this->lang->line('pay_order');
                $_POST['operator']=$this->users['realname'];
                $_POST['date']=date('Y-m-d H:i:s', time());
                log_pay($log,$_POST);
                echo "success";	
           }else{
                $log = $this->lang->line('pay_debug');
                $_POST['operator']=$this->users['realname'];
                $_POST['date']=date('Y-m-d H:i:s', time());
                log_pay($log,$_POST);
                echo "fail";
           } 
     }
     
     
     /**
      * @结算失败：
      * @0:待结算,1:支付宝处理中,2:结算失败,3:已结算 
      */
     private function handle_fail($fail_details){
        $strade_no = $this->analyze_notify_details($fail_details);
        $len = count($strade_no);
        for($i=0;$i<$len;$i++){
            $where = array('trade_no'=>$strade_no[$i]);
            $finance = $this->finance->query_finance($where);
            if($finance && $finance[0]['status']!=3){
                $data = array('status'=>2,'stock_dater'=>date('Y-m-d H:i:s', time()));//2:结算失败
                $this->finance->modify_finance($data,$where);
            }
        }
     }
     
     /**
      * @结算成功
      * @0:待结算,1:支付宝处理中,2:结算失败,3:已结算 
      */    
     private function handle_success($success_details){
        $strade_no = $this->analyze_notify_details($success_details);
        $len = count($strade_no);
        for($i=0;$i<$len;$i++){
            $where = array('trade_no'=>$strade_no[$i]);
            $finance = $this->finance->query_finance($where);
            if($finance && $finance[0]['status']!=3){
                $data = array('status'=>3,'stock_dater'=>date('Y-m-d H:i:s', time()));//3:已结算
                $this->finance->modify_finance($data,$where);
            }
        }
     }
     
     /**
      * @分析异步通知返回的成功或失败的详情信息得到流水号
      */
     private function analyze_notify_details($details){
        $details = substr($details,0,count($details)-2);
        $detailsArray = explode('|',$details);
        $data = array();
        for($i=0;$i<count($detailsArray);$i++){
            $detlist= explode('^',$detailsArray[$i]);
            $data[] = $detlist[0];
        }
       return $data;
     }
     
    

   
}

/* End of file pay.php */
/* Location: ./admin/controllers/pay.php */
