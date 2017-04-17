<?php
include 'library/init.inc.php';
global $db, $smarty, $_P;

$template = 'ad/';

$action = 'edit|add|list|delete';
$operation = 'edit|add|delete';

$act = check_action($action, getGET('act'), 'list');

$opera = check_action($operation, getPOST('opera'));
//===========================================================================
//添加广告
if( 'add' == $opera ) {
    $station_id = 1;
    $alt = trim(getPOST('alt'));
    $ad_pos_id = intval(getPOST('ad_pos_id'));
    $img = getPOST('img');
    $url = getPOST('url');
    $sort = intval(getPOST('sort'));

    $ajax_response = array('error' => -1, 'message' => '');

    if('' == $alt) {
        $ajax_response['message']  .= '-请填写广告名称'.BR;
    } else {
        $alt = $db->escape($alt);
    }

    if(0 > $ad_pos_id) {
        $ajax_response['message'] .= '-请选择广告位置'.BR;
    }

    if('' == $img) {
        $ajax_response['message'] .= '-请选择广告图片'.BR;
    }

    if('' == $url) {
        $ajax_response['message'] .= '-请选择广告链接'.BR;
    }

    if($sort < 0) {
        $sort = 50;
    }

    if($ajax_response['message'] == '') {
        $ad_data = array(
            'alt' => $alt,
            'url' => $url,
            'img' => $img,
            'sort' => $sort,
            'ad_pos_id' => $ad_pos_id
        );
        if ($db->auto_insert('ad', array($ad_data))) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] .= '广告-' . $alt . '-添加成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//编辑广告
if( 'edit' == $opera ) {
    $id = getPOST('id');
    $id = intval($id);
    $station_id = 1;
    $alt = trim(getPOST('alt'));
    $ad_pos_id = intval(getPOST('ad_pos_id'));
    $img = getPOST('img');
    $url = getPOST('url');
    $sort = intval(getPOST('sort'));

    $ajax_response = array('error' => -1, 'message' => '');

    if(0 >= $id) {
        $ajax_response['message'] .= '-参数错误'.BR;
    } else {
        if(!$db->get('ad', array('id' => $id))) {
            $ajax_response['message'] .= '-广告不存在'.BR;
        }
    }

    if('' == $alt) {
        $ajax_response['message']  .= '-请填写广告名称'.BR;
    } else {
        $alt = $db->escape($alt);
    }

    if(0 > $ad_pos_id) {
        $ajax_response['message'] .= '-请选择广告位置'.BR;
    }

    if('' == $img) {
        $ajax_response['message'] .= '-请选择广告图片'.BR;
    }

    if('' == $url) {
        $ajax_response['message'] .= '-请选择广告链接'.BR;
    }

    if($sort < 0) {
        $sort = 50;
    }

    if($ajax_response['message'] == '') {
        $ad_data = array(
            'alt' => $alt,
            'url' => $url,
            'img' => $img,
            'sort' => $sort,
            'ad_pos_id' => $ad_pos_id
        );

        if ($db->auto_update('ad', $ad_data, '`id`='.$id)) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] .= '广告-' . $alt . '-修改成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//删除广告
if( 'delete' == $opera ) {
    $ajax_response = array('error' => -1, 'message' => '');
    $id = getPOST('id');
    $id = intval($id);

    if(0 >= $id) {
        $ajax_response['message'] .= '-参数错误'.BR;
    }

    if($ajax_response['message'] == '') {
        if ($db->auto_delete('ad','`id`='.$id)) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] = '删除广告成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}
//===========================================================================

//广告列表
if( 'list' == $act ) {
    $get_ad_list = 'select a.*,b.pos_name from '.$db->table('ad').' as a left join '.
                   $db->table('ad_position').' as b on b.id=a.ad_pos_id';
    $ad_list = $db->fetch_all($get_ad_list);

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '广告管理', 'url' => 'ad.php')
    );

    $_P['page']['title'] = '广告管理';

    $smarty->assign('ad_list', $ad_list);
    $smarty->assign('breadcrumb', $breadcrumb);
}

//添加广告
if( 'add' == $act ) {
    $get_ad_pos_list = 'select * from '.$db->table('ad_position');
    $ad_pos_list = $db->fetch_all($get_ad_pos_list);

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '广告管理', 'url' => 'ad.php'),
        array('name' => '新增广告管理', 'url' => 'ad.php?act=add')
    );

    $_P['page']['title'] = '新增广告';

    $smarty->assign('breadcrumb', $breadcrumb);
    $smarty->assign('ad_pos_list', $ad_pos_list);
}

//编辑广告
if( 'edit' == $act ) {
    $id = getGET('id');
    $id = intval($id);

    if( 0 >= $id ) {
        show_system_message('参数错误', array());
        exit;
    }

    $get_ad = 'select * from '.$db->table('ad').' where `id`='.$id.' limit 1';
    $ad = $db->fetch_row($get_ad);

    if( empty($ad) ) {
        show_system_message('广告不存在', array());
        exit;
    }

    $smarty->assign('ad', $ad);

    $get_ad_pos_list = 'select * from '.$db->table('ad_position');
    $ad_pos_list = $db->fetch_all($get_ad_pos_list);

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '广告管理', 'url' => 'ad.php'),
        array('name' => '修改广告', 'url' => 'ad.php?act=edit&id='.$id)
    );

    $_P['page']['title'] = '修改广告-'.$ad['alt'];

    $smarty->assign('breadcrumb', $breadcrumb);
    $smarty->assign('ad_pos_list', $ad_pos_list);
}

$smarty->assign('_P', $_P);
$template .= $act.'.phtml';
$smarty->display($template);
