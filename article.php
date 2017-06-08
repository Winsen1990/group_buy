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

$get_article = 'select `id`,`title`,`author`,`add_time`,`content`,`keywords`,`desc`,`section_id`,`view_count` from '.
               $db->table('article').' where `id`='.$id;

$article = $db->fetch_row($get_article);

if($article)
{
    $article['add_time'] = date('Y-m-d', $article['add_time']);

    $get_section = 'select `id`,`name`,`parent_id`,`cover` from '.$db->table('section').' where `id`='.$article['section_id'];
    $section = $db->fetch_row($get_section);
    $smarty->assign('section', $section);

    $get_article_list = 'select `id`,`title`,`content` from '.$db->table('article').' where `section_id`='.$article['section_id'];
    $article_list = $db->fetch_all($get_article_list);
    $smarty->assign('article_list', $article_list);

    $prev_article = null;
    $next_article = null;

    if($article_list) {
        $current = false;
        foreach($article_list as $_article) {
            if($_article['id'] == $id) {
                $current = true;
            }

            if($current) {
                if($_article['id'] != $id) {
                    $next_article = $_article;
                    break;
                }
            } else {
                $prev_article = $_article;
            }
        }
    }
    $smarty->assign('prev_article', $prev_article);
    $smarty->assign('next_article', $next_article);

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => $section['name'], 'url' => 'section.php?id='.$section['id']),
        array('name' => $article['title'], 'url' => '#')
    );
    $smarty->assign('breadcrumb', $breadcrumb);

    $url = 'http://'.$_SERVER['HTTP_HOST'].'/article.php?id='.$id;
    $sub_nav = generate_sub_nav(array('title' => $article['title'], 'url' => $url));

    if(empty($sub_nav['nav_list'])) {
        $url = 'section.php?id='.$section['id'];
        $sub_nav = generate_sub_nav(array('title' => $section['name'], 'url' => $url));
    }

    $smarty->assign('sub_nav', $sub_nav);
    $_P['page']['title'] = $article['title'];

    $unread = false;

    if(isset($_SESSION['read_article_id'])) {
        if(strpos($_SESSION['read_article_id'], ','.$id.',') === false) {
            $unread = true;
            $_SESSION['read_article_id'] .= $id . ',';
        }
    } else {
        $unread = true;
        $_SESSION['read_article_id'] = '0,'.$id.',';
    }

    if($unread) {
        $add_view = 'update '.$db->table('article').' set `view_count`=`view_count`+1 where `id`='.$id;
        $db->update($add_view);
        $article['view_count']++;
    }
} else {
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');
    header('Location: 404.php');
    exit;
}

$smarty->assign('_P', $_P);
$smarty->assign('id', $id);
$smarty->assign('article', $article);
$smarty->assign('page_title', $article['title']);
$smarty->display($template);
