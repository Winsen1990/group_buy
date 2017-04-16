<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2016/12/18
 * Time: 下午7:37
 */
include 'library/init.inc.php';

global $db, $smarty;

//获取 最新资讯
$article_list = $db->get_all('article', [], '', ' `add_time` DESC limit 10');

//获取公司简介
$company_desc = $db->get('article', ['id' => 1]);

//获取轮播图片
$ad_list = $db->get_all('ad', ['ad_pos_id' => 1], '', '`sort`');

$_P['page']['title'] = '首页';

$smarty->assign('ad_list', $ad_list);
$smarty->assign('article_list', $article_list);
$smarty->assign('company_desc', $company_desc);
$smarty->assign('_P', $_P);
$smarty->display('index.phtml');