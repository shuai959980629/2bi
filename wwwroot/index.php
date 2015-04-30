<?php
/**
 * 项目入口文件
 * @auther zhoushuai
 */
$starttime = microtime(true);
define('APPNAME', 'bibi');
//加载共用的入口文件
//引入公用的入口文件
require_once '../common/index.php';
//定义当前项目的名称
$application_folder = 'service';
//定义当前项目的路径
define('APPPATH',ROOT_PATH.$application_folder.'/');
//驱动框架运行
require_once BASEPATH.'core/CodeIgniter.php';
?>