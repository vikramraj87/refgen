<?php /* Smarty version Smarty-3.1.15, created on 2013-12-25 18:18:55
         compiled from "/Users/vikramraj/Sites/Training/rg/application/layouts/side.tpl" */ ?>
<?php /*%%SmartyHeaderCode:178544920052a4af88750cc8-10514366%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8db35ab4bce456fbb68ced9d18826777af54fab2' => 
    array (
      0 => '/Users/vikramraj/Sites/Training/rg/application/layouts/side.tpl',
      1 => 1387975734,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '178544920052a4af88750cc8-10514366',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_52a4af8879aa55_37019750',
  'variables' => 
  array (
    'list' => 0,
    'article' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a4af8879aa55_37019750')) {function content_52a4af8879aa55_37019750($_smarty_tpl) {?>                <h2>Citations</h2>
                <?php if (is_array($_smarty_tpl->tpl_vars['list']->value)==true&&count($_smarty_tpl->tpl_vars['list']->value)>0) {?>
                	<ol id="citations">
                	<?php  $_smarty_tpl->tpl_vars['article'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['article']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['article']->key => $_smarty_tpl->tpl_vars['article']->value) {
$_smarty_tpl->tpl_vars['article']->_loop = true;
?>
                    	<li class="clear-fix"><?php echo $_smarty_tpl->tpl_vars['article']->value->vancouverCitation;?>

                            <a
                                href="/search/remove/pmid/<?php echo $_smarty_tpl->tpl_vars['article']->value->pmid;?>
?redirect=<?php echo $_SERVER['REQUEST_URI'];?>
"
                                data-pmid="<?php echo $_smarty_tpl->tpl_vars['article']->value->pmid;?>
">
                                x
                            </a>
                        </li>
                    <?php } ?>
                    </ol>
                    <div id="options" class="clearfix">
                        <a href="#" id="export">export</a>
                    </div>
                <?php } else { ?>
                    <ol id="citations"></ol>
                	<p class="replace">Add references to build a numbered list. Click the "Add to list" link to add the corresponding reference to your collection. Order of the references can be rearranged by dragging and dropping the references.</p>
                <?php }?>
            <?php }} ?>
