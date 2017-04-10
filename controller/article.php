<?php
include 'library/init.inc.php';
global $db, $smarty, $_P;

$loader->include_classes('ArticleDAO');
$articleDAO = new ArticleDAO();

$template = 'article/';

$action = 'edit|add|list|delete';
$operation = 'edit|add|delete';

$act = check_action($action, getGET('act'), 'list');

$opera = check_action($operation, getPOST('opera'));
//===========================================================================
//添加资讯
if( 'add' == $opera ) {
    $station_id = 1;
    $title = trim(getPOST('title'));
    $section_id = intval(getPOST('section_id'));
    $desc = getPOST('desc');
    $keywords = getPOST('keywords');
    $author = getPOST('author');
    $content = getPOST('content');
    $wap_content = getPOST('wap_content');
    $cover = getPOST('cover');
    $thumb = getPOST('thumb');
    $sort = intval(getPOST('sort'));
    $status = intval(getPOST('status'));

    $ajax_response = array('error' => -1, 'message' => '');

    if('' == $title) {
        $ajax_response['message']  .= '-请填写资讯标题'.BR;
    }

    if(0 > $section_id) {
        $ajax_response['message'] .= '-请选择栏目'.BR;
    }

    if('' == $desc) {
        $ajax_response['message'] .= '-请填写简介'.BR;
    }

    if('' == $keywords) {
        $ajax_response['message'] .= '-请填写关键词'.BR;
    }

    if('' == $author) {
        $author = $_SESSION['name'];
    }

    if('' == $content) {
        $ajax_response['message'] .= '-请填写资讯内容'.BR;
    }

    if('' == $wap_content) {
        $wap_content = $content;
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

    if($status < 0) {
        $status = 0;
    }

    if($ajax_response['message'] == '') {
        if ($articleDAO->add($title, $section_id, $desc, $keywords, $author, $content, $wap_content, $status, $station_id, $cover, $thumb, $sort)) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] .= '资讯-' . $title . '-添加成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//编辑资讯
if( 'edit' == $opera ) {
    $id = getPOST('id');
    $id = intval($id);
    $station_id = 1;
    $title = trim(getPOST('title'));
    $section_id = intval(getPOST('section_id'));
    $desc = getPOST('desc');
    $keywords = getPOST('keywords');
    $author = getPOST('author');
    $content = getPOST('content');
    $wap_content = getPOST('wap_content');
    $cover = getPOST('cover');
    $thumb = getPOST('thumb');
    $sort = intval(getPOST('sort'));
    $status = intval(getPOST('status'));

    $ajax_response = array('error' => -1, 'message' => '');

    if(0 >= $id) {
        $ajax_response['message'] .= '-参数错误'.BR;
    } else if(!$articleDAO->get('`id`='.$id)) {
        $ajax_response['message'] .= '-资讯不存在'.BR;
    }

    if('' == $title) {
        $ajax_response['message']  .= '-请填写资讯标题'.BR;
    }

    if(0 > $section_id) {
        $ajax_response['message'] .= '-请选择栏目'.BR;
    }

    if('' == $desc) {
        $ajax_response['message'] .= '-请填写简介'.BR;
    }

    if('' == $keywords) {
        $ajax_response['message'] .= '-请填写关键词'.BR;
    }

    if('' == $author) {
        $author = $_SESSION['name'];
    }

    if('' == $content) {
        $ajax_response['message'] .= '-请填写资讯内容'.BR;
    }

    if('' == $wap_content) {
        $wap_content = $content;
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

    if($status < 0) {
        $status = 0;
    }

    if($ajax_response['message'] == '') {
        $articleDAO->title = $title;
        $articleDAO->section_id = $section_id;
        $articleDAO->desc = $desc;
        $articleDAO->keywords = $keywords;
        $articleDAO->author = $author;
        $articleDAO->content = $content;
        $articleDAO->wap_content = $wap_content;
        $articleDAO->cover = $cover;
        $articleDAO->thumb = $thumb;
        $articleDAO->sort = $sort;
        $articleDAO->status = $status;

        if ($articleDAO->save()) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] .= '资讯-' . $title . '-修改成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//删除资讯
if( 'delete' == $opera ) {
    $ajax_response = array('error' => -1, 'message' => '');
    $id = getPOST('id');
    $id = intval($id);

    if(0 >= $id) {
        $ajax_response['message'] .= '-参数错误'.BR;
    }

    if($ajax_response['message'] == '') {
        if ($articleDAO->delete('`id`='.$id)) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] = '删除资讯成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}
//===========================================================================

//资讯列表
if( 'list' == $act ) {
    $get_article_list = 'select a.*,s.`name` as `section_name` from '.$db->table('article').' as a left join '.$db->table('section').' as s '.
                        ' on s.`id`=a.`section_id` where 1  order by a.`last_modify` DESC, a.`sort` ASC';
    $article_list = $db->fetch_all($get_article_list);

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '资讯管理', 'url' => 'section.php')
    );

    $_P['page']['title'] = '资讯管理';

    $smarty->assign('article_list', $article_list);
    $smarty->assign('breadcrumb', $breadcrumb);
}

//添加资讯
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
        array('name' => '资讯管理', 'url' => 'article.php'),
        array('name' => '新增资讯', 'url' => 'article.php?act=add')
    );

    $_P['page']['title'] = '新增资讯';

    $smarty->assign('breadcrumb', $breadcrumb);
    $smarty->assign('section_list', $section_list);
}

//编辑资讯
if( 'edit' == $act ) {
    $id = getGET('id');
    $id = intval($id);

    if( 0 >= $id ) {
        show_system_message('参数错误', array());
        exit;
    }

    $get_article = 'select * from '.$db->table('article').' where `id`='.$id.' limit 1';
    $article = $db->fetch_row($get_article);

    if( empty($article) ) {
        show_system_message('资讯不存在', array());
        exit;
    }

    $smarty->assign('article', $article);

    $get_section_list = 'select * from '.$db->table('section').'  order by `path` ASC';
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
        array('name' => '资讯管理', 'url' => 'article.php'),
        array('name' => '修改资讯', 'url' => 'article.php?act=edit&id='.$id)
    );

    $_P['page']['title'] = '修改资讯-'.$article['title'];

    $smarty->assign('breadcrumb', $breadcrumb);
    $smarty->assign('section_list', $section_list);
}

$smarty->assign('_P', $_P);
$template .= $act.'.phtml';
$smarty->display($template);