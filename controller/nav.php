<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2016/11/4
 * Time: 下午11:48
 */
include 'library/init.inc.php';
$operation = 'add|edit|delete';
$action = 'list|add|edit';

$act = check_action($action, getGET('act'), 'list');
$opera = check_action($operation, getPOST('opera'));
$template = 'nav/';
//===========================================================================

//添加导航
if( 'add' == $opera ) {
    $nav_data = array(
        'title' => trim(getPOST('title')),
        'parent_id' => intval(getPOST('parent_id')),
        'url' => trim(getPOST('url')),
        'sort' => intval(getPOST('sort')),
        'position' => trim(getPOST('position')),
    );

    $parent_nav = null;
    //新增导航条
    $ajax_response = array('error' => -1, 'message' => '');

    if('' == $nav_data['title']) {
        $ajax_response['message'] .= '-请填写导航标题'.BR;
    } else {
        $nav_data['title'] = $db->escape(htmlspecialchars($nav_data['title']));
    }

    if(0 > $nav_data['parent_id']) {
        $ajax_response['message'] .= '-请选择父级导航栏'.BR;
    } else {
        if($nav_data['parent_id'] > 0) {
            $parent_nav_conditions = array(
                'id' => $nav_data['parent_id']
            );

            $parent_nav = $db->get('nav', $parent_nav_conditions);

            if(empty($parent_nav)) {
                $ajax_response['message'] .= '-父级导航栏不存在'.BR;
            } else {
                //跟父级的位置保持一致
                $nav_data['position'] = $parent_nav['position'];
                //深度检测
                $tmp_arr = explode(',', $parent_nav['path']);

                if(count($tmp_arr) > 3) {
                    $ajax_response['message'] .= '-导航栏层级数不能超过2级'.BR;
                }
            }
        }
    }

    if('' == $nav_data['url']) {
        $ajax_response['message'] .= '-请填写URL'.BR;
    } else {
        $nav_data['url'] = $db->escape($nav_data['url']);
    }

    if(false === strpos('middle|top|bottom', $nav_data['position'])) {
        $nav_data['position'] = 'middle';
    } else {
        $nav_data['position'] = $db->escape($nav_data['position']);
    }

    $nav_data['sort'] = $nav_data['sort'] < 0 ? 50 : $nav_data['sort'];

    if($ajax_response['message'] == '') {
        if ($db->auto_insert('nav', array($nav_data))) {
            $nav_id = $db->get_last_id();
            $nav_path = $nav_id.',';

            if(!empty($parent_nav)) {
                $nav_path = $parent_nav['path'].$nav_path;
            }

            $nav_data = array(
                'path' => $nav_path
            );

            $db->auto_update('nav', $nav_data, '`id`='.$nav_id);

            $ajax_response['error'] = 0;
            $ajax_response['message'] = '新增导航栏成功';
        } else {
            $ajax_response['message'] = '新增导航栏失败，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//编辑导航
if( 'edit' == $opera ) {
    $nav_data = array(
        'title' => trim(getPOST('title')),
        'parent_id' => intval(getPOST('parent_id')),
        'url' => trim(getPOST('url')),
        'sort' => intval(getPOST('sort')),
        'position' => trim(getPOST('position')),
    );

    $parent_nav = null;
    $ajax_response = array('error' => -1, 'message' => '');

    $id = intval(getPOST('id'));

    $nav_conditions = array(
        'id' => $id
    );

    if($id <= 0) {
        $ajax_response['message'] .= '-参数错误'.BR;
    } else {
        $nav = $db->get('nav', $nav_conditions);

        if(empty($nav)) {
            $ajax_response['message'] .= '-导航栏不存在'.BR;
        }
    }

    if('' == $nav_data['title']) {
        $ajax_response['message'] .= '-请填写导航标题'.BR;
    } else {
        $nav_data['title'] = $db->escape(htmlspecialchars($nav_data['title']));
    }

    if(0 > $nav_data['parent_id']) {
        $ajax_response['message'] .= '-请选择父级导航栏'.BR;
    } else {
        if($nav_data['parent_id'] > 0) {
            $parent_nav_conditions = array(
                'id' => $nav_data['parent_id']
            );

            $parent_nav = $db->get('nav', $parent_nav_conditions);

            if(empty($parent_nav)) {
                $ajax_response['message'] .= '-父级导航栏不存在'.BR;
            } else {
                //跟父级的位置保持一致
                $nav_data['position'] = $parent_nav['position'];
                //深度检测
                $tmp_arr = explode(',', $parent_nav['path']);

                if(count($tmp_arr) > 3) {
                    $ajax_response['message'] .= '-导航栏层级数不能超过2级'.BR;
                }

                $nav_data['path'] = $parent_nav['path'].$id.',';
            }
        } else {
            $nav_data['path'] = $id.',';
        }
    }

    if('' == $nav_data['url']) {
        $ajax_response['message'] .= '-请填写URL'.BR;
    } else {
        $nav_data['url'] = $db->escape($nav_data['url']);
    }

    if(false === strpos('middle|top|bottom', $nav_data['position'])) {
        $nav_data['position'] = 'middle';
    } else {
        $nav_data['position'] = $db->escape($nav_data['position']);
    }

    $nav_data['sort'] = $nav_data['sort'] < 0 ? 50 : $nav_data['sort'];

    if($ajax_response['message'] == '') {
        if ($db->auto_update('nav', $nav_data, '`id`='.$id)) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] = '编辑导航栏成功';
        } else {
            $ajax_response['message'] = '编辑导航栏失败，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//删除导航栏
if('delete' == $opera) {
    $ajax_response = array('error' => -1, 'message' => '');

    $id = intval(getPOST('id'));

    $nav_conditions = array(
        'id' => $id
    );

    if($id <= 0) {
        $ajax_response['message'] .= '-参数错误'.BR;
    } else {
        $nav = $db->get('nav', $nav_conditions);

        if(empty($nav)) {
            $ajax_response['message'] .= '-导航栏不存在'.BR;
        }
    }

    $check_children = 'select count(*) from '.$db->table('nav').' where `parent_id`='.$id;

    if($db->fetch_one($check_children)) {
        $ajax_response['message'] .= '-请先删除二级导航栏'.BR;
    }

    if($ajax_response['message'] == '') {
        if ($db->auto_delete('nav', '`id`='.$id)) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] = '删除导航栏成功';
        } else {
            $ajax_response['message'] = '删除导航栏失败，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//=============================================================================
if('list' == $act) {
    $_P['page']['title'] = '导航栏设置';
    $position = check_action('top|middle|bottom', getGET('position'), 'middle');

    $nav_list = array();

    $get_nav_list = 'select * from '.$db->table('nav').' where `position`=\''.$position.'\' order by sort asc';

    $nav_list_arr = $db->fetch_all($get_nav_list);

    if($nav_list_arr) {
        foreach($nav_list_arr as $nav) {
            $position = $nav['position'];
            $parent_id = $nav['parent_id'];

            if(!isset($nav_list[$position])) {
                $nav_list[$position] = array();
            }

            if(!isset($nav_list[$position][$parent_id])) {
                $nav_list[$position][$parent_id] = array();
            }

            $nav_list[$position][$parent_id][] = $nav;
        }
    }

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '导航栏设置', 'url' => 'nav.php'),
    );

    $smarty->assign('breadcrumb', $breadcrumb);
    $smarty->assign('nav_list', $nav_list);
    $smarty->assign('position', $position);
}

if('add' == $act) {
    $_P['page']['title'] = '新增导航栏';
    $position = check_action('top|middle|bottom', getGET('position'), 'middle');

    $nav_list = array();

    $get_nav_list = 'select * from '.$db->table('nav').' where `parent_id`=0 order by sort asc';

    $nav_list = $db->fetch_all($get_nav_list);

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '导航栏设置', 'url' => 'nav.php'),
        array('name' => '新增导航栏', 'url' => 'nav.php?act=add'),
    );

    $smarty->assign('breadcrumb', $breadcrumb);
    $smarty->assign('nav_list', $nav_list);
    $smarty->assign('position', $position);
}

if('edit' == $act) {
    $_P['page']['title'] = '编辑导航栏-';

    $id = intval(getGET('id'));

    if($id <= 0) {
        message('参数错误', '', 'error');
    }

    $nav = $db->get('nav', array('id'=>$id));

    if(empty($nav)) {
        message('导航栏不存在', '', 'error');
    }

    $_P['page']['title'] .= $nav['title'];

    $nav_list = array();

    $get_nav_list = 'select * from '.$db->table('nav').' where `parent_id`=0 and `id`!='.$id.' order by sort asc';

    $nav_list = $db->fetch_all($get_nav_list);

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '导航栏设置', 'url' => 'nav.php'),
        array('name' => '编辑导航栏', 'url' => ''),
    );

    $smarty->assign('nav', $nav);
    $smarty->assign('breadcrumb', $breadcrumb);
    $smarty->assign('nav_list', $nav_list);
    $smarty->assign('position', $nav['position']);
}

$smarty->assign('_P', $_P);
$template .= $act.'.phtml';
$smarty->display($template);