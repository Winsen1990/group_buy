<?php
include 'library/init.inc.php';
global $db, $smarty, $_P;

$loader->include_classes('ProductDAO');
$productDAO = new ProductDAO();
$productDAO->init();

$template = 'product/';

$action = 'edit|add|list|delete';
$operation = 'edit|add|delete';

$act = check_action($action, getGET('act'), 'list');

$opera = check_action($operation, getPOST('opera'));
//===========================================================================
//添加商品
if( 'add' == $opera ) {
    $station_id = 1;
    $name = trim(getPOST('name'));
    $category_id = intval(getPOST('category_id'));
    $desc = getPOST('desc');
    $price = floatval(getPOST('price'));
    $market_price = floatval(getPOST('market_price'));
    $group_price = floatval(getPOST('group_price'));
    $group_limit = floatval(getPOST('group_limit'));
    $image = getPOST('image');
    $thumb = getPOST('thumb');
    $status = intval(getPOST('status'));
    $detail = getPOST('detail');
    $unit = getPOST('unit');
    $sort = intval(getPOST('sort'));

    $ajax_response = array('error' => -1, 'message' => '');

    if('' == $name) {
        $ajax_response['message']  .= '-请填写商品名称'.BR;
    }

    if(0 > $category_id) {
        $ajax_response['message'] .= '-请选择商品分类'.BR;
    }

    if('' == $desc) {
        $ajax_response['message'] .= '-请填写商品简介'.BR;
    }

    if('' == $unit) {
        $ajax_response['message'] .= '-请填写单位'.BR;
    }

    if(0 >= $price) {
        $ajax_response['message'] .= '-请填写商品价格'.BR;
    }

    if(0 >= $market_price) {
        $ajax_response['message'] .= '-请填写市场价格'.BR;
    }

    if(0 >= $group_price) {
        $ajax_response['message'] .= '-请填写团购价格'.BR;
    }

    if(0 >= $group_limit) {
        $ajax_response['message'] .= '-请填写团购人数'.BR;
    }

    if('' == $image) {
        $ajax_response['message'] .= '-请选择商品图片'.BR;
    }

    if('' == $thumb) {
        $ajax_response['message'] .= '-请选择缩略图'.BR;
    }

    if('' == $detail) {
        $ajax_response['message'] .= '-请填写详细介绍'.BR;
    }

    if($sort < 0) {
        $sort = 50;
    }

    if($status < 0) {
        $status = 0;
    }

    if($ajax_response['message'] == '') {
        if ($productDAO->add($name, $category_id, $market_price, $price, $group_limit, $group_price, $image, $thumb,
                             $detail, $desc, $unit, $station_id, $sort, $status)) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] .= '商品-' . $name . '-添加成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//编辑商品
if( 'edit' == $opera ) {
    $id = getPOST('id');
    $id = intval($id);
    $name = trim(getPOST('name'));
    $category_id = intval(getPOST('category_id'));
    $desc = getPOST('desc');
    $price = floatval(getPOST('price'));
    $market_price = floatval(getPOST('market_price'));
    $group_price = floatval(getPOST('group_price'));
    $group_limit = floatval(getPOST('group_limit'));
    $image = getPOST('image');
    $thumb = getPOST('thumb');
    $status = intval(getPOST('status'));
    $detail = getPOST('detail');
    $unit = getPOST('unit');
    $sort = intval(getPOST('sort'));

    $ajax_response = array('error' => -1, 'message' => '');

    if(0 >= $id) {
        $ajax_response['message'] .= '-参数错误'.BR;
    } else if(!$productDAO->get('`id`='.$id)) {
        $ajax_response['message'] .= '-商品不存在'.BR;
    }

    if('' == $name) {
        $ajax_response['message']  .= '-请填写商品名称'.BR;
    }

    if(0 > $category_id) {
        $ajax_response['message'] .= '-请选择商品分类'.BR;
    }

    if('' == $desc) {
        $ajax_response['message'] .= '-请填写商品简介'.BR;
    }

    if('' == $unit) {
        $ajax_response['message'] .= '-请填写单位'.BR;
    }

    if(0 >= $price) {
        $ajax_response['message'] .= '-请填写商品价格'.BR;
    }

    if(0 >= $market_price) {
        $ajax_response['message'] .= '-请填写市场价格'.BR;
    }

    if(0 >= $group_price) {
        $ajax_response['message'] .= '-请填写团购价格'.BR;
    }

    if(0 >= $group_limit) {
        $ajax_response['message'] .= '-请填写团购人数'.BR;
    }

    if('' == $image) {
        $ajax_response['message'] .= '-请选择商品图片'.BR;
    }

    if('' == $thumb) {
        $ajax_response['message'] .= '-请选择缩略图'.BR;
    }

    if('' == $detail) {
        $ajax_response['message'] .= '-请填写详细介绍'.BR;
    }

    if($sort < 0) {
        $sort = 50;
    }

    if($status < 0) {
        $status = 0;
    }

    if($ajax_response['message'] == '') {
        $productDAO->name = $name;
        $productDAO->category_id = $category_id;
        $productDAO->desc = $desc;
        $productDAO->detail = $detail;
        $productDAO->price = $price;
        $productDAO->market_price = $market_price;
        $productDAO->group_limit = $group_limit;
        $productDAO->group_price = $group_price;
        $productDAO->thumb = $thumb;
        $productDAO->image = $image;
        $productDAO->sort = $sort;
        $productDAO->status = $status;
        $productDAO->unit = $unit;

        if ($productDAO->save()) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] .= '商品-' . $name . '-修改成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}

//删除商品
if( 'delete' == $opera ) {
    $ajax_response = array('error' => -1, 'message' => '');
    $id = getPOST('id');
    $id = intval($id);

    if(0 >= $id) {
        $ajax_response['message'] .= '-参数错误'.BR;
    }

    if($ajax_response['message'] == '') {
        if ($productDAO->delete('`id`='.$id)) {
            $ajax_response['error'] = 0;
            $ajax_response['message'] = '删除商品成功';
        } else {
            $ajax_response['message'] = '系统繁忙，请稍后再试';
        }
    }

    echo json_encode($ajax_response);
    exit;
}
//===========================================================================

//商品列表
if( 'list' == $act ) {
    $get_product_list = 'select a.*,c.`name` as `category_name` from '.$db->table('product').' as a left join '.$db->table('category').' as c '.
                        ' on c.`id`=a.`category_id` where 1  order by a.`add_time` DESC, a.`sort` ASC';
    $product_list = $db->fetch_all($get_product_list);

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '商品管理', 'url' => 'category.php')
    );

    $_P['page']['title'] = '商品管理';

    $smarty->assign('product_list', $product_list);
    $smarty->assign('breadcrumb', $breadcrumb);
}

