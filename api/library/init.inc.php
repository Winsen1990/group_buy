<?php
/**
 * 初始化程序
 * @author winsen
 * @version 1.0.0
 * @date 2015-01-09
 */
header('Content-type: application/json;charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

//设置系统相关参数
date_default_timezone_set('Asia/Shanghai');
define('ROOT_PATH', str_replace('api/library/init.inc.php', '',str_replace('\\', '/', __FILE__)));
define('BASE_DIR', str_replace($_SERVER['DOCUMENT_ROOT'], '', ROOT_PATH));

if(!class_exists('AutoLoader'))
{
    include(ROOT_PATH.'/library/AutoLoader.class.php');
}

$loader = AutoLoader::getInstance();
$configs = array('script_path'=>ROOT_PATH.'library/', 'class_path'=>ROOT_PATH.'library/', 'plugins_path'=>ROOT_PATH.'plugins/');
$loader->set_configs($configs);

$interface_list = array();
$loader->include_interface($interface_list);
$class_list = array('Smarty', 'Logs', 'MySQL', 'Http', 'Utils');
$loader->include_classes($class_list);
$script_list = array('configs','functions','lang');
$loader->include_scripts($script_list);
$plugins_document = array();

global $plugins_config;
foreach($plugins_config as $plugin=>$enable) {
    if($enable == 'on') {
        $plugins_document[] = $plugin;
    }
}
$loader->include_plugins($plugins_document);

//初始化数据库链接
global $db;
$db = MySQL::get_instance();

$debug_mode = true;//开启此项将关闭Smarty缓存模式，并开启日志跟踪
//初始化日志对象
global $log;
$log_file = date('Ymd').'.log';
$log = new Logs($debug_mode, $log_file, '../logs', 'controller');

global $utils;
$utils = Utils::get_instance();

global $response;
$response = ['error'=>0, 'message'=>'no request'];

$utils->request($_POST);

if(empty($utils->request)) {
    echo $utils->response($response);
}