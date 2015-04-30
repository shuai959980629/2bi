<?php
/**
 * 零售首页
 * @auther zhoushuai
 */
$starttime = microtime(true);
define('APPNAME', 'home');
//加载共用的入口文件
//引入公用的入口文件
require_once '../../common/index.php';
//定义当前项目的名称
$application_folder = 'home';
//定义当前项目的路径
define('APPPATH',ROOT_PATH.$application_folder.'/');
//驱动框架运行
require_once BASEPATH.'core/CodeIgniter.php';


?>