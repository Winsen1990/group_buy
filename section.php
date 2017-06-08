<?php
/**
 * 栏目页
 * @author winsen
 * @version 1.0.0
 * @date 2015-07-29
 */
include 'library/init.inc.php';

global $db, $smarty;

$id = intval(getGET('id'));
$template = 'section.phtml';

$get_section = 'select `id`,`name`,`parent_id`,`cover` from '.$db->table('section').' where `id`='.$id;

$section = $db->fetch_row($get_section);

if(!$section)
{
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');
    header('Location: 404.php');
    exit;
} else {
    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => $section['name'], 'url' => 'section.php?id='.$section['id'])
    );
    $smarty->assign('breadcrumb', $breadcrumb);

    $url = 'section.php?id='.$section['id'];
    $sub_nav = generate_sub_nav(array('title' => $section['name'], 'url' => $url));

    $smarty->assign('sub_nav', $sub_nav);
}

$page = intval(getGET('page'));

if($page <= 0) {
    $page = 1;
}

$step = 10;
$offset = ($page - 1) * $step;

$get_article_count = 'select count(*) from '.$db->table('article').' where `section_id`='.$id.' and `status`=1';
$article_count = $db->fetch_one($get_article_count);

$total_page = ceil($article_count/$step);

if($page > $total_page) {
    $page = $total_page;
}

$page_list = array();

if($total_page > 10) {
    $shift_count = $total_page - 10;

    $prev_count = floor($total_page - $shift_count)/2;
    $tail_count = ceil($total_page - $shift_count)/2;

    $page_list = range(1, $prev_count);
    array_push($page_list, '...');
    for($i = $total_page - $tail_count; $i <= $total_page; $i++) {
        array_push($page_list, $i);
    }
} else if ($total_page > 1) {
    $page_list = range(1, $total_page);
}

$get_article_list = 'select `title`,`id`,`add_time` from '.$db->table('article').' where `section_id`='.$id.' and `status`=1 order by `add_time` desc limit '.$offset.','.$step;

$article_list = $db->fetch_all($get_article_list);

if($article_list) {
    $newly = 3600 * 3;
    foreach($article_list as &$article) {
        if(time() - $article['add_time'] <= $newly) {
            $article['markup'] = 'new';
        } else {
            $article['markup'] = '';
        }
    }
}

$_P['page']['title'] = $section['name'];

$smarty->assign('current', $page);
$smarty->assign('total_page', $total_page);
$smarty->assign('page_list', $page_list);
$smarty->assign('_P', $_P);
$smarty->assign('section', $section);
$smarty->assign('article_list', $article_list);
$smarty->display($template);
