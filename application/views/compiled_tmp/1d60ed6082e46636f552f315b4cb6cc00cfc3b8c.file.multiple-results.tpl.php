<?php /* Smarty version Smarty-3.1.15, created on 2013-12-30 20:41:09
         compiled from "/Users/vikramraj/Sites/Training/rg/application/views/search/multiple-results.tpl" */ ?>
<?php /*%%SmartyHeaderCode:210781944152a4a973e28843-64770104%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1d60ed6082e46636f552f315b4cb6cc00cfc3b8c' => 
    array (
      0 => '/Users/vikramraj/Sites/Training/rg/application/views/search/multiple-results.tpl',
      1 => 1388416227,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '210781944152a4a973e28843-64770104',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_52a4a973f18cd8_67970857',
  'variables' => 
  array (
    'result' => 0,
    'article' => 0,
    'citation' => 0,
    'pagination' => 0,
    'query' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a4a973f18cd8_67970857')) {function content_52a4a973f18cd8_67970857($_smarty_tpl) {?>							<?php  $_smarty_tpl->tpl_vars['article'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['article']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['result']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['article']->key => $_smarty_tpl->tpl_vars['article']->value) {
$_smarty_tpl->tpl_vars['article']->_loop = true;
?>
                <?php echo $_smarty_tpl->getSubTemplate ("article.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('short'=>true,'article'=>$_smarty_tpl->tpl_vars['article']->value,'citation'=>$_smarty_tpl->tpl_vars['citation']->value), 0);?>

                            <?php } ?>
                <?php if ($_smarty_tpl->tpl_vars['pagination']->value->isRequired()) {?>
                <ol id="pagination">
                	<?php if ($_smarty_tpl->tpl_vars['pagination']->value->isFirst()) {?>
                    <li class="page first"><a href="/search/result/term/<?php echo $_smarty_tpl->tpl_vars['query']->value;?>
/page/1">&lt;&lt;</a></li>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['pagination']->value->getPrev()) {?>
                    <li class="page prev"><a href="/search/result/term/<?php echo $_smarty_tpl->tpl_vars['query']->value;?>
/page/<?php echo $_smarty_tpl->tpl_vars['pagination']->value->getPrev();?>
">&lt;</a></li>
                    <?php }?>
                    <?php  $_smarty_tpl->tpl_vars['page'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['page']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['pagination']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['page']->key => $_smarty_tpl->tpl_vars['page']->value) {
$_smarty_tpl->tpl_vars['page']->_loop = true;
?>
                    <li class="page num">
                    	<?php if ($_smarty_tpl->tpl_vars['pagination']->value->getCurrPage()==$_smarty_tpl->tpl_vars['page']->value) {?>
                        <span><?php echo $_smarty_tpl->tpl_vars['page']->value;?>
</span>
                        <?php } else { ?>
                        <a href="/search/result/term/<?php echo $_smarty_tpl->tpl_vars['query']->value;?>
/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['page']->value;?>
</a>
                        <?php }?>
                 	<?php } ?>
                	<?php if ($_smarty_tpl->tpl_vars['pagination']->value->getNext()) {?>
                    <li class="page prev"><a href="/search/result/term/<?php echo $_smarty_tpl->tpl_vars['query']->value;?>
/page/<?php echo $_smarty_tpl->tpl_vars['pagination']->value->getNext();?>
">&gt;</a></li>
                    <?php }?>
 
                </ol>
                <?php }?><?php }} ?>
