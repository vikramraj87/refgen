<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{$_title}</title>
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
                        <input type="text" name="term" id="txt-search" placeholder="Search via pubmed" value="{$_query}">
                    </div>
                </form>
            </div> <!-- #search -->
            <h1>k<span>i</span>v<span>!</span></h1>
            <h2>Reference generator</h2>
        </header>
        <section id="results">
        	{$__content}
        </section>
        <section id="sidebar">
            {$__side}
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
</html>