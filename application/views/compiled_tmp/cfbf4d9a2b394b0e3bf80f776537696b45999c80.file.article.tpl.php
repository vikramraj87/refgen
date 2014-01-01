<?php /* Smarty version Smarty-3.1.15, created on 2013-12-31 00:48:15
         compiled from "/Users/vikramraj/Sites/Training/rg/application/views/search/article.tpl" */ ?>
<?php /*%%SmartyHeaderCode:209372620952a837e0022c71-40596777%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cfbf4d9a2b394b0e3bf80f776537696b45999c80' => 
    array (
      0 => '/Users/vikramraj/Sites/Training/rg/application/views/search/article.tpl',
      1 => 1388431092,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '209372620952a837e0022c71-40596777',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_52a837e00b5a93_57381904',
  'variables' => 
  array (
    'article' => 0,
    'short' => 0,
    'h' => 0,
    'p' => 0,
    'citation' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a837e00b5a93_57381904')) {function content_52a837e00b5a93_57381904($_smarty_tpl) {?>                <article>
                    <header>
                        <h2><?php echo $_smarty_tpl->tpl_vars['article']->value->title;?>
</h2>
                        <?php if (empty($_smarty_tpl->tpl_vars['article']->value->authors)==true) {?>
                        <h3>[No authors listed]</h3>
                        <?php } else { ?>
                        <h3><?php echo implode(", ",$_smarty_tpl->tpl_vars['article']->value->authors);?>
</h3>
                        <?php }?>
                    </header>
                    <?php if (empty($_smarty_tpl->tpl_vars['article']->value->abstract)!=true) {?>
                    <div class="abstract clearfix">
                        <h3>Abstract</h3>
                        <?php if ($_smarty_tpl->tpl_vars['short']->value===true) {?>
                        <p class="truncated"><?php echo $_smarty_tpl->tpl_vars['article']->value->truncatedAbstract;?>
</p>
                            <?php if ((count($_smarty_tpl->tpl_vars['article']->value->abstract)===1&&strlen($_smarty_tpl->tpl_vars['article']->value->abstract[0])>300)||count($_smarty_tpl->tpl_vars['article']->value->abstract)>1) {?>
                        <div class="full" hidden="hidden">
                                <?php if (count($_smarty_tpl->tpl_vars['article']->value->abstract)>1) {?>
                                    <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['h'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['article']->value->abstract; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value) {
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['h']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
                                        <?php if (is_string($_smarty_tpl->tpl_vars['h']->value)==true) {?>
                            <h4><?php echo $_smarty_tpl->tpl_vars['h']->value;?>
</h4>
                                        <?php }?>
                            <p><?php echo $_smarty_tpl->tpl_vars['p']->value;?>
</p>
                                    <?php } ?>
                                <?php } else { ?>
                            <p><?php echo $_smarty_tpl->tpl_vars['article']->value->abstract[0];?>
</p>
                                <?php }?>
                        </div>
                        <p class="read-more"><a href="/search/display/pmid/<?php echo $_smarty_tpl->tpl_vars['article']->value->pmid;?>
">read more</a></p
                            <?php }?>
                        <?php } else { ?>
                            <?php if (count($_smarty_tpl->tpl_vars['article']->value->abstract)>1) {?>
                                <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['h'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['article']->value->abstract; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value) {
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['h']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
                                    <?php if (is_string($_smarty_tpl->tpl_vars['h']->value)==true) {?>
                    <h4><?php echo $_smarty_tpl->tpl_vars['h']->value;?>
</h4>
                                    <?php }?>
                    <p><?php echo $_smarty_tpl->tpl_vars['p']->value;?>
</p>
                                <?php } ?>
                            <?php } elseif (count($_smarty_tpl->tpl_vars['article']->value->abstract)==1) {?>
                    <p><?php echo $_smarty_tpl->tpl_vars['article']->value->abstract[0];?>
</p>
                            <?php }?>
                        <?php }?>
                    </div>
                    <?php }?>
                    <footer>
                        <p class="pmid">PMID: <a href="http://www.ncbi.nlm.nih.gov/pubmed/<?php echo $_smarty_tpl->tpl_vars['article']->value->pmid;?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['article']->value->pmid;?>
</a></p>
                        <p>Cite by: <span class="citation"><?php echo $_smarty_tpl->tpl_vars['citation']->value->getCitation($_smarty_tpl->tpl_vars['article']->value);?>
</span></p>
                        <p class="add-to-list">
                            <a href="/search/add/pmid/<?php echo $_smarty_tpl->tpl_vars['article']->value->pmid;?>
?redirect=<?php echo $_SERVER['REQUEST_URI'];?>
" data-pmid="<?php echo $_smarty_tpl->tpl_vars['article']->value->pmid;?>
">+</a>
                        </p>
                    </footer>
                </article><?php }} ?>
