<?php
/**
 * 栏目页
 * @author winsen
 * @version 1.0.0
 * @date 2015-07-29
 */
include 'library/init.inc.php';

$id = intval(getGET('id'));
$page = intval(getGET('page'));
$template = 'article_list.phtml';

if($page <= 0)
{
    $page = 1;
}

$get_section = 'select `id`,`section_name`,`keywords`,`description`,`template`,`parent_id` from '.$db->table('section').' where `id`='.$id;

$section = $db->fetchRow($get_section);

if(!$section)
{
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');
    header('Location: 404.php');
    exit;
}

if($section['template'] != '')
{
    $template = $section['template'];
}

$section_list = array();
$section_id_str = $id;

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
if($section['parent_id'] == 0)
{
    foreach($section_list as $sc)
    {
        $section_id_str .=','.$sc['id'];
    }
}

$get_total_count = 'select count(*) from '.$db->table('content').' where `section_id` in ('.$section_id_str.')';
$total_count = $db->fetchOne($get_total_count);

$total_page = intval($total_count/$config['section_step']);

if($total_count%$config['section_step'])
{
    $total_page++;
}

if($page > $total_page)
{
    $page = $total_page;
}

$limit = ($page - 1)*$config['section_step'].', '.$config['section_step'];

$get_article_list = 'select `title`,`id`,`content` from '.$db->table('content').' where `section_id` in ('.$section_id_str.')';

$article_list = $db->fetchAll($get_article_list);

$script = preg_replace('/\&page=\d+$/', '', $_SERVER['REQUEST_URI']);
assign('script', $script);
assign('page', $page);
assign('total_page', $total_page);
assign('section', $section);
assign('article_list', $article_list);
assign('page_title', $section['section_name']);
$smarty->display($template);
