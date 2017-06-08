<?php
/**
 * 栏目页
 * @author winsen
 * @version 1.0.0
 * @date 2015-07-29
 */
include 'library/init.inc.php';

global $db, $smarty;

$template = 'search.phtml';

$keyword = urldecode(getGET('keyword'));
$type = trim(getGET('type'));

$type = check_action('article|product', $type, 'article');
$keyword = $db->escape($keyword);

//设置路径导航
$breadcrumb = array(
    array('name' => '首页', 'url' => 'index.php'),
    array('name' => '搜索', 'url' => '')
);
$smarty->assign('breadcrumb', $breadcrumb);

$smarty->assign('sub_nav', array('title' => '搜索', 'url' => '', 'nav_list' => array()));

$page = intval(getGET('page'));

if($page <= 0) {
    $page = 1;
}

$step = 10;
$offset = ($page - 1) * $step;

$total_page = 1;

switch($type) {
    case 'product':
        break;

    case 'article':
        $get_article_count = 'select count(*) from '.$db->table('article').' where `title` like \'%'.$keyword.'%\' and `status`=1';
        $article_count = $db->fetch_one($get_article_count);

        $total_page = ceil($article_count/$step);

        if($page > $total_page) {
            $page = $total_page;
        }

        $get_article_list = 'select `title`,`id`,`add_time` from '.$db->table('article').' where `title` like \'%'.$keyword.'%\' and `status`=1 order by `add_time` desc limit '.$offset.','.$step;

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
        $smarty->assign('article_list', $article_list);
        break;
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

$smarty->assign('current', $page);
$smarty->assign('total_page', $total_page);
$smarty->assign('page_list', $page_list);
$smarty->assign('_P', $_P);
$smarty->assign('keyword', $keyword);
$smarty->assign('type', $type);
$smarty->display($template);
