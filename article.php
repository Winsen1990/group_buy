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

$get_article = 'select `id`,`template`,`title`,`author`,`add_time`,`content`,`keywords`,`description`,`section_id` from '.
               $db->table('content').' where `id`='.$id;

$article = $db->fetchRow($get_article);

if($article)
{
    $article['add_time'] = date('Y-m-d H:i:s', $article['add_time']);

    $get_section = 'select `id`,`section_name`,`parent_id` from '.$db->table('section').' where `id`='.$article['section_id'];
    $section = $db->fetchRow($get_section);

    $section_list = array();

    if($section['parent_id'] > 0)
    {
        $get_parent_section = 'select `section_name`,`id` from '.$db->table('section').' where `id`='.$section['parent_id'];
        $parent_section = $db->fetchRow($get_parent_section);
        $section_list[] = $parent_section;

        $get_children_section = 'select `section_name`,`id` from '.$db->table('section').' where `parent_id`='.$section['parent_id'];
        $section_list = array_merge($section_list, $db->fetchAll($get_children_section));
    } else {
        $section_list[] = $section;
        $get_children_section = 'select `section_name`,`id` from '.$db->table('section').' where `parent_id`='.$section['id'];
        $section_list = array_merge($section_list, $db->fetchAll($get_children_section));
    }

    assign('section_list', $section_list);

    $get_article_list = 'select `id`,`title`,`content` from '.$db->table('content').' where `section_id`='.$article['section_id'];
    $article_list = $db->fetchAll($get_article_list);
    assign('article_list', $article_list);

    if($article['template'] != '')
    {
        $template = $article['template'];
    }
} else {
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');
    header('Location: 404.php');
    exit;
}

assign('id', $id);
assign('section', $section);
assign('article', $article);
assign('page_title', $article['title']);
$smarty->display($template);
