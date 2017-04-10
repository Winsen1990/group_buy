<?php
include 'library/init.inc.php';
global $db, $smarty, $_P;
$loader->include_classes('CategoryDAO');
$categoryDAO = new CategoryDAO();

$template = 'category/';

$action = 'edit|add|list|delete';
$operation = 'edit|add|delete';

$act = check_action($action, getGET('act'), 'list');

$opera = check_action($operation, getPOST('opera'));
//===========================================================================
//添加商品分类
if( 'add' == $opera ) {
    $station_id = 1;
    $name = trim(getPOST('name'));
    $parent_id = intval(getPOST('parent_id'));
    $sort = intval(getPOST('sort'));

    $ajax_response = array('error' => -1, 'message' => '');

    if('' == $name) {
        $ajax_response['message']  .= '-请填写商品分类名称'.BR;
    } else {
        $name = $db->escape($name);
    }

    if(0 > $parent_id) {
        $ajax_response['message'] .= '-请选择上级分类'.BR;
    }

    if($sort < 0) {
        $sort = 50;
    }

    if($ajax_response['message'] == '') {
        if ($categoryDAO->add($name, $station_id, $parent_id, $sort)) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] .= '商品分类-' . $name . '-添加成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//编辑商品分类
if( 'edit' == $opera ) {
    $id = getPOST('id');
    $id = intval($id);
    $station_id = 1;
    $name = trim(getPOST('name'));
    $parent_id = intval(getPOST('parent_id'));
    $sort = intval(getPOST('sort'));

    $ajax_response = array('error' => -1, 'message' => '');

    if(0 >= $id) {
        $ajax_response['message'] .= '-参数错误'.BR;
    } else {
        if(!$categoryDAO->get('`id`='.$id)) {
            $ajax_response['message'] .= '-商品分类不存在'.BR;
        }
    }

    if('' == $name) {
        $ajax_response['message']  .= '-请填写商品分类名称'.BR;
    } else {
        $name = $db->escape($name);
    }

    if(0 > $parent_id) {
        $ajax_response['message'] .= '-请选择上级商品分类'.BR;
    }

    if($sort < 0) {
        $sort = 50;
    }

    if($ajax_response['message'] == '') {
        $categoryDAO->name = $name;
        $categoryDAO->parent_id = $parent_id;
        $categoryDAO->sort = $sort;

        if ($categoryDAO->save()) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] .= '商品分类-' . $name . '-修改成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//删除商品分类
if( 'delete' == $opera ) {
    $ajax_response = array('error' => -1, 'message' => '');
    $id = getPOST('id');
    $id = intval($id);

    if(0 >= $id) {
        $ajax_response['message'] .= '-参数错误'.BR;
    } else {
        $check_category = 'select `id` from ' . $db->table('category') . ' where `parent_id`=' . $id;
        $section = $db->fetch_all($check_category);
        if ($section) {
            $ajax_response['message'] .= '-当前商品分类下有其他分类，请先删除或移走子分类'.BR;
        }
    }

    if($ajax_response['message'] == '') {
        if ($categoryDAO->delete('`id`='.$id)) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] = '删除商品分类成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}
//===========================================================================

//商品分类列表
if( 'list' == $act ) {
    $get_category_list = 'select * from '.$db->table('category').' where 1  order by `sort` ASC,`path` ASC';
    $category_list = $db->fetch_all($get_category_list);

    if($category_list) {
        foreach($category_list as &$section) {
            $depth = explode(',', $section['path']);
            $count = count($depth);
            if($count > 2) {
                $temp = '|--'.$section['name'];
                while($count--) {
                    $temp = '&nbsp;&nbsp;&nbsp;&nbsp;'.$temp;
                }

                $section['name'] = $temp;
            }
        }
    }

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '商品分类管理', 'url' => 'category.php')
    );

    $_P['page']['title'] = '商品分类管理';

    $smarty->assign('category_list', $category_list);
    $smarty->assign('breadcrumb', $breadcrumb);
    $smarty->assign('sectionList', $category_list);
}

//添加商品分类
if( 'add' == $act ) {
    $get_category_list = 'select * from '.$db->table('category').' where 1 order by `path` ASC';
    $category_list = $db->fetch_all($get_category_list);

    if($category_list) {
        foreach($category_list as &$_category) {
            $count = count(explode(',', $_category['path']));
            if($count > 1) {
                $temp = '|--'.$_category['name'];
                while($count--) {
                    $temp = '&nbsp;&nbsp;'.$temp;
                }

                $_category['name'] = $temp;
            }
        }
    }

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '商品分类管理', 'url' => 'category.php'),
        array('name' => '新增商品分类管理', 'url' => 'category.php?act=add')
    );

    $_P['page']['title'] = '新增商品分类';

    $smarty->assign('breadcrumb', $breadcrumb);
    $smarty->assign('category_list', $category_list);
}

//编辑商品分类
if( 'edit' == $act ) {
    $id = getGET('id');
    $id = intval($id);

    if( 0 >= $id ) {
        show_system_message('参数错误', array());
        exit;
    }

    $get_category = 'select * from '.$db->table('category').' where `id`='.$id.' limit 1';
    $category = $db->fetch_row($get_category);

    if( empty($category) ) {
        show_system_message('商品分类不存在', array());
        exit;
    }

    $smarty->assign('category', $category);

    $get_category_list = 'select * from '.$db->table('category').' where `path` not like \''.$category['path'].'%\'  order by `path` ASC';
    $category_list = $db->fetch_all($get_category_list);

    if($category_list) {
        foreach($category_list as &$_category) {
            $count = count(explode(',', $_category['path']));
            if($count > 1) {
                $temp = '|--'.$_category['name'];
                while($count--) {
                    $temp = '&nbsp;&nbsp;'.$temp;
                }

                $_category['name'] = $temp;
            }
        }
    }

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '商品分类管理', 'url' => 'category.php'),
        array('name' => '修改商品分类', 'url' => 'category.php?act=edit&id='.$id)
    );

    $_P['page']['title'] = '修改商品分类-'.$category['name'];

    $smarty->assign('breadcrumb', $breadcrumb);
    $smarty->assign('category_list', $category_list);
}

$smarty->assign('_P', $_P);
$template .= $act.'.phtml';
$smarty->display($template);