<?php
include 'library/init.inc.php';
global $db, $smarty, $_P;

$loader->include_classes('BrandDAO');
$brandDAO = new BrandDAO();

$template = 'brand/';

$action = 'edit|add|list|delete';
$operation = 'edit|add|delete';

$act = check_action($action, getGET('act'), 'list');

$opera = check_action($operation, getPOST('opera'));
//===========================================================================
//添加品牌
if( 'add' == $opera ) {
    $station_id = 1;
    $name = trim(getPOST('name'));
    $desc = getPOST('desc');
    $keywords = getPOST('keywords');
    $content = getPOST('content');
    $wap_content = getPOST('wap_content');
    $logo = getPOST('logo');
    $sort = intval(getPOST('sort'));
    $status = intval(getPOST('status'));

    $ajax_response = array('error' => -1, 'message' => '');

    if('' == $name) {
        $ajax_response['message']  .= '-请填写品牌名称'.BR;
    }

    if('' == $desc) {
        $ajax_response['message'] .= '-请填写品牌简介'.BR;
    }

    if('' == $keywords) {
        $ajax_response['message'] .= '-请填写关键词'.BR;
    }

    if('' == $content) {
        $ajax_response['message'] .= '-请填写品牌内容'.BR;
    }

    if('' == $wap_content) {
        $wap_content = $content;
    }

    if('' == $logo) {
        $ajax_response['message'] .= '-请选择缩略图'.BR;
    }

    if($sort < 0) {
        $sort = 50;
    }

    if($status < 0) {
        $status = 0;
    }

    if($ajax_response['message'] == '') {
        if ($brandDAO->add($name, $desc, $keywords, $content, $wap_content, $status, $station_id, $logo, $sort)) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] .= '品牌-' . $name . '-添加成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//编辑品牌
if( 'edit' == $opera ) {
    $id = getPOST('id');
    $id = intval($id);
    $station_id = 1;
    $name = trim(getPOST('name'));
    $desc = getPOST('desc');
    $keywords = getPOST('keywords');
    $content = getPOST('content');
    $wap_content = getPOST('wap_content');
    $logo = getPOST('logo');
    $sort = intval(getPOST('sort'));
    $status = intval(getPOST('status'));

    $ajax_response = array('error' => -1, 'message' => '');

    if(0 >= $id) {
        $ajax_response['message'] .= '-参数错误'.BR;
    } else if(!$brandDAO->get('`id`='.$id)) {
        $ajax_response['message'] .= '-品牌不存在'.BR;
    }

    if('' == $name) {
        $ajax_response['message']  .= '-请填写品牌名称'.BR;
    }

    if('' == $desc) {
        $ajax_response['message'] .= '-请填写品牌简介'.BR;
    }

    if('' == $keywords) {
        $ajax_response['message'] .= '-请填写关键词'.BR;
    }

    if('' == $content) {
        $ajax_response['message'] .= '-请填写品牌内容'.BR;
    }

    if('' == $wap_content) {
        $wap_content = $content;
    }

    if('' == $logo) {
        $ajax_response['message'] .= '-请选择缩略图'.BR;
    }

    if($sort < 0) {
        $sort = 50;
    }

    if($status < 0) {
        $status = 0;
    }

    if($ajax_response['message'] == '') {
        $brandDAO->name = $name;
        $brandDAO->desc = $desc;
        $brandDAO->keywords = $keywords;
        $brandDAO->content = $content;
        $brandDAO->wap_content = $wap_content;
        $brandDAO->logo = $logo;
        $brandDAO->sort = $sort;
        $brandDAO->status = $status;

        if ($brandDAO->save()) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] .= '品牌-' . $name . '-修改成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//删除品牌
if( 'delete' == $opera ) {
    $ajax_response = array('error' => -1, 'message' => '');
    $id = getPOST('id');
    $id = intval($id);

    if(0 >= $id) {
        $ajax_response['message'] .= '-参数错误'.BR;
    }

    if($ajax_response['message'] == '') {
        if ($brandDAO->delete('`id`='.$id)) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] = '删除品牌成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}
//===========================================================================

//品牌列表
if( 'list' == $act ) {
    $get_brand_list = 'select * from '.$db->table('brand').' where 1  order by `last_modify` DESC, `sort` ASC';
    $brand_list = $db->fetch_all($get_brand_list);

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '品牌管理', 'url' => 'brand.php')
    );

    $_P['page']['name'] = '品牌管理';

    $smarty->assign('brand_list', $brand_list);
    $smarty->assign('breadcrumb', $breadcrumb);
}

//添加品牌
if( 'add' == $act ) {
    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '品牌管理', 'url' => 'brand.php'),
        array('name' => '新增品牌', 'url' => 'brand.php?act=add')
    );

    $_P['page']['name'] = '新增品牌';

    $smarty->assign('breadcrumb', $breadcrumb);
}

//编辑品牌
if( 'edit' == $act ) {
    $id = getGET('id');
    $id = intval($id);

    if( 0 >= $id ) {
        show_system_message('参数错误', array());
        exit;
    }

    $get_brand = 'select * from '.$db->table('brand').' where `id`='.$id.' limit 1';
    $brand = $db->fetch_row($get_brand);

    if( empty($brand) ) {
        show_system_message('品牌不存在', array());
        exit;
    }

    $smarty->assign('brand', $brand);

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '品牌管理', 'url' => 'brand.php'),
        array('name' => '修改品牌', 'url' => 'brand.php?act=edit&id='.$id)
    );

    $_P['page']['name'] = '修改品牌-'.$brand['name'];

    $smarty->assign('breadcrumb', $breadcrumb);
}

$smarty->assign('_P', $_P);
$template .= $act.'.phtml';
$smarty->display($template);