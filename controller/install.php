<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/9/6
 * Time: 下午7:01
 */
include 'library/init.inc.php';

$sql = array();
$table = array();

$table[] = '广告位置';
$sql[] = 'create table if not exists '.$db->table('ad_position').' (
    `id` int not null auto_increment primary key,
    `pos_name` varchar(255) not null,
    `width` varchar(255) not null,
    `height` varchar(255) not null,
    `number` int not null default \'1\',
    `code` text
) default charset=utf8;';

$table[] = '广告';
$sql[] = 'create table if not exists '.$db->table('ad').' (
    `id` int not null auto_increment primary key,
    `img` varchar(255) not null,
    `alt` varchar(255),
    `add_time` int not null,
    `begin_time` int,
    `end_time` int,
    `forever` tinyint(1) not null default \'0\',
    `click_time` int not null default \'0\',
    `url` varchar(255) not null,
    `sort` int not null default \'50\',
    `ad_pos_id` int not null
) default charset=utf8;';

$table[] = '商品表';
$sql[] = 'create table if not exists '.$db->table('product').' (
    `id` bigint not null auto_increment unique,
    `station_id` bigint not null comment \'站点ID\',
    `product_sn` varchar(255) not null primary key comment \'商品编号\',
    `product_name` varchar(255) not null comment \'商品名称\',
    `category_id` bigint not null comment \'商品分类ID\',
    `price` decimal(18,2) not null comment \'单独购价格\',
    `market_price` decimal(18,2) not null default \'0\' comment \'市场价格\',
    `group_price` decimal(18,2) not null comment \'团购价格\',
    `group_limit` int not null comment \'团购人数\',
    `image` varchar(255) not null comment \'商品主图URL\',
    `thumb` varchar(255) not null comment \'商品缩略图\',
    `status` tinyint(1) not null default \'1\' comment \'商品状态\',
    `detail` text comment \'商品详情\',
    `meta_description` text comment \'商品摘要\'
) engine=InnoDB,default charset='.DB_CHARSET.';';

$table[] = '商品分类';
$sql[] = 'create table if not exists '.$db->table('category').' (
    `id` bigint not null auto_increment primary key,
    `station_id` bigint not null comment \'站点ID\',
    `category_name` varchar(255) not null comment \'商品分类名\',
    `parent_id` bigint not null default \'0\' comment \'上级分类ID\',
    `path` varchar(255) comment \'分类路径\',
    `sort` int not null default \'50\' comment \'排序\'
) engine=InnoDB,default charset='.DB_CHARSET.';';

$table[] = '商品相册';
$sql[] = 'create table if not exists '.$db->table('gallery').' (
    `id` bigint not null auto_increment primary key,
    `station_id` bigint not null comment \'站点ID\',
    `product_sn` varchar(255) not null comment \'商品编号\',
    `image` varchar(255) not null comment \'图片URL\',
    `sort` int not null default \'10\' comment \'图片排序\'
) engine=InnoDB,default charset='.DB_CHARSET.';';

$table[] = '价格列表';
$sql[] = 'create table if not exists '.$db->table('price_list').' (
    `id` bigint not null auto_increment primary key,
    `station_id` bigint not null comment \'站点ID\',
    `product_sn` varchar(255) not null comment \'商品编号\',
    `min_number` int not null comment \'最低购买量\',
    `price` decimal(18,2) not null comment \'价格\'
) engine=InnoDB,default charset='.DB_CHARSET.';';

$table[] = '团信息';
$sql[] = 'create table if not exists '.$db->table('group').' (
    `id` bigint not null auto_increment unique,
    `station_id` bigint not null comment \'站点ID\',
    `group_sn` varchar(255) not null primary key comment \'团编号\',
    `status` int not null default \'1\' comment \'团状态\',
    `add_time` datetime not null comment \'创建时间\',
    `expired` datetime not null comment \'过期时间\',
    `member_number` int not null comment \'团成员数量\'
) engine=InnoDB,default charset='.DB_CHARSET.';';

