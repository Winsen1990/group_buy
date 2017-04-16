<?php /* Smarty version Smarty-3.1.13, created on 2017-04-16 20:21:07
         compiled from "themes\default\nav\list.phtml" */ ?>
<?php /*%%SmartyHeaderCode:2098258f361b37dbf50-22155556%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '941a2b85c177e7fc76236c2828385ec5e290e4d1' => 
    array (
      0 => 'themes\\default\\nav\\list.phtml',
      1 => 1491879889,
      2 => 'file',
    ),
    'ee64af5780c892823248e1221964f5299ccb3028' => 
    array (
      0 => 'themes\\default\\common\\template.phtml',
      1 => 1491879887,
      2 => 'file',
    ),
    'fd9968ed2033378ace27185fc8731c5176f2d305' => 
    array (
      0 => 'themes\\default\\common\\breadcrumb.phtml',
      1 => 1491879887,
      2 => 'file',
    ),
    '9816d37df6bac5e8fac39c4d44ab3ebfb21b87af' => 
    array (
      0 => 'themes\\default\\common\\pagination.phtml',
      1 => 1491879887,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2098258f361b37dbf50-22155556',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'theme_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_58f361b47ca333_11503177',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f361b47ca333_11503177')) {function content_58f361b47ca333_11503177($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta http-equiv="Cache-Control" content="no-cache"/>
    <title>Group Buy</title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="author" content="Winsen"/>
    <meta name="version" content="v.1.0.0"/>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $_smarty_tpl->tpl_vars['theme_dir']->value;?>
/images/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['theme_dir']->value;?>
/css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['theme_dir']->value;?>
/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['theme_dir']->value;?>
/css/bootstrap-theme.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['theme_dir']->value;?>
/css/style.css"/>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_dir']->value;?>
/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_dir']->value;?>
/js/layer.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_dir']->value;?>
/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="header col-md-12 col-sm-12">
        <h1>JKDZSW</h1>
    </div>
    <div class="col-md-12 col-sm-12">
        <?php echo $_smarty_tpl->getSubTemplate ('common/slider.phtml', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <div class="container col-md-10 col-sm-10">
            
            <?php /*  Call merged included template "common/breadcrumb.phtml" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('common/breadcrumb.phtml', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '2098258f361b37dbf50-22155556');
content_58f361b3b052c7_32137186($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "common/breadcrumb.phtml" */?>
            

            
<div class="panel panel-default">
    <div class="panel-heading">
        <span class="panel-title"><?php echo $_smarty_tpl->tpl_vars['_P']->value['page']['title'];?>
</span>
    </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li <?php if ($_smarty_tpl->tpl_vars['position']->value=='middle'){?>class="active"<?php }?>><a href="nav.php?act=list&position=middle">主导航栏（中间）</a></li>
            <li <?php if ($_smarty_tpl->tpl_vars['position']->value=='top'){?>class="active"<?php }?>><a href="nav.php?act=list&position=top">辅助导航（顶部）</a></li>
            <li <?php if ($_smarty_tpl->tpl_vars['position']->value=='bottom'){?>class="active"<?php }?>><a href="nav.php?act=list&position=bottom">底部导航（底部）</a></li>
            <li><a href="nav.php?act=add&position=<?php echo $_smarty_tpl->tpl_vars['position']->value;?>
