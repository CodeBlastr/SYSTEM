<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	{element: favicon}
	<title>{element: title</title><!-- Bootstrap core CSS -->
	<link href="/css/system.css" rel="stylesheet" />
	<link href="/css/twitter-bootstrap.3/bootstrap.min.css" rel="stylesheet">
	<link href="/css/twitter-bootstrap.3/bootstrap.custom.css" rel="stylesheet" />
	{element: css}
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>		<script src="/js/twitter-bootstrap.3/html5shiv.js"></script>		<script src="/js/twitter-bootstrap.3/respond.min.js"></script>		<![endif]-->
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="/js/twitter-bootstrap.3/bootstrap.min.js"></script>
	<script src="/js/twitter-bootstrap.3/bootstrap.custom.js"></script>
	<script src="/js/system.js"></script>
    {element: javascript}
    {element: Webpages.analytics}
</head>
<body {element: body_attributes}>
<!--[if lt IE 7]><p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p><![endif]-->
    <div class="container">
        <header>
            <div class="row-fluid">
                <div class="page-header logo span12 pull-left">
                    <h1 class="brand">{element: site-name}</h1>
                    <div class="row-fluid">
                        <div class="span9 pull-left">
                    		{menu: main-menu}
                    	</div>
                    	<div class="span3 pull-right">
                    		{element: forms/search}
                    	</div>
                    </div>
                </div>
            </div>
        </header>
        <article>
            <div class="content span8 pull-left first">
                {helper: flash_for_layout}
                {helper: flash_auth_for_layout} 
                {helper: content_for_layout}
            </div>
        </article>
        <section>
            <div class="sidebar span3 pull-right last">
                {page: 5}
            </div>
        </section>
        <footer>
            <hr />
            <div class="pull-left">
            	{page: 8}
            </div>
            <div class="pull-right">
            	{page: 9}
            </div>
        </footer>
        {element: sql_dump}
    </div>
</body>
</html>
