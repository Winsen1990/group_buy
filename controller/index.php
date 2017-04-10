<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/9/14
 * Time: 上午11:47
 */
include 'library/init.inc.php';
check_admin_oauth();

$smarty->assign('_P', $_P);
$smarty->display('index.phtml');