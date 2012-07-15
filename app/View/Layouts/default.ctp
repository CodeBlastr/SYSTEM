<!DOCTYPE html> 
<html> 
<head> 
	
    <title><?php echo $title_for_layout; __(' : Zuha Business Management'); ?></title>
	<?php echo $this->Html->charset() . "\n"; ?>
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css" />
    <?php echo $this->Html->css('system'); ?>
    <?php echo $this->Html->css('mobile/mobile'); ?>
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.js"></script>
	<?php 
	echo $this->Html->meta('icon');
	echo $scripts_for_layout;
	if (defined('__REPORTS_ANALYTICS')) {
		echo $this->Element('analytics', array(), array('plugin' => 'reports'));
	}
	echo "\n"; ?>
</head> 
<body class="<?php echo __('%s %s %s', $this->request->params['controller'], $this->request->params['action'], ($this->Session->read('Auth.User') ? __(' authorized') : __(' restricted'))); ?>" id="<?php echo !empty($this->request->params['pass'][0]) ? strtolower($this->request->params['controller'].'_'.$this->request->params['action'].'_'.$this->request->params['pass'][0]) : strtolower($this->request->params['controller'].'_'.$this->request->params['action']); ?>" lang="<?php echo Configure::read('Config.language'); ?>">

<div data-role="page">
		
	<?php echo $this->Element('mobile/header'); ?> 
    
	<?php //echo !empty($tabsElement) ? $this->Element($tabsElement.'/tabs', array(), array('plugin' => $this->request->params['plugin'])) : ''; ?><!-- /header -->

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
<?php echo $this->Element('sql_dump');  ?> <?php echo !empty($dbSyncError) ? $dbSyncError : null; ?> 
</body>
</html>

<?php /*
echo $this->Html->css('system');
echo $this->Html->css('admin/jquery-ui-1.8.13.custom');
echo $this->Html->css('admin/mobi');
// no rhyme or reason about the directory structure here, needs to be cleaned up at some point
echo $this->Html->script('jquery-1.5.2.min'); // there are some things not working with the latest jquery
echo $this->Html->script('admin/jquery-ui-1.8.13.custom.min');
echo $this->Html->script('jquery.jeditable');
echo $this->Html->script('admin/jquery.truncator');
echo $this->Html->script('system/system');  ?>
</head>

  <div id="siteContent">
    <div id="contentWrap">
      <div id="content"> 
        <?php $helper_text_for_layout = !empty($helper_text_for_layout) ? $helper_text_for_layout : null; ?>
        <?php echo $this->Element('admin/helper_text', array('overwrite' => $helper_text_for_layout)); ?>
        <!-- #compareChartHeader -->
        <?php
	
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
	} ?> 
        <div class="contentSection"> <?php echo $content_for_layout; ?> </div>
        <!-- #compareChart -->
        <?php echo $this->Element('context_menu'); ?> </div>
    </div>
  </div>
  <?php echo $this->Element('admin/footer_nav'); ?> <?php echo $this->Element('sql_dump');  ?> <?php echo !empty($dbSyncError) ? $dbSyncError : null; ?> </div>
<div class="ajaxLoader"><img src="/img/ajax-loader.gif" /></div>
</body>
</html>*/ ?>