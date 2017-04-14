<?php
/**
 * 内容页
 * @author winsen
 * @version 1.0.0
 * @date 2015-07-29
 */
include 'library/init.inc.php';

$id = intval(getGET('id'));

$template = 'article.phtml';

$get_article = 'select `id`,`title`,`author`,`add_time`,`content`,`keywords`,`desc`,`section_id` from '.
               $db->table('article').' where `id`='.$id;

$article = $db->fetch_row($get_article);

if($article)
{
    $article['add_time'] = date('Y-m-d H:i:s', $article['add_time']);

    $get_section = 'select `id`,`name`,`parent_id` from '.$db->table('section').' where `id`='.$article['section_id'];
    $section = $db->fetch_row($get_section);

    $section_list = array();

    if($section['parent_id'] > 0)
    {
        $get_parent_section = 'select `name`,`id` from '.$db->table('section').' where `id`='.$section['parent_id'];
        $parent_section = $db->fetch_row($get_parent_section);
        $section_list[] = $parent_section;

        $get_children_section = 'select `name`,`id` from '.$db->table('section').' where `parent_id`='.$section['parent_id'];
        $children_section = $db->fetch_all($get_children_section);

        if($children_section) {
            $section_list = array_merge($section_list, $children_section);
        }
    } else {
        $section_list[] = $section;
        $get_children_section = 'select `name`,`id` from '.$db->table('section').' where `parent_id`='.$section['id'];

        $children_section = $db->fetch_all($get_children_section);
        if($children_section) {
            $section_list = array_merge($section_list, $children_section);
        }
    }

    $smarty->assign('section_list', $section_list);

    $get_article_list = 'select `id`,`title`,`content` from '.$db->table('content').' where `section_id`='.$article['section_id'];
    $article_list = $db->fetch_all($get_article_list);
    $smarty->assign('article_list', $article_list);
} else {
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');
    header('Location: 404.php');
    exit;
}

$smarty->assign('id', $id);
$smarty->assign('section', $section);
$smarty->assign('article', $article);
$smarty->assign('page_title', $article['title']);
$smarty->display($template);
