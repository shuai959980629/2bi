<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$tcp_default=ENVIRONMENT;

$tcp['development']['hostname'] = '192.168.0.9';
$tcp['development']['port'] = '8002';

//测试环境
$tcp['testing']['hostname'] = '10.0.0.16';
$tcp['testing']['port'] = '8002';


//公网
$tcp['production']['hostname'] = '10.0.0.16';
$tcp['production']['port'] = '8001';