<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2016/11/5
 * Time: 上午12:17
 */
global $menus;

$menus = array(
    /*
    array(
        'purview_prefix' => 'station_',
        'group' => '站点管理',
        'sub_menus' => array(
            array('title'=>'站点列表', 'url'=>'#', 'purview'=>'list', 'display'=>true),
            array('title'=>'新增站点', 'url'=>'#', 'purview'=>'add', 'display'=>true),
        )
    ),
    */
    array(
        'purview_prefix' => 'nav_',
        'group' => '站点设置',
        'sub_menus' => array(
            array('title'=> '参数设置', 'url'=>'sysconf.php', 'purview'=>'list', 'display'=>true),
            array('title'=>'导航栏设置', 'url'=>'nav.php', 'purview'=>'list', 'display'=>true),
        )
    ),

    array(
        'purview_prefix' => 'ad_',
        'group' => '广告设置',
        'sub_menus' => array(
            array('title'=> '广告位置管理', 'url'=>'ad_position.php', 'purview'=>'list', 'display'=>true),
            array('title'=> '新增广告位置', 'url'=>'ad_position.php?act=add', 'purview'=>'list', 'display'=>true),
            array('title'=>'广告管理', 'url'=>'ad.php', 'purview'=>'list', 'display'=>true),
            array('title'=>'新增广告', 'url'=>'ad.php?act=add', 'purview'=>'list', 'display'=>true),
        )
    ),

    array(
        'purview_prefix' => 'section_',
        'group' => '栏目管理',
        'sub_menus' => array(
            array('title'=>'栏目列表', 'url'=>'section.php', 'purview'=>'list', 'display'=>true),
            array('title'=>'新增栏目', 'url'=>'section.php?act=add', 'purview'=>'add', 'display'=>true),
        )
    ),

    array(
        'purview_prefix' => 'article_',
        'group' => '资讯管理',
        'sub_menus' => array(
            array('title'=>'资讯列表', 'url'=>'article.php', 'purview'=>'list', 'display'=>true),
            array('title'=>'新增资讯', 'url'=>'article.php?act=add', 'purview'=>'add', 'display'=>true),
        )
    ),

    array(
        'purview_prefix' => 'category_',
        'group' => '商品分类',
        'sub_menus' => array(
            array('title'=>'分类列表', 'url'=>'category.php', 'purview'=>'list', 'display'=>true),
            array('title'=>'新增分类', 'url'=>'category.php?act=add', 'purview'=>'add', 'display'=>true),
        )
    ),

    array(
        'purview_prefix' => 'product_',
        'group' => '商品管理',
        'sub_menus' => array(
            array('title'=>'商品列表', 'url'=>'product.php', 'purview'=>'list', 'display'=>true),
            array('title'=>'新增商品', 'url'=>'product.php?act=add', 'purview'=>'add', 'display'=>true),
        )
    ),
);