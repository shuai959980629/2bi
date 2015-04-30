<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @邻售支付-接口
 * @author zhoushuai
 * @date 2014-08-04 9:30
 */
class Pay extends Pay_Controller 
{


    public function __construct()
    {

        parent::__construct();
    }
    
    
    
    /**
     * 5.1.1.支付宝支付完成服务器异步通知
     */
     public function notify(){
        /* 
        $_POST =array (
              'discount' => '0.00',
              'payment_type' => '1',
              'subject' => '良品铺子周年庆，大放价啦！健脑，强身',
              'trade_no' => '2014081161083218',
              'buyer_email' => '18782901597',
              'gmt_create' => '2014-08-11 17:51:05',
              'notify_type' => 'trade_status_sync',
              'quantity' => '1',
              'out_trade_no' => '1493857560811',
              'seller_id' => '2088311305072626',
              'notify_time' => '2014-08-11 17:51:06',
              'body' => '良品铺子周年庆，大放价啦！健脑，强身',
              'trade_status' => 'TRADE_FINISHED',
              'is_total_fee_adjust' => 'N',
              'total_fee' => '0.01',
              'gmt_payment' => '2014-08-11 17:51:06',
              'seller_email' => 'nh@it008.com',
              'gmt_close' => '2014-08-11 17:51:06',
              'price' => '0.01',
              'buyer_id' => '2088502684077186',
              'notify_id' => '1940d73631d2ba085bbeff0dae352c1430',
              'use_coupon' => 'N',
              'sign_type' => 'RSA',
              'sign' => 'CR9jBnJoA0hnHPVaRajmPZwYC1U2tlabPvStmTlOs3WsrKVbSIwL9a1osOa72OIpXy9YDyYcZb5ETXAi+WMIiyAO4GjMdRyLd5XdBrXkhP0CE194sQCc5GLwjyAMvxx6NEGEMueXQOu+UTRYjMbGtk2A74WagTKtZyUxIca7p1w=',
            );
        
            $log = $this->lang->line('pay_debug');
            parent::log_pay($log,$_POST);
            trade_status交易状态String交易状态，取值范围请参见“11.3 交易状态”。可空TRADE_SUCCESS
            seller_id卖家支付宝用户号String(30)卖家支付宝账号对应的支付宝唯一用户号。以2088开头的纯16位数字。可空2088501624816263
            seller_email卖家支付宝账号String(100)卖家支付宝账号，可以是email和手机号码。可空alipayrisk18@alipay.com
            buyer_id买家支付宝用户号String(30)买家支付宝账号对应的支付宝唯一用户号。以2088开头的纯16位数字。可空2088602315385429
            buyer_email买家支付宝账号String(100)买家支付宝账号，可以是Email或手机号码。可空dlwdgl@gmail.com
          */
		   $alipay_config = _get_alipay_config();
           $this->load->library('notify', $alipay_config);
           $verify_result = $this->notify->verifyNotify();
           if($verify_result){
                //验证成功！
                $data = array(
                    'out_trade_no'=>$_POST['out_trade_no'],
                    'trade_no'=>$_POST['trade_no'],
                    'trade_status'=>$_POST['trade_status'],
                    'vendor_email'=>$_POST['seller_email'],
                    'buyer_email'=>$_POST['buyer_email']
                );
                $res = parent::_complete_pay($data);
                if($res){	
                    exit('success');
                }
           }
           $log = $this->lang->line('pay_debug');
           parent::log_pay($log,$_POST);
           exit('fail');
     }
    

   
}

/* End of file pay.php */
/* Location: ./service/controllers/pay.php */
