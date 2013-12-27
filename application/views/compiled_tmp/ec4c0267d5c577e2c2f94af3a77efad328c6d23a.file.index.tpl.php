<?php /* Smarty version Smarty-3.1.15, created on 2013-12-18 22:30:16
         compiled from "/Users/vikramraj/Sites/Training/rg/application/views/index/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6348823752a4986ac79f29-54884846%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ec4c0267d5c577e2c2f94af3a77efad328c6d23a' => 
    array (
      0 => '/Users/vikramraj/Sites/Training/rg/application/views/index/index.tpl',
      1 => 1387385998,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6348823752a4986ac79f29-54884846',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_52a4986accc7e7_10339223',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a4986accc7e7_10339223')) {function content_52a4986accc7e7_10339223($_smarty_tpl) {?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>kiv! reference generator</title>
        <meta name="description" content="Kivi reference generator is a simple and easy to use Vancouver system reference generator. The articles can be searched through Pubmed and the citations can be obtained in the Vancouver format">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        
        <!-- Web Font applied-->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="/favicon.ico">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div id="container">
            <header id="page-header">
                <h1>k<span>i</span>v<span>!</span></h1>
                <h2>reference generator</h2>
            </header>
            <div id="search">
                <form id="form-search" name="form-search" action="/search/result" method="get">
                    <div id="div-search" class="clearfix">
                        <input type="image" src="img/search.png" id="img-search" alt="Search">
                        <input type="text" name="term" id="txt-search" placeholder="Search via pubmed">
                    </div>
                </form>
            </div> <!-- #search -->
            <div id="column-wrapper" class="clearfix">
                <section class="col col1">
                    <h2>By PMID</h2>
                    <p>Search with PMID (the 8 digit number unique for each article) for specific article. Then generating a reference in Vancouver format is just a click away. </p>
                </section>

                <section class="col col2">
                    <h2>By Text</h2>
                    <p>If PMID is not known, just search using text. Multiple articles matching the search criteria will be displayed. Then the article of your choice can be selected and reference generated.</p>
                </section>

                <section class="col col3">
                    <h2>Build References</h2>
                    <p>You can search by PMID or text and add the generated references to your collection. Following which, you can get all the selected references as a list.</p>
                </section>
            </div> <!-- column-wrapper -->
            <footer id="page-footer">
                <div> © 2013 <span>kiv!</span> designers </div>
            </footer>
	    </div>   <!-- #container -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
<?php }} ?>
