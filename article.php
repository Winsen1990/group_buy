<?php
/**
 * 内容页
 * @author winsen
 * @version 1.0.0
 * @date 2015-07-29
 */
include 'library/init.inc.php';

global $db, $smarty;

$id = intval(getGET('id'));

$template = 'article.phtml';

$get_article = 'select `id`,`title`,`author`,`add_time`,`content`,`keywords`,`desc`,`section_id` from '.
               $db->table('article').' where `id`='.$id;

$article = $db->fetch_row($get_article);

if($article)
{
    $article['add_time'] = date('Y-m-d', $article['add_time']);

    $get_section = 'select `id`,`name`,`parent_id` from '.$db->table('section').' where `id`='.$article['section_id'];
    $section = $db->fetch_row($get_section);

    $get_article_list = 'select `id`,`title`,`content` from '.$db->table('article').' where `section_id`='.$article['section_id'];
    $article_list = $db->fetch_all($get_article_list);
    $smarty->assign('article_list', $article_list);

    $_P['page']['title'] = $article['title'];
} else {
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');
    header('Location: 404.php');
    exit;
}

$smarty->assign('_P', $_P);
$smarty->assign('id', $id);
$smarty->assign('section', $section);
$smarty->assign('article', $article);
$smarty->assign('page_title', $article['title']);
$smarty->display($template);
