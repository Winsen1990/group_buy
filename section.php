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

$get_article_list = 'select `title`,`id`,`add_time` from '.$db->table('article').' where `section_id`='.$id.' order by `add_time` desc';

$article_list = $db->fetch_all($get_article_list);

$_P['page']['title'] = $section['name'];

$smarty->assign('_P', $_P);
$smarty->assign('section', $section);
$smarty->assign('article_list', $article_list);
$smarty->display($template);
