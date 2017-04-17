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
define('ROOT_PATH', str_replace('library/init.inc.php', '',str_replace('\\', '/', __FILE__)));
define('BASE_DIR', str_replace($_SERVER['DOCUMENT_ROOT'], '', ROOT_PATH));

if(!class_exists('AutoLoader'))
{
    include('AutoLoader.class.php');
}

$loader = AutoLoader::getInstance();
$configs = array('script_path'=>ROOT_PATH.'library/', 'class_path'=>ROOT_PATH.'library/');
$loader->set_configs($configs);

$interface_list = array();
$loader->include_interface($interface_list);
$class_list = array('Smarty', 'Logs', 'MySQL', 'BaseDAO');
$loader->include_classes($class_list);
$script_list = array('configs','functions','lang');
$loader->include_scripts($script_list);
$plugins_document = array();
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
$log = new Logs($debug_mode, $log_file);

$config_list = $db->get_all('sysconf');
$sysconf_mapping = array();
if($config_list) {
    foreach($config_list as $config) {
        $sysconf_mapping[$config['key']] = $config['value'];
    }
}
unset($config_list);

//初始化smarty对象
global $smarty;
$smarty = new Smarty();
$smarty->setCompileDir(ROOT_PATH.'data/compiles');
$smarty->setTemplateDir(ROOT_PATH.'themes/'.$sysconf_mapping['theme']);
$smarty->setCacheDir(ROOT_PATH.'data/cache');

//Debug模式下每次都强制编译输出
if($debug_mode)
{
    $smarty->clearAllCache();
    $smarty->clearCompiledTemplate();
    $smarty->force_compile = true;
}

$smarty->assign('config', $sysconf_mapping);
$smarty->assign('template_path', BASE_DIR.'themes/'.$sysconf_mapping['theme']);

global $_P;
$_P['page'] = array(
    'title' => '',
    'copyright' => 'Copyright &copy; '.$sysconf_mapping['copyright'],
);

$nav_list = $db->get_all('nav', array('parent_id' => 0), array(), '`path` ASC,`sort` ASC');
$nav_mapping = array();
if($nav_list) {
    foreach($nav_list as $nav) {
        if(!isset($nav_mapping[$nav['position']])) {
            $nav_mapping[$nav['position']] = array();
        }

        $nav_mapping[$nav['position']][] = $nav;
    }
}

$smarty->assign('nav_list', $nav_mapping);