"><i class="glyphicon glyphicon-plus"></i>新增导航栏</a></li>
        </ul>
        <table class="table table-hover table-responsive">
            <thead>
                <tr>
                    <th width="40%">导航栏名称</th>
                    <th width="30%">排序</th>
                    <th width="30%">操作</th>
                </tr>
            </thead>
            <tbody>
            <?php if (isset($_smarty_tpl->tpl_vars['nav_list']->value[$_smarty_tpl->tpl_vars['position']->value])&&count($_smarty_tpl->tpl_vars['nav_list']->value[$_smarty_tpl->tpl_vars['position']->value])){?>
            <?php  $_smarty_tpl->tpl_vars['nav'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['nav']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['nav_list']->value[$_smarty_tpl->tpl_vars['position']->value][0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['nav']->key => $_smarty_tpl->tpl_vars['nav']->value){
$_smarty_tpl->tpl_vars['nav']->_loop = true;
?>
            <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['nav']->value['title'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['nav']->value['sort'];?>
</td>
                <td>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['nav']->value['url'];?>
" class="btn btn-default" title="预览">
                        <i class="glyphicon glyphicon-eye-open"></i>
                    </a>

                    <a href="nav.php?act=edit&id=<?php echo $_smarty_tpl->tpl_vars['nav']->value['id'];?>
" class="btn btn-default" title="编辑">
                        <i class="glyphicon glyphicon-pencil"></i>
                    </a>

                    <a href="javascript:void(0);" data-id="<?php echo $_smarty_tpl->tpl_vars['nav']->value['id'];?>
" class="btn btn-default delete" title="删除">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>
                </td>
            </tr>
            
            <?php if (isset($_smarty_tpl->tpl_vars['nav_list']->value[$_smarty_tpl->tpl_vars['position']->value][$_smarty_tpl->tpl_vars['nav']->value['id']])){?>
                <?php  $_smarty_tpl->tpl_vars['sub_nav'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sub_nav']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['nav_list']->value[$_smarty_tpl->tpl_vars['position']->value][$_smarty_tpl->tpl_vars['nav']->value['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['sub_nav']->key => $_smarty_tpl->tpl_vars['sub_nav']->value){
$_smarty_tpl->tpl_vars['sub_nav']->_loop = true;
?>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;|--<?php echo $_smarty_tpl->tpl_vars['sub_nav']->value['title'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['sub_nav']->value['sort'];?>
</td>
                    <td>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['sub_nav']->value['url'];?>
" class="btn btn-default" title="预览">
                            <i class="glyphicon glyphicon-eye-open"></i>
                        </a>

                        <a href="nav.php?act=edit&id=<?php echo $_smarty_tpl->tpl_vars['sub_nav']->value['id'];?>
" class="btn btn-default" title="编辑"/>
                            <i class="glyphicon glyphicon-pencil"></i>
                        </a>

                        <a href="javascript:void(0);" data-id="<?php echo $_smarty_tpl->tpl_vars['sub_nav']->value['id'];?>
" class="btn btn-default delete" title="删除">
                            <i class="glyphicon glyphicon-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            <?php }?>
            <?php } ?>
            <?php }else{ ?>
            <tr>
                <td colspan="2" class="text-center">
                    暂无导航栏，请先 <a href="nav.php?act=add&position=<?php echo $_smarty_tpl->tpl_vars['position']->value;?>
">添加</a>
                </td>
            </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
    <div class="panel-footer text-right">
        <?php echo $_smarty_tpl->tpl_vars['_P']->value['page']['copyright'];?>

    </div>
</div>
<script type="text/javascript">
    $(function(){
        var delete_btns = $('.delete');

        delete_btns.each(function(i, e) {
            $(this).bind('click', delete_nav);
        });
    });

    function delete_nav() {
        var data = {
            id: $(this).attr('data-id'),
            opera: 'delete'
        };

        var url = 'nav.php';

        layer.confirm('您确定要删除该导航栏?', { icon: 3 }, function() {
            $.post(url, data, delete_nav_success, 'json');
        });
    }

    function delete_nav_success(response) {
        if(response.error == 0) {
            layer.open({
                shade: [0.5, '#333333'],
                icon: 1,
                closeBtn: 0,
                content: response.message,
                yes: function() {
                    window.location.reload();
                }
            });
        } else {
            layer.alert(response.message);
        }
    }
</script>

        </div>
    </div>

    <div class="footer"></div>
</body>
</html><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2017-04-16 20:21:07
         compiled from "themes\default\common\breadcrumb.phtml" */ ?>
<?php if ($_valid && !is_callable('content_58f361b3b052c7_32137186')) {function content_58f361b3b052c7_32137186($_smarty_tpl) {?><ol class="breadcrumb">
    <li>
        <a href="index.php">
            <span class="glyphicon glyphicon-home"></span>
        </a>
    </li>
    <?php  $_smarty_tpl->tpl_vars['location'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['location']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['breadcrumb']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['location']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['location']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['location']->key => $_smarty_tpl->tpl_vars['location']->value){
$_smarty_tpl->tpl_vars['location']->_loop = true;
 $_smarty_tpl->tpl_vars['location']->iteration++;
 $_smarty_tpl->tpl_vars['location']->last = $_smarty_tpl->tpl_vars['location']->iteration === $_smarty_tpl->tpl_vars['location']->total;
?>
        <?php if ($_smarty_tpl->tpl_vars['location']->last){?>
            <li class="active"><?php echo $_smarty_tpl->tpl_vars['location']->value['name'];?>
</li>
        <?php }else{ ?>
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['location']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['location']->value['name'];?>
</a></li>
        <?php }?>
    <?php } ?>
</ol><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2017-04-16 20:21:07
         compiled from "themes\default\common\pagination.phtml" */ ?>
<?php if ($_valid && !is_callable('content_58f361b3ce3090_27869870')) {function content_58f361b3ce3090_27869870($_smarty_tpl) {?><meta charset="UTF-8">
<?php if ($_smarty_tpl->tpl_vars['total_page']->value>1){?>
<nav aria-label="Page navigation" class="navbar-right">
    <ul class="pagination  pagination-sm">
        <?php if ($_smarty_tpl->tpl_vars['page']->value==1){?>
        <li class="disabled">
            <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?php }else{ ?>
        <li>
            <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?php }?>

        <?php $_smarty_tpl->tpl_vars['max_page'] = new Smarty_variable($_smarty_tpl->tpl_vars['total_page']->value, null, 0);?>
        <?php $_smarty_tpl->tpl_vars['begin_page'] = new Smarty_variable(1, null, 0);?>

        <?php if ($_smarty_tpl->tpl_vars['total_page']->value>5){?>
        <?php }?>

        <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int)ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->tpl_vars['max_page']->value+1 - ($_smarty_tpl->tpl_vars['begin_page']->value) : $_smarty_tpl->tpl_vars['begin_page']->value-($_smarty_tpl->tpl_vars['max_page']->value)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0){
for ($_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['begin_page']->value, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++){
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
            <?php if ($_smarty_tpl->tpl_vars['i']->value==$_smarty_tpl->tpl_vars['page']->value){?>
                <li class="active"><a href="#"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a></li>
            <?php }else{ ?>
                <li><a href="#"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a></li>
            <?php }?>
        <?php }} ?>

        <?php if ($_smarty_tpl->tpl_vars['page']->value==$_smarty_tpl->tpl_vars['total_page']->value){?>
        <li class="disabled">
            <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        <?php }else{ ?>
        <li>
            <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        <?php }?>
    </ul>
</nav>
<?php }?><?php }} ?>