//添加商品
if( 'add' == $act ) {
    $get_category_list = 'select * from '.$db->table('category').' where 1 order by `path` ASC';
    $category_list = $db->fetch_all($get_category_list);

    if($category_list) {
        foreach($category_list as &$category) {
            $count = count(explode(',', $category['path']));
            if($count > 1) {
                $temp = '|--'.$category['name'];
                while($count--) {
                    $temp = '&nbsp;&nbsp;'.$temp;
                }

                $category['name'] = $temp;
            }
        }
    }

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '商品管理', 'url' => 'product.php'),
        array('name' => '新增商品', 'url' => 'product.php?act=add')
    );

    $_P['page']['title'] = '新增商品';

    $smarty->assign('breadcrumb', $breadcrumb);
    $smarty->assign('category_list', $category_list);
}

//编辑商品
if( 'edit' == $act ) {
    $id = getGET('id');
    $id = intval($id);

    if( 0 >= $id ) {
        message('参数错误', array());
        exit;
    }

    $get_product = 'select * from '.$db->table('product').' where `id`='.$id.' limit 1';
    $product = $db->fetch_row($get_product);

    if( empty($product) ) {
        message('商品不存在', array());
        exit;
    }

    $smarty->assign('product', $product);

    $get_category_list = 'select * from '.$db->table('category').'  order by `path` ASC';
    $category_list = $db->fetch_all($get_category_list);

    if($category_list) {
        foreach($category_list as &$_category) {
            $count = count(explode(',', $_category['path']));
            if($count > 1) {
                $temp = '|--'.$_category['name'];
                while($count--) {
                    $temp = '&nbsp;&nbsp;'.$temp;
                }

                $_category['name'] = $temp;
            }
        }
    }

    //设置路径导航
    $breadcrumb = array(
        array('name' => '首页', 'url' => 'index.php'),
        array('name' => '商品管理', 'url' => 'product.php'),
        array('name' => '修改商品', 'url' => 'product.php?act=edit&id='.$id)
    );

    $_P['page']['title'] = '修改商品-'.$product['name'];

    $smarty->assign('breadcrumb', $breadcrumb);
    $smarty->assign('category_list', $category_list);
}

$smarty->assign('_P', $_P);
$template .= $act.'.phtml';
$smarty->display($template);