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
}

$get_article_list = 'select `title`,`id`,`desc` from '.$db->table('article').' where `section_id`='.$id;

$article_list = $db->fetch_all($get_article_list);

$_P['page']['title'] = $section['name'];

$smarty->assign('_P', $_P);
$smarty->assign('section', $section);
$smarty->assign('article_list', $article_list);
$smarty->display($template);
