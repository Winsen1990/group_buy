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
$template = 'category.phtml';

$get_category = 'select `id`,`name` from '.$db->table('category').' where `id`='.$id;

$category = $db->fetch_row($get_category);

if(!$category)
{
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');
    header('Location: 404.php');
    exit;
} else {
    $get_product_list = 'select `name`,`id`,`price`,`thumb`,`desc` from '.$db->table('product').' where `status`=1 ';
    $get_product_list .= ' and `category_id`='.$id;

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => $category['name'], 'url' => 'category.php?id='.$category['id'])
    );
    $smarty->assign('breadcrumb', $breadcrumb);

    $url = 'category.php?id='.$category['id'];
    $sub_nav = generate_sub_nav(array('title' => $category['name'], 'url' => $url));

    $smarty->assign('sub_nav', $sub_nav);

    $product_list = $db->fetch_all($get_product_list);
    $smarty->assign('product_list', $product_list);
}

$_P['page']['title'] = $category['name'];

$smarty->assign('_P', $_P);
$smarty->assign('category', $category);
$smarty->display($template);
