<?php
include 'library/init.inc.php';
global $db, $smarty, $_P;
$loader->include_classes('SectionDAO');
$sectionDAO = new SectionDAO();

$template = 'section/';

$action = 'edit|add|list|delete';
$operation = 'edit|add|delete';

$act = check_action($action, getGET('act'), 'list');

$opera = check_action($operation, getPOST('opera'));
//===========================================================================
//添加栏目
if( 'add' == $opera ) {
    $station_id = 1;
    $name = trim(getPOST('name'));
    $parent_id = intval(getPOST('parent_id'));
    $cover = getPOST('cover');
    $thumb = getPOST('thumb');
    $sort = intval(getPOST('sort'));

    $ajax_response = array('error' => -1, 'message' => '');

    if('' == $name) {
        $ajax_response['message']  .= '-请填写栏目名称'.BR;
    } else {
        $name = $db->escape($name);
    }

    if(0 > $parent_id) {
        $ajax_response['message'] .= '-请选择上级栏目'.BR;
    }

    if('' == $cover) {
        $ajax_response['message'] .= '-请选择封面图片'.BR;
    }

    if('' == $thumb) {
        $ajax_response['message'] .= '-请选择缩略图'.BR;
    }

    if($sort < 0) {
        $sort = 50;
    }

    if($ajax_response['message'] == '') {
        if ($sectionDAO->add($name, $station_id, $cover, $thumb, $parent_id, $sort)) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] .= '栏目-' . $name . '-添加成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//编辑栏目
if( 'edit' == $opera ) {
    $id = getPOST('id');
    $id = intval($id);
    $station_id = 1;
    $name = trim(getPOST('name'));
    $parent_id = intval(getPOST('parent_id'));
    $cover = getPOST('cover');
    $thumb = getPOST('thumb');
    $sort = intval(getPOST('sort'));

    $ajax_response = array('error' => -1, 'message' => '');

    if(0 >= $id) {
        $ajax_response['message'] .= '-参数错误'.BR;
    } else {
        if(!$sectionDAO->get('`id`='.$id)) {
            $ajax_response['message'] .= '-栏目不存在'.BR;
        }
    }

    if('' == $name) {
        $ajax_response['message']  .= '-请填写栏目名称'.BR;
    } else {
        $name = $db->escape($name);
    }

    if(0 > $parent_id) {
        $ajax_response['message'] .= '-请选择上级栏目'.BR;
    }

    if('' == $cover) {
        $ajax_response['message'] .= '-请选择封面图片'.BR;
    }

    if('' == $thumb) {
        $ajax_response['message'] .= '-请选择缩略图'.BR;
    }

    if($sort < 0) {
        $sort = 50;
    }

    if($ajax_response['message'] == '') {
        $sectionDAO->name = $name;
        $sectionDAO->parent_id = $parent_id;
        $sectionDAO->sort = $sort;
        $sectionDAO->thumb = $thumb;
        $sectionDAO->cover = $cover;

        if ($sectionDAO->save()) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] .= '栏目-' . $name . '-修改成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//删除栏目
if( 'delete' == $opera ) {
    $ajax_response = array('error' => -1, 'message' => '');
    $id = getPOST('id');
    $id = intval($id);

    if(0 >= $id) {
        $ajax_response['message'] .= '-参数错误'.BR;
    } else {
        $check_section = 'select `id` from ' . $db->table('section') . ' where `parent_id`=' . $id;
        $section = $db->fetch_all($check_section);
        if ($section) {
            $ajax_response['message'] .= '-当前栏目下有子栏目，请先删除或移走子栏目'.BR;
        }

        if ($id == 1) {
            $ajax_response['message'] .= '-系统保留分类，不允许删除'.BR;
        }
    }

    if($ajax_response['message'] == '') {
        if ($sectionDAO->delete('`id`='.$id)) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] = '删除栏目成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}
//===========================================================================

//栏目列表
if( 'list' == $act ) {
    $get_section_list = 'select * from '.$db->table('section').' where 1  order by `sort` ASC,`path` ASC';
    $section_list = $db->fetch_all($get_section_list);

    if($section_list) {
        foreach($section_list as &$section) {
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
        array('name' => '栏目管理', 'url' => 'section.php')
    );

    $_P['page']['title'] = '栏目管理';

    $smarty->assign('section_list', $section_list);
    $smarty->assign('breadcrumb', $breadcrumb);
    $smarty->assign('sectionList', $section_list);
}

//添加栏目
if( 'add' == $act ) {
    $get_section_list = 'select * from '.$db->table('section').' where 1 order by `path` ASC';
    $section_list = $db->fetch_all($get_section_list);

    if($section_list) {
        foreach($section_list as &$section) {
            $count = count(explode(',', $section['path']));
            if($count > 1) {
                $temp = '|--'.$section['name'];
                while($count--) {
                    $temp = '&nbsp;&nbsp;'.$temp;
                }

                $section['name'] = $temp;
            }
        }
    }

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '栏目管理', 'url' => 'section.php'),
        array('name' => '新增栏目管理', 'url' => 'section.php?act=add')
    );

    $_P['page']['title'] = '新增栏目';

    $smarty->assign('breadcrumb', $breadcrumb);
    $smarty->assign('section_list', $section_list);
}

//编辑栏目
if( 'edit' == $act ) {
    $id = getGET('id');
    $id = intval($id);

    if( 0 >= $id ) {
        show_system_message('参数错误', array());
        exit;
    }

    $get_section = 'select * from '.$db->table('section').' where `id`='.$id.' limit 1';
    $section = $db->fetch_row($get_section);

    if( empty($section) ) {
        show_system_message('栏目不存在', array());
        exit;
    }

    $smarty->assign('section', $section);

    $get_section_list = 'select * from '.$db->table('section').' where `path` not like \''.$section['path'].'%\'  order by `path` ASC';
    $section_list = $db->fetch_all($get_section_list);

    if($section_list) {
        foreach($section_list as &$_section) {
            $count = count(explode(',', $_section['path']));
            if($count > 1) {
                $temp = '|--'.$_section['name'];
                while($count--) {
                    $temp = '&nbsp;&nbsp;'.$temp;
                }

                $_section['name'] = $temp;
            }
        }
    }

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '栏目管理', 'url' => 'section.php'),
        array('name' => '修改栏目', 'url' => 'section.php?act=edit&id='.$id)
    );

    $_P['page']['title'] = '修改栏目-'.$section['name'];

    $smarty->assign('breadcrumb', $breadcrumb);
    $smarty->assign('section_list', $section_list);
}

$smarty->assign('_P', $_P);
$template .= $act.'.phtml';
$smarty->display($template);