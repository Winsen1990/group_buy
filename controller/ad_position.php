<?php
include 'library/init.inc.php';
global $db, $smarty, $_P;

$template = 'ad_position/';

$action = 'edit|add|list|delete';
$operation = 'edit|add|delete';

$act = check_action($action, getGET('act'), 'list');

$opera = check_action($operation, getPOST('opera'));
//===========================================================================
//添加广告位置
if( 'add' == $opera ) {
    $station_id = 1;
    $pos_name = trim(getPOST('pos_name'));
    $width = intval(getPOST('width'));
    $height = intval(getPOST('height'));

    $ajax_response = array('error' => -1, 'message' => '');

    if('' == $pos_name) {
        $ajax_response['message']  .= '-请填写广告位置'.BR;
    } else {
        $pos_name = $db->escape($pos_name);
    }

    if(0 > $width) {
        $ajax_response['message'] .= '-请填写宽度'.BR;
    }

    if($height < 0) {
        $ajax_response['message'] .= '-请填写高度'.BR;
    }

    if($ajax_response['message'] == '') {
        $ad_data = [
            'pos_name' => $pos_name,
            'height' => $height,
            'width' => $width
        ];
        if ($db->auto_insert('ad_position', [$ad_data])) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] .= '广告位置-' . $pos_name . '-添加成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//编辑广告位置
if( 'edit' == $opera ) {
    $id = getPOST('id');
    $id = intval($id);
    $station_id = 1;
    $pos_name = trim(getPOST('pos_name'));
    $width = intval(getPOST('width'));
    $height = intval(getPOST('height'));

    $ajax_response = array('error' => -1, 'message' => '');

    if(0 >= $id) {
        $ajax_response['message'] .= '-参数错误'.BR;
    } else {
        if(!$db->get('ad_position', array('id' => $id))) {
            $ajax_response['message'] .= '-广告位置不存在'.BR;
        }
    }

    if('' == $pos_name) {
        $ajax_response['message']  .= '-请填写广告位置'.BR;
    } else {
        $pos_name = $db->escape($pos_name);
    }

    if(0 > $width) {
        $ajax_response['message'] .= '-请填写宽度'.BR;
    }

    if($height < 0) {
        $ajax_response['message'] .= '-请填写高度'.BR;
    }

    if($ajax_response['message'] == '') {
        $ad_data = [
            'pos_name' => $pos_name,
            'height' => $height,
            'width' => $width
        ];

        if ($db->auto_update('ad_position', $ad_data, '`id`='.$id)) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] .= '广告位置-' . $pos_name . '-修改成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//删除广告位置
if( 'delete' == $opera ) {
    $ajax_response = array('error' => -1, 'message' => '');
    $id = getPOST('id');
    $id = intval($id);

    if(0 >= $id) {
        $ajax_response['message'] .= '-参数错误'.BR;
    }

    if($ajax_response['message'] == '') {
        if ($db->auto_delete('ad_position','`id`='.$id)) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] = '删除广告位置成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}
//===========================================================================

//广告位置列表
if( 'list' == $act ) {
    $get_ad_pos_list = 'select * from '.$db->table('ad_position');
    $ad_pos_list = $db->fetch_all($get_ad_pos_list);

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '广告位置管理', 'url' => 'ad_position.php')
    );

    $_P['page']['title'] = '广告位置管理';

    $smarty->assign('ad_pos_list', $ad_pos_list);
    $smarty->assign('breadcrumb', $breadcrumb);
}

//添加广告位置
if( 'add' == $act ) {
    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '广告位置管理', 'url' => 'ad_position.php'),
        array('name' => '新增广告位置', 'url' => 'ad_position.php?act=add')
    );

    $_P['page']['title'] = '新增广告';

    $smarty->assign('breadcrumb', $breadcrumb);
}

//编辑广告位置
if( 'edit' == $act ) {
    $id = getGET('id');
    $id = intval($id);

    if( 0 >= $id ) {
        show_system_message('参数错误', array());
        exit;
    }

    $get_ad_pos= 'select * from '.$db->table('ad_position').' where `id`='.$id.' limit 1';
    $ad_pos = $db->fetch_row($get_ad_pos);

    if( empty($ad_pos) ) {
        show_system_message('广告位置不存在', array());
        exit;
    }

    $smarty->assign('ad_pos', $ad_pos);

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '广告位置管理', 'url' => 'ad_position.php'),
        array('name' => '修改广告位置', 'url' => 'ad_position.php?act=edit&id='.$id)
    );

    $_P['page']['title'] = '修改广告位置-'.$ad_pos['pos_name'];

    $smarty->assign('breadcrumb', $breadcrumb);
}

$smarty->assign('_P', $_P);
$template .= $act.'.phtml';
$smarty->display($template);