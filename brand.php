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
    $_P['page']['title'] = '品牌中心';

    $get_brand_list = 'select `id`,`name`,`desc`,`logo` from '.$db->table('brand').' where `status`=1 order by `sort`';
    $brand_list = $db->fetch_all($get_brand_list);

    $template = 'brand_list.phtml';
    $smarty->assign('brand_list', $brand_list);
} else {
    $_P['page']['title'] = $brand['name'];

    $get_product_list = 'select `name`,`id`,`price`,`thumb`,`desc` from '.$db->table('product').' where `status`=1 and `brand_id`='.$id;

    $product_list = $db->fetch_all($get_product_list);
    $smarty->assign('product_list', $product_list);
}

$smarty->assign('_P', $_P);
$smarty->assign('brand', $brand);
$smarty->display($template);
