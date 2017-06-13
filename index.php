<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2016/12/18
 * Time: 下午7:37
 */
include 'library/init.inc.php';

global $db, $smarty;

//获取 专家观点
$article_list = $db->get_all('article', array('section_id' => 5), '', ' `add_time` DESC limit 5');

//获取公司简介
$company_desc = $db->get('article', array('id' => 1));

//获取轮播图片
$ad_list = $db->get_all('ad', array('ad_pos_id' => 1), '', '`sort`');
$ad_pos = $db->get('ad_position', array('id' => 1));

foreach($ad_list as &$ad) {
    $ad['width'] = $ad_pos['width'];
    $ad['height'] = $ad_pos['height'];
}

//健康就是这么简单
$book_list = $db->get_all('article', array('section_id' => 4), '', ' `add_time` DESC limit 10');

$_P['page']['title'] = '首页';

$smarty->assign('ad_list', $ad_list);
$smarty->assign('article_list', $article_list);
$smarty->assign('book_list', $book_list);
$smarty->assign('company_desc', $company_desc);
$smarty->assign('_P', $_P);
$smarty->display('index.phtml');