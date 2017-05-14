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

$get_product = 'select `id`,`name`,`product_sn`,`price`,`detail`,`image`,`brand_id` from '.
               $db->table('product').' where `id`='.$id;

$product = $db->fetch_row($get_product);

if($product)
{
    $_P['page']['title'] = $product['name'];

    $get_brand = 'select `name` from '.$db->table('brand').' where `id`='.$product['brand_id'];
    $brand = $db->fetch_row($get_brand);

    $product['brand_name'] = $brand['name'];
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
