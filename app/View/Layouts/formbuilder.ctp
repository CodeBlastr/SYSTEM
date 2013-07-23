<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Form Buildrr</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="/Answers/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="/Answers/css/lib/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="/Answers/css/custom.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<?php echo $this->Html->css('twitter-bootstrap/bootstrap.custom') . "\r"; ?>
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <?php echo $scripts_for_layout; ?>
  </head>

 <body class="<?php echo __('%s %s %s', $this->request->params['controller'], $this->request->params['action'], ($this->Session->read('Auth.User') ? __(' authorized') : __(' restricted'))); ?>" id="<?php echo !empty($this->request->params['pass'][0]) ? strtolower($this->request->params['controller'].'_'.$this->request->params['action'].'_'.$this->request->params['pass'][0]) : strtolower($this->request->params['controller'].'_'.$this->request->params['action']); ?>" lang="<?php echo Configure::read('Config.language'); ?>">
  	<?php echo $this->Element('twitter-bootstrap/header'); ?> 
	
    <div class="container">
  	<h1><?php echo $title_for_layout; ?></h1>
  	<hr />
  	
  	
  	<?php echo $this->Session->flash(); ?>
    <?php echo $content_for_layout; ?>
    
    <footer>
        	<hr />
            <?php echo defined('__SYSTEM_SITE_NAME') ? __('<p>&copy; %s %s</p>', __SYSTEM_SITE_NAME, date('Y')) : __('<p>&copy; Company %s</p>', date('Y')); ?>
        </footer>
		
		<?php echo $this->Element('sql_dump');  ?> <?php echo !empty($dbSyncError) ? $dbSyncError : null; ?> 
    </div> <!-- /container -->
    
    <script data-main="/Answers/js/main-built.js" src="/Answers/js/lib/require.js" ></script>
  </body>
</html>