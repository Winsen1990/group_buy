<?php
/**
 * 清理缓存
 */
include 'library/init.inc.php';

global $smarty;

$smarty->clearAllCache();
$smarty->clearCompiledTemplate();
