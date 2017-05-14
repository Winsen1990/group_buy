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

$get_product_list = 'select `name`,`id`,`price`,`thumb`,`desc` from '.$db->table('product').' where `status`=1 ';

if(!$category)
{
    $category = array('name' => '产品中心');
} else {
    $get_product_list .= ' and `category_id`='.$id;
}


$product_list = $db->fetch_all($get_product_list);

$_P['page']['title'] = $category['name'];

$smarty->assign('_P', $_P);
$smarty->assign('category', $category);
$smarty->assign('product_list', $product_list);
$smarty->display($template);
