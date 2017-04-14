<?php
/**
 * 清理缓存
 */
include 'library/init.inc.php';

$smarty->clearAllCache();
$smarty->clearCompiledTemplate();
