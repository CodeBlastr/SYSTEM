<!DOCTYPE html>
<html lang="en">
<head>
<?php echo $this->Html->charset() . "\n"; ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php echo $title_for_layout; __(' : floManagr'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
</style>
<!--link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" /-->
<style type="text/css">
	  .ui-mobile [data-role="page"] {
		  width: auto;
		  /*padding: inherit;*/
		  position: relative;
	  }      
</style>
<?php echo $this->Html->css('twitter-bootstrap/bootstrap.min'); ?> 

<?php echo $this->Html->script('http://code.jquery.com/jquery-latest.js'); ?>
<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>

<?php echo $this->Html->meta('icon'); ?>
<?php /* change to this some time soon 10/15/2012
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png"> */ ?>
<?php echo $this->Html->script('plugins/modernizr-2.6.1-respond-1.1.0.min'); ?>
<?php echo $scripts_for_layout; ?>
<?php echo defined('__REPORTS_ANALYTICS') ? $this->Element('analytics', array(), array('plugin' => 'reports')) : null; ?>
</head>
<body class="<?php echo __('%s %s %s', $this->request->params['controller'], $this->request->params['action'], ($this->Session->read('Auth.User') ? __(' authorized') : __(' restricted'))); ?>" id="<?php echo !empty($this->request->params['pass'][0]) ? strtolower($this->request->params['controller'].'_'.$this->request->params['action'].'_'.$this->request->params['pass'][0]) : strtolower($this->request->params['controller'].'_'.$this->request->params['action']); ?>" lang="<?php echo Configure::read('Config.language'); ?>">
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->

		<?php echo $this->Element('twitter-bootstrap/header'); ?> 

        <div class="container">
       		<?php echo $this->Session->flash(); ?> <?php echo $this->Session->flash('auth') . "\n"; ?>
        	<h1><?php echo $this->Element('twitter-bootstrap/page_title'); ?></h1>

            <!-- Main hero unit for a primary marketing message or call to action -->
            <div class="hero-unit" data-role="content">
            <?php echo $content_for_layout; ?> 
            
        
<!-- need to test some default html pre class="prettyprint linenums">
&lt;div class="row"&gt;
  &lt;div class="span4"&gt;...&lt;/div&gt;
  &lt;div class="span8"&gt;...&lt;/div&gt;
&lt;/div&gt;
</pre-->

                
            </div>

            <!-- Example row of columns -->
            <div class="row">
                <div class="span4">
                    <h2>Heading</h2>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn" href="#">View details &raquo;</a></p>
                </div>
                <div class="span4">
                
                    <h2>Heading</h2>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn" href="#">View details &raquo;</a></p>
               </div>
                <div class="span4">
                    <h2>Heading</h2>
                    <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                    <p><a class="btn" href="#">View details &raquo;</a></p>
                </div>
            </div>

            <hr />
            
            <h2>Live grid example</h2>
          <p>The default Bootstrap grid system utilizes <strong>12 columns</strong>, making for a 940px wide container without <a href="./scaffolding.html#responsive">responsive features</a> enabled. With the responsive CSS file added, the grid adapts to be 724px and 1170px wide depending on your viewport. Below 767px viewports, the columns become fluid and stack vertically.</p>
          <div class="bs-docs-grid">
            <div class="row show-grid">
              <div class="span1">class = span1</div>
              <div class="span1">class = span1</div>
              <div class="span1">class = span1</div>
              <div class="span1">class = span1</div>
              <div class="span1">class = span1</div>
              <div class="span1">class = span1</div>
              <div class="span1">class = span1</div>
              <div class="span1">class = span1</div>
              <div class="span1">class = span1</div>
            </div>
            <div class="row show-grid">
              <div class="span2">2</div>
              <div class="span3">3</div>
              <div class="span4">4</div>
            </div>
            <div class="row show-grid">
              <div class="span4">4</div>
              <div class="span5">5</div>
            </div>
            <div class="row show-grid">
              <div class="span9">9</div>
            </div>
          </div>
          
          <hr />

            <footer>
                <p>&copy; Company 2012</p>
            </footer>
			
			<?php echo $this->Element('sql_dump');  ?> <?php echo !empty($dbSyncError) ? $dbSyncError : null; ?> 
        </div> <!-- /container -->
<?php echo $this->Html->script('twitter-bootstrap/bootstrap.min'); ?>
</body>
</html>





<?php /*


<div data-role="page">
		
	
    

	<div data-role="content">
		<?php 
		echo $this->Session->flash(); ?> <?php echo $this->Session->flash('auth') . "\n";
		# matches element template tags like {element: plugin.name.instance} for example {element: contacts.recent.2}
		preg_match_all ("/(\{element: ([az_]*)([^\}\{]*)\})/", $content_for_layout, $matches);
	
		$i=0; 
		foreach ($matches[0] as $elementMatch) {
			$element = trim($matches[3][$i]);
			if (preg_match('/([a-zA-Z0-9_\.]+)([a-zA-Z0-9_]+\.[0-9]+)/', $element)) {
				# means there is an instance number at the end
				$element = explode('.', $element);
				# these account for the possibility of a plugin or no plugin
				$instance = !empty($element[2]) ? $element[2] : $element[1]; 
				$plugin = !empty($element[2]) ? $element[0] : null;
				$element = !empty($element[2]) ? $element[1] : $element[0];
			} else if (strpos($element, '.')) {
				# this is used to handle non plugin elements with no instance number in the tag
				$element = explode('.', $element);  
				$plugin = $element[0];
				$element = $element[1];  
			}
			# removed cache for forms, because you can't set it based on form inputs
			# $elementCfg['cache'] = (!empty($userId) ? array('key' => $userId.$element, 'time' => '+2 days') : null);
			
			$elementPlugin['plugin'] = (!empty($plugin) ? $plugin : null);
			$elementCfg['instance'] = (!empty($instance) ? $instance : null);
			$content_for_layout = str_replace($elementMatch, $this->element($element, $elementCfg, $elementPlugin), $content_for_layout); 
			$i++;
		}
		echo $content_for_layout; ?> 

	</div><!-- /content -->
	
	<div data-role="footer">
		<h4>Footer content</h4>
	</div><!-- /footer -->
</div><!-- /page -->
<?php //echo $this->Element('sql_dump');  ?> <?php echo !empty($dbSyncError) ? $dbSyncError : null; ?> 
</body>
</html> */ ?>