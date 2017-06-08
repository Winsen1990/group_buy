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

$template = '404.phtml';

$smarty->display($template);
