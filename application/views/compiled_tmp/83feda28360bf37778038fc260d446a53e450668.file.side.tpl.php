<?php /* Smarty version Smarty-3.1.15, created on 2013-12-08 23:06:02
         compiled from "/Users/vikramraj/Sites/Training/rg/application/views/search/side.tpl" */ ?>
<?php /*%%SmartyHeaderCode:79424475152a4ae02a65be1-37348532%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '83feda28360bf37778038fc260d446a53e450668' => 
    array (
      0 => '/Users/vikramraj/Sites/Training/rg/application/views/search/side.tpl',
      1 => 1386270847,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '79424475152a4ae02a65be1-37348532',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'article' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_52a4ae02ab2f60_22099444',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a4ae02ab2f60_22099444')) {function content_52a4ae02ab2f60_22099444($_smarty_tpl) {?>                <h2>Citations</h2>
                <?php if (is_array($_smarty_tpl->tpl_vars['list']->value)==true&&count($_smarty_tpl->tpl_vars['list']->value)>0) {?>
                	<ol id="citations">
                	<?php  $_smarty_tpl->tpl_vars['article'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['article']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['article']->key => $_smarty_tpl->tpl_vars['article']->value) {
$_smarty_tpl->tpl_vars['article']->_loop = true;
?>
                    	<li class="clear-fix"><?php echo $_smarty_tpl->tpl_vars['article']->value->vancouverCitation;?>
<a href="#" data-pmid="<?php echo $_smarty_tpl->tpl_vars['article']->value->pmid;?>
">Remove</a></li>
                    <?php } ?>
                    </ol>
                <?php } else { ?>
                	<p>Add references to build a numbered list. Click the "Add to list" link to add the corresponding reference to your collection. Order of the references can be rearranged by dragging and dropping the references.</p>
                <?php }?>
            <?php }} ?>
