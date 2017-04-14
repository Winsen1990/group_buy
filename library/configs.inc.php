<?php
/*
 * 系统全局配置文件
 * @author winsen
 * @date 2015-01-09
 * @version 1.0.0
 */
global $plugins_config;

//数据库配置
define('DB_HOST', 'localhost');//数据库服务器
define('DB_USERNAME', 'root');//数据库用户名
define('DB_PASSWORD', 'root');//数据库密码
define('DB_DBNAME', 'jd');//数据库名
define('DB_PREFIX', 'gb_');//数据库表前缀
define('DB_CHARSET', 'utf8');//数据库编码

define('PASSWORD_SALT', '_jkdzsw');//密码后缀
define('PRODUCT_SN_PRE', 'SAF');//商品编号前缀
define('PRODUCT_SN_LENGTH', 4);//商品编号长度(不含前缀)
define('GROUP_SN_FORMAT', 'Ymd');//团信息编号格式
define('GROUP_SN_TAIL_LENGTH', 4);//团信息尾数长度
define('ORDER_SN_FORMAT', 'YmdHis');//订单编号格式
define('ORDER_SN_TAIL_LENGTH', 4);//订单编号尾数长度

$plugins_config = array(
    'payment' => 'off',
    'response' => 'off',
    'activity' => 'off',
    'express' => 'off',
);