<?php /* Smarty version Smarty-3.1.15, created on 2013-12-25 17:48:53
         compiled from "/Users/vikramraj/Sites/Training/rg/application/layouts/twocol.tpl" */ ?>
<?php /*%%SmartyHeaderCode:155361291752a4ad1dc3bf42-12428605%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e9dd32e45e615602bd567b2d6b28e7156179c5ef' => 
    array (
      0 => '/Users/vikramraj/Sites/Training/rg/application/layouts/twocol.tpl',
      1 => 1387973931,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '155361291752a4ad1dc3bf42-12428605',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_52a4ad1dc72664_46405608',
  'variables' => 
  array (
    '_title' => 0,
    '_query' => 0,
    '__content' => 0,
    '__side' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a4ad1dc72664_46405608')) {function content_52a4ad1dc72664_46405608($_smarty_tpl) {?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $_smarty_tpl->tpl_vars['_title']->value;?>
</title>
    <meta name="description" content="Kivi reference generator is a simple and easy to use Vancouver system reference generator. The articles can be searched through Pubmed and the citations can be obtained in the Vancouver format">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <!-- Web Font applied-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/vendor/modernizr-2.6.2.min.js"></script>
</head>
<body>
<!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Add your site or application content here -->
    <div id="container">
        <header id="page-header" class="clearfix">
            <div id="search-result">
                <form id="form-search" name="form-search" action="http://thost/search/result" method="get">
                    <div id="div-search" class="clearfix">
                        <input type="image" src="/img/search.png" id="img-search" alt="Search">
                        <input type="text" name="term" id="txt-search" placeholder="Search via pubmed" value="<?php echo $_smarty_tpl->tpl_vars['_query']->value;?>
">
                    </div>
                </form>
            </div> <!-- #search -->
            <h1>k<span>i</span>v<span>!</span></h1>
            <h2>Reference generator</h2>
        </header>
        <section id="results">
        	<?php echo $_smarty_tpl->tpl_vars['__content']->value;?>

        </section>
        <section id="sidebar">
            <?php echo $_smarty_tpl->tpl_vars['__side']->value;?>

        </section>
        </div> <!-- holder_content -->
        <footer id="page-footer">
            <div id="FooterTwo"> © 2013 <span>kiv!</span> designers </div>
        </footer>
	</div>   <!-- #container -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
    <script src="/js/plugins.js"></script>
    <script src="/js/main.js"></script>
</body>
</html><?php }} ?>
