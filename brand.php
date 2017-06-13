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
$template = 'brand.phtml';

$brand = null;

if($id) {
    $get_brand = 'SELECT `id`,`name`,`content`,`logo` FROM ' . $db->table('brand') . ' WHERE `id`=' . $id;

    $brand = $db->fetch_row($get_brand);
}

if(!$brand)
{
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');
    header('Location: 404.php');
    exit;
} else {
    $_P['page']['title'] = $brand['name'];

    $get_product_list = 'select `name`,`id`,`price`,`thumb`,`desc` from '.$db->table('product').' where `status`=1 and `brand_id`='.$id;

    $product_list = $db->fetch_all($get_product_list);
    $smarty->assign('product_list', $product_list);

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => $brand['name'], 'url' => 'brand.php?id='.$brand['id'])
    );
    $smarty->assign('breadcrumb', $breadcrumb);

    $url = 'brand.php?id='.$brand['id'];
    $sub_nav = generate_sub_nav(array('title' => $brand['name'], 'url' => $url));

    $smarty->assign('sub_nav', $sub_nav);
}

$smarty->assign('_P', $_P);
$smarty->assign('brand', $brand);
$smarty->display($template);