$table[] = '订单信息';
$sql[] = 'create table if not exists '.$db->table('order').' (
    `id` bigint not null auto_increment unique,
    `station_id` bigint not null comment \'站点ID\',
    `order_sn` varchar(255) not null primary key comment \'订单编号\',
    `add_time` datetime not null comment \'下单时间\',
    `pay_time` datetime comment \'支付时间\',
    `pay_type` varchar(255) not null comment \'支付方式\',
    `delivery_time` datetime comment \'发货时间\',
    `delivery_name` varchar(255) comment \'快递公司\',
    `delivery_sn` varchar(255) comment \'快递单号\',
    `delivery_code` varchar(255) comment \'快递公司代码\',
    `delivery_fee` decimal(18,2) not null default \'0\' comment \'订单运费\',
    `order_amount` decimal(18,2) not null default \'0\' comment \'订单总额\',
    `product_amount` decimal(18,2) not null default \'0\' comment \'产品总额\',
    `coupon_amount` decimal(18,2) not null default \'0\' comment \'优惠券总额\',
    `group_sn` varchar(255) comment \'拼团编号\',
    `status` int not null default \'1\' comment \'订单编号\',
    `account` varchar(255) not null comment \'会员账号\',
    `remark` varchar(255) comment \'备注\'
) engine=InnoDB,default charset='.DB_CHARSET.';';

$table[] = '订单详情';
$sql[] = 'create table if not exists '.$db->table('order_detail').' (
    `id` bigint not null auto_increment primary key,
    `station_id` bigint not null comment \'站点ID\',
    `order_sn` varchar(255) not null comment \'订单编号\',
    `product_sn` varchar(255) not null comment \'产品编号\',
    `image` varchar(255) not null comment \'产品图片\',
    `price` decimal(18,2) not null comment \'购买单价\',
    `unit` varchar(255) not null comment \'单位\',
    `product_name` varchar(255) not null comment \'产品名称\',
    `number` int not null comment \'购买数量\'
) engine=InnoDB,default charset='.DB_CHARSET.';';

$table[] = '管理员';
$sql[] = 'create table if not exists '.$db->table('admin').' (
    `account` varchar(255) not null primary key,
    `password` varchar(255) not null,
    `name` varchar(255) not null,
    `role_id` int not null
) default charset='.DB_CHARSET.';';

$table[] = '角色';
$sql[] = 'create table if not exists '.$db->table('role').' (
    `id` bigint not null auto_increment primary key,
    `name` varchar(255) not null,
    `purview` text not null
) default charset='.DB_CHARSET.';';

$table[] = '资讯分类';
$sql[] = 'create table if not exists '.$db->table('category').' (
    `id` bigint not null auto_increment primary key,
    `station_id` bigint not null comment \'站点ID\',
    `name` varchar(255) not null comment \'资讯分类名\',
    `parent_id` bigint not null default \'0\' comment \'上级分类ID\',
    `path` varchar(255) comment \'分类路径\',
    `cover` varchar(255) comment \'封面图片\',
    `thumb` varchar(255) comment \'缩略图\',
    `sort` int not null default \'50\' comment \'排序\'
) engine=InnoDB,default charset='.DB_CHARSET.';';

$table[] = '品牌信息';
$sql[] = 'create table if not exists ' . $db->table('brand').' (
    `id` bigint not null auto_increment primary key,
    `name` varchar(255) not null comment \'品牌名称\',
    `station_id` bigint(20) NOT NULL COMMENT \'站点ID\',
    `keywords` varchar(255) DEFAULT NULL COMMENT \'品牌关键词\',
    `desc` varchar(255) DEFAULT NULL COMMENT \'品牌简介\',
    `content` text COMMENT \'品牌详细介绍\',
    `wap_content` text COMMENT \'手机品牌详细介绍\',
    `logo` varchar(255) DEFAULT NULL COMMENT \'品牌LOGO\',
    `sort` int(11) NOT NULL DEFAULT \'50\' COMMENT \'排序\',
    `status` int(11) NOT NULL DEFAULT \'1\' COMMENT \'状态\',
    `add_time` int(11) NOT NULL COMMENT \'创建时间\',
    `last_modify` timestamp NOT NULL COMMENT \'修改时间\'
) engine=InnoDB,default charset='.DB_CHARSET.';';

$table[] = '系统参数';
$sql[] = 'create table if not exists '.$db->table('sysconf'). ' (
    `key` varchar(255) not null primary key comment \'参数标识\',
    `title` varchar(255) not null comment \'参数名\',
    `type` varchar(255) not null comment \'参数类型\',
    `group` varchar(255) not null comment \'参数组\',
    `value` varchar(255) comment \'参数值\',
    `remark` varchar(255) comment \'备注\'
) engine=InnoDB,default charset='.DB_CHARSET.';';

foreach($sql as $index=>$create_table) {
    echo $table[$index].'.................';
    if($db->query($create_table)) {
        echo '<font color="green">success</font>';
    } else {
        echo '<font color="red">failure</font>';
        echo $db->errmsg();
    }

    echo '<br/>';
}