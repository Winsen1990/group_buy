<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2016/11/4
 * Time: 下午11:48
 */
include 'library/init.inc.php';
global $db, $smarty, $_P;

$operation = 'add|edit|delete';
$action = 'list|add';

$act = check_action($action, getGET('act'), 'list');
$opera = check_action($operation, getPOST('opera'));
$template = 'sysconf/';
//===========================================================================

//添加系统配置
if( 'add' == $opera ) {
    $conf_data = array(
        'title' => trim(getPOST('title')),
        'key' => trim(getPOST('key')),
        'type' => trim(getPOST('type')),
        'group' => trim(getPOST('group')),
    );

    //新增系统配置条
    $ajax_response = array('error' => -1, 'message' => '');

    if('' == $conf_data['title']) {
        $ajax_response['message'] .= '-请填写参数名称'.BR;
    } else {
        $conf_data['title'] = $db->escape(htmlspecialchars($conf_data['title']));
    }

    if('' == $conf_data['key']) {
        $ajax_response['message'] .= '-请填写参数标识'.BR;
    } else {
        $conf_data['key'] = $db->escape($conf_data['key']);
    }

    if('' == $conf_data['type']) {
        $ajax_response['message'] .= '-请选择参数类型'.BR;
    } else {
        $conf_data['type'] = $db->escape($conf_data['type']);
    }

    if('' == $conf_data['group']) {
        $ajax_response['message'] .= '-请选择参数组'.BR;
    } else {
        $conf_data['group'] = $db->escape($conf_data['group']);
    }

    if($ajax_response['message'] == '') {
        if ($db->auto_insert('sysconf', array($conf_data))) {

            $ajax_response['error'] = 0;
            $ajax_response['message'] = '新增系统配置栏成功';
        } else {
            $ajax_response['message'] = '新增系统配置栏失败，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//修改参数
if('edit' == $opera) {
    $conf_data = array(
        'value' => getPOST('value')
    );

    $key = getPOST('key');

    $ajax_response = array('error' => -1, 'message' => '');

    if($key == '') {
        $ajax_response['message'] .= '-参数错误'.BR;
    } else {
        $key = $db->escape($key);
    }

    if($conf_data['value'] == '') {
        $ajax_response['message'] .= '-请填写参数值'.BR;
    } else {
        $conf_data['value'] = $db->escape($conf_data['value']);
    }

    if($ajax_response['message'] == '') {
        if($db->auto_update('sysconf', $conf_data, '`key`=\''.$key.'\'')) {
            $ajax_response['message'] = '参数修改成功';
            $ajax_response['error'] = 0;
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//=============================================================================
if('list' == $act) {
    $_P['page']['title'] = '系统配置栏设置';
    $group = check_action('config', getGET('group'), 'config');

    $config_list = array();

    $get_config_list = 'select * from '.$db->table('sysconf').' order by `group`';

    $config_list = $db->fetch_all($get_config_list);

    //设置路径系统配置
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '系统配置栏设置', 'url' => 'sysconf.php'),
    );

    $smarty->assign('group', $group);
    $smarty->assign('breadcrumb', $breadcrumb);
    $smarty->assign('config_list', $config_list);
}

if('add' == $act) {
    $_P['page']['title'] = '新增系统配置栏';
    $group = check_action('config', getGET('group'), 'config');

    //设置路径系统配置
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '系统配置栏设置', 'url' => 'sysconf.php'),
        array('name' => '新增系统配置栏', 'url' => 'sysconf.php?act=add'),
    );

    $smarty->assign('group', $group);
    $smarty->assign('breadcrumb', $breadcrumb);
}

$smarty->assign('_P', $_P);
$template .= $act.'.phtml';
$smarty->display($template);