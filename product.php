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

$template = 'product.phtml';

$get_product = 'select `id`,`name`,`product_sn`,`price`,`detail`,`image`,`brand_id`,`category_id`,`desc` from '.
               $db->table('product').' where `id`='.$id;

$product = $db->fetch_row($get_product);

if($product)
{
    $product['price'] = sprintf('¥%.2f元', $product['price']);
    $_P['page']['title'] = $product['name'];

    $get_brand = 'select `name` from '.$db->table('brand').' where `id`='.$product['brand_id'];
    $brand = $db->fetch_row($get_brand);

    $product['brand_name'] = $brand['name'];

    $get_category = 'select `id`,`name` from '.$db->table('category').' where `id`='.$product['category_id'];
    $category = $db->fetch_row($get_category);

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => $category['name'], 'url' => 'category.php?id='.$category['id']),
        array('name' => $product['name'], 'url' => '#')
    );
    $smarty->assign('breadcrumb', $breadcrumb);

    $url = 'product.php?id='.$product['id'];
    $sub_nav = generate_sub_nav(array('title' => $product['name'], 'url' => $url));

    $smarty->assign('sub_nav', $sub_nav);
} else {
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');
    header('Location: 404.php');
    exit;
}

$smarty->assign('_P', $_P);
$smarty->assign('id', $id);
$smarty->assign('product', $product);
$smarty->display($template);
