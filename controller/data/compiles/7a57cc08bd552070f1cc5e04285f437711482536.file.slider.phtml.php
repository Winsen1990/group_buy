<?php /* Smarty version Smarty-3.1.13, created on 2017-04-16 20:21:09
         compiled from "themes\default\common\slider.phtml" */ ?>
<?php /*%%SmartyHeaderCode:601858f361b5d64080-70615953%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7a57cc08bd552070f1cc5e04285f437711482536' => 
    array (
      0 => 'themes\\default\\common\\slider.phtml',
      1 => 1491879887,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '601858f361b5d64080-70615953',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'menus' => 0,
    'menu' => 0,
    'menu_item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_58f361b5ee7c57_01722721',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f361b5ee7c57_01722721')) {function content_58f361b5ee7c57_01722721($_smarty_tpl) {?><div class="aslide col-md-2 col-sm-2">
    <div class="panel-group" role="tablist">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="menu-group">
                <h4 class="panel-title">
                    <a href="index.php">首页</a>
                </h4>
            </div>
            <?php  $_smarty_tpl->tpl_vars['menu'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menu']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['menu']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['menu']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['menu']->key => $_smarty_tpl->tpl_vars['menu']->value){
$_smarty_tpl->tpl_vars['menu']->_loop = true;
 $_smarty_tpl->tpl_vars['menu']->iteration++;
 $_smarty_tpl->tpl_vars['menu']->last = $_smarty_tpl->tpl_vars['menu']->iteration === $_smarty_tpl->tpl_vars['menu']->total;
?>
            <div class="panel-heading" role="tab" id="menu-group-<?php echo $_smarty_tpl->tpl_vars['menu']->key;?>
">
                <h4 class="panel-title" data-target="#menu-list-<?php echo $_smarty_tpl->tpl_vars['menu']->key;?>
" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="menu-list-<?php echo $_smarty_tpl->tpl_vars['menu']->key;?>
">
                    <?php echo $_smarty_tpl->tpl_vars['menu']->value['group'];?>

                </h4>
            </div>
            <div class="panel-collapse collapse in" role="tabpanel" id="menu-list-<?php echo $_smarty_tpl->tpl_vars['menu']->key;?>
" aria-labelledby="menu-group-<?php echo $_smarty_tpl->tpl_vars['menu']->key;?>
" aria-expanded="true">
                <ul class="list-group">
                    <?php  $_smarty_tpl->tpl_vars['menu_item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menu_item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu']->value['sub_menus']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['menu_item']->key => $_smarty_tpl->tpl_vars['menu_item']->value){
$_smarty_tpl->tpl_vars['menu_item']->_loop = true;
?>
                    <?php if ($_smarty_tpl->tpl_vars['menu_item']->value['display']){?>
                    <li class="list-group-item">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['menu_item']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['menu_item']->value['title'];?>
</a>
                    </li>
                    <?php }?>
                    <?php } ?>
                </ul>
            </div>
            <?php if ($_smarty_tpl->tpl_vars['menu']->last){?>
            <div class="panel-footer">
                <a href="logout.php">安全退出</a>
            </div>
            <?php }?>
            <?php } ?>
        </div>
    </div>
</div><?php }} ?>