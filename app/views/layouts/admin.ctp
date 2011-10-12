<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php echo $html->charset(); ?>
<title><?php echo $title_for_layout; __(' : Zuha Business Management'); ?></title>
<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
<meta name="robots" content="index, follow" />
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<meta name="viewport" content="width=device-width"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<?php
	echo $this->Html->meta('icon');
	echo $this->Html->css('system');
	echo $this->Html->css('admin/jquery-ui-1.8.13.custom');
	echo $this->Html->css('admin/mobi');
	# no rhyme or reason about the directory structure here, needs to be cleaned up at some point
	echo $this->Html->script('jquery-1.5.2.min');
	echo $this->Html->script('admin/jquery-ui-1.8.13.custom.min');
	echo $this->Html->script('jquery.jeditable');
	echo $this->Html->script('admin/jquery.truncator');
	echo $this->Html->script('system/jquery.cookie');
	echo $this->Html->script('admin/admin');
	echo $scripts_for_layout;
	if (defined('__REPORTS_ANALYTICS')) :
		echo $this->Element('analytics', array('plugin' => 'reports'));
	endif;
?>
</head>
<body class="<?php echo $this->params['controller']; ?><?php if($session->read('Auth.User')) : __(' authorized'); else : __(' restricted'); endif; ?>">
<div id="siteWrap"> <?php echo $this->Element('navigation', array('plugin' => 'webpages')); ?>
  <div id="quickNav">
  	<div id="quickNavLeft"><a href="#" class="back">Back</a></div>
	<?php echo $this->Element('page_title'); ?> 
  	<div id="quickNavRight"><a href="/">Home</a> <a href="/" class="search toggleClick" name="siteSearch"><img src="data:image/png;base64,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" /></a></div>
  </div>
  
  <div id="siteSearch" class="hide">
  	<form id="searchForm" method="get" action="/admin/searchable/search_indexes/">
        <div class="input">
          <input type="text" value="Search" id="searchInput" name="term" title="Search" class="grayOut toggleTitle">
        </div>
      </form>
  </div>
  
  <div id="siteContent"> 
  
    <div id="content">
      <div id="contentWrap">
        <div id="navigation"> <?php echo $this->Session->flash(); ?> <?php echo $this->Session->flash('auth'); ?>
          <?php $helper_text_for_layout = !empty($helper_text_for_layout) ? $helper_text_for_layout : null; ?>
          <?php echo $this->Element('admin/helper_text', array('overwrite' => $helper_text_for_layout)); ?>
          <!-- #compareChartHeader -->
          <div class="contentSection"> <?php echo $content_for_layout; ?><?php echo $menu_for_layout; ?> </div>
          <!-- #compareChart -->
        </div>
      </div>
    </div>
  </div>

  <?php echo !empty($tabsElement) ? $this->Element($tabsElement.'/tabs', array('plugin' => $this->params['plugin'])) : ''; ?>
  <?php echo $this->Element('admin/footer_nav'); ?> <?php echo $this->Element('sql_dump');  ?> <?php echo !empty($dbSyncError) ? $dbSyncError : null; ?> </div>
</body>
</html>