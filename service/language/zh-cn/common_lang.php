<?php

$lang['request_param_errors']			= "请求参数错误";


$lang['send_validation_code_by_mobile']			= "您的验证码是：%s。请不要把验证码泄露给其他人。";

$lang['current_member_is_bb_member'] = '已经是该哔哔的成员，不能重复加入';
$lang['mobile_validate_not_match_or_expirse'] = "手机号码和验证码不匹配或验证码已失效";
$lang['current_member_is_not_bb_member'] = '您还不是该哔哔的成员，不用退出';
$lang['is_not_bibi_author_not_opt'] = '您不是哔哔的创建者，不能进行该操作';
$lang['is_bibi_author_not_opt'] = '您是哔哔的创建者，不能进行该操作';

$lang['third_login_type_error'] = '第三方登陆类型错误';
$lang['third_login_param_error'] = '第三方登陆必要参数错误';

$lang['no_data'] = '没有数据返回';

$lang['pwd_error'] = '密码输入错误。';

$lang['business_forbidden'] = '该商家已被禁用，无法进行以下操作！';












//array(当前时间,客户端类型,请求接口,请求参数json,返回参数json)


$lang['debug'] = '
===============================================================================================================
DEBUG start | version: %s |执行时间：%s (ms)
===============================================================================================================
请求接口:%s
User-Agent:%s
请求参数(Json):%s
请求参数(Array):
%s
返回数据(Json):%s
返回数据(Array):
%s
==================================================debug end===================================================='."\r\n\r\n";

//支付宝支付调试
$lang['pay_debug'] = '
/**
 *===============================================================================================================
 *DEBUG_ALIPAY start | 支付宝支付 |执行时间：%s (ms)
 *===============================================================================================================
 *请求接口:%s
 *User-Agent:%s
 *支付宝支付完成服务器异步通知请求接口:/pay/notify
 *服务器异步通知参数返回数据(Array):
 */
 $data=%s;
 #==================================================debug end===================================================='."\r\n\r\n";



//线上同步支付成功
$lang['pay_order_syn'] = '
/**
 *===============================================================================================================
 *TRADE_Record_Online Synchronization | 同步支付成功 |执行时间：%s (ms)
 *===============================================================================================================
 *请求接口:%s
 *User-Agent:%s
 *返回交易订单数据(Array):
 */
 $data=%s;
 #==================================================TRADE_Synchronization  Record end===================================================='."\r\n\r\n";


//线上异步通知支付成功
$lang['pay_order'] = '
/**
 *===============================================================================================================
 *TRADE_Record_Online Successfully | 异步通知支付成功 |执行时间：%s (ms)
 *===============================================================================================================
 *请求接口:%s
 *User-Agent:%s
 *返回交易订单数据(Array):
 */
 $data=%s;
 #==================================================TRADE_Successfully  Record end===================================================='."\r\n\r\n";


//当面交易，线下支付成功。默认状态为已支付：2
$lang['pay_offline'] = '
/**
 *===============================================================================================================
 *TRADE_Record_Offline Successfully | 线下默认支付成功 |执行时间：%s (ms)
 *===============================================================================================================
 *请求接口:%s
 *User-Agent:%s
 *返回交易订单数据(Array):
 */
 $data=%s;
 #==================================================TRADE_Successfully  Record end===================================================='."\r\n\r\n";


//支付失败
$lang['pay_failed'] = '
/**
 *===============================================================================================================
 *TRADE_FAILED_Record start | 支付宝交易失败 |执行时间：%s (ms)
 *===============================================================================================================
 *请求接口:%s
 *User-Agent:%s
 *返回交易订单数据(Array):
 */
 $data=%s;
 #==================================================TRADE_FAILED  Record end===================================================='."\r\n\r\n";


//线上交易取消    
$lang['pay_cancel_online']='
/**
 *===============================================================================================================
 *TRADE_Record_Online Cancel | 线上交易取消 |执行时间：%s (ms)
 *===============================================================================================================
 *请求接口:%s
 *User-Agent:%s
 *返回交易订单数据(Array):
 */
 $data=%s;
 #==================================================TRADE_Cancel_Online  Record end===================================================='."\r\n\r\n";


//线下交易取消    
$lang['pay_cancel_offline']='
/**
 *===============================================================================================================
 *TRADE_Record_Offline Cancel | 线下交易取消 |执行时间：%s (ms)
 *===============================================================================================================
 *请求接口:%s
 *User-Agent:%s
 *返回交易订单数据(Array):
 */
 $data=%s;
 #==================================================TRADE_Cancel_Offline  Record end===================================================='."\r\n\r\n";

//线上交易完成
$lang['pay_finished_online']='
/**
 *===============================================================================================================
 *TRADE_Record_Online Finished | 线上交易完成 |执行时间：%s (ms)
 *===============================================================================================================
 *请求接口:%s
 *User-Agent:%s
 *返回交易订单数据(Array):
 */
 $data=%s;
 #==================================================TRADE_Finished_Online  Record end===================================================='."\r\n\r\n";
 
 
 //线下交易完成
 $lang['pay_finished_offline']='
/**
 *===============================================================================================================
 *TRADE_Record_Offline Finished | 线下交易完成 |执行时间：%s (ms)
 *===============================================================================================================
 *请求接口:%s
 *User-Agent:%s
 *返回交易订单数据(Array):
 */
 $data=%s;
 #==================================================TRADE_Finished_Offline  Record end===================================================='."\r\n\r\n";




/* End of file common_lang.php */
/* Location: ./language/zh-cn/common_lang.php */