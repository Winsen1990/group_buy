<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2016/12/18
 * Time: 下午7:37
 */
include 'library/init.inc.php';

//获取 健康就是这么简单
$book_list = $db->get_all('article', ['section_id' => 4], '', ' `add_time` ASC limit 5');

$_P['page']['title'] = 'index';

$smarty->assign('book_list', $book_list);
$smarty->assign('_P', $_P);
$smarty->display('index.phtml');