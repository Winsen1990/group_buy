<?php
/**
 * 初始化程序
 * @author winsen
 * @version 1.0.0
 * @date 2015-01-09
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

//设置系统相关参数
date_default_timezone_set('Asia/Shanghai');
define('ROOT_PATH', str_replace('controller/library/init.inc.php', '',str_replace('\\', '/', __FILE__)));
define('BASE_DIR', str_replace($_SERVER['DOCUMENT_ROOT'], '', ROOT_PATH));
define('BR', '<br/>');

if(!class_exists('AutoLoader'))
{
    include(ROOT_PATH.'/library/AutoLoader.class.php');
}

$loader = AutoLoader::getInstance();
$configs = array('script_path'=>ROOT_PATH.'library/', 'class_path'=>ROOT_PATH.'library/', 'plugins_path'=>ROOT_PATH.'plugins/');
$loader->set_configs($configs);

$interface_list = array();
$loader->include_interface($interface_list);
$class_list = array('Smarty', 'Logs', 'MySQL', 'Code', 'Http', 'Wechat', 'WechatException', 'BaseDAO', 'WXResponseDAO');
$class_list[] = 'WXRuleDAO';
$loader->include_classes($class_list);
$script_list = array('configs','functions','lang', 'menu');
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

//初始化smarty对象
global $smarty;
$smarty = new Smarty();
$smarty->setCompileDir('data/compiles');
$smarty->setTemplateDir('themes/default');
$smarty->setCacheDir('data/caches');
//$smarty->testInstall();

//Debug模式下每次都强制编译输出
if($debug_mode)
{
    $smarty->clearAllCache();
    $smarty->clearCompiledTemplate();
    $smarty->force_compile = true;
}

$smarty->assign('theme_dir', 'themes/default');
$smarty->assign('menus', $menus);

//
global $_P;
$_P['page'] = array(
    'title' => 'DY CMS',
    'copyright' => 'Copyright &copy; JKDZSW',
);

if(!isset($_SESSION['login_fail'])) {
    $_SESSION['login_fail'] = 0;
}

function show_system_message($message, $context) {
    echo $message;
}