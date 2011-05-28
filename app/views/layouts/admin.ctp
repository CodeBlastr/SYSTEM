<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
	echo $this->Html->css('admin/admin');
	
	echo $this->Html->script('jquery-1.5.2.min');
	echo $this->Html->script('admin/admin');
	echo $this->Html->script('admin/jquery-ui-1.8.13.custom.min');
	echo $this->Html->script('jquery.jeditable');
	echo $this->Html->script('admin/jquery.truncator');
	echo $scripts_for_layout;  
?>
</head>
<body class="<?php echo $this->params['controller']; ?><?php if($session->read('Auth.User')) : __(' authorized'); else : __(' restricted'); endif; ?>">
<div id="siteWrap"> <?php echo $this->Element('admin/global_nav'); ?>
  <div id="tabs">
    <h1><?php echo !empty($page_title_for_layout) ? $page_title_for_layout : null; ?></h1>
    <ul id="leadTab">
      <li><a href="#contentWrap"><span><?php echo $title_for_layout; ?></span></a></li>
      <?php if (!empty($tabs_for_layout)) : foreach ($tabs_for_layout as $tab) : ?>
      <li><a href="<?php echo $tab['link']; ?>"><span><?php echo $tab['linkText']; ?></span></a></li>
      <?php endforeach; endif; ?>
    </ul>
    <div id="content">
      <div id="sideBar">
        <div id="sideBarArrow"> <img src="/img/admin/compare_bubble_alert_arrow.png" width="12" height="31" alt=""> </div>
        <a href="#" class="close"></a> <?php echo (!empty($menu_for_layout) ? $menu_for_layout : ''); ?> </div>
      <div id="contentWrap"> <?php echo $this->Session->flash(); ?> <?php echo $this->Session->flash('auth'); ?>
        <div class="helperText">
          <ul>
            <li class="info">
              <h2>Explanation Text</h2>
              <p>Some text describing this section, so that its easy to use. (put an x button so that you can turn off hints if you want to.</p>
            </li>
          </ul>
        </div>
        <!-- #compareChartHeader -->
        <div class="contentSection"> <?php echo $content_for_layout; ?> </div>
        <!-- #compareChart -->
      </div>
    </div>
  </div>
  <?php echo $this->Element('admin/footer_nav'); ?> <?php echo $this->Element('sql_dump');  ?> <?php echo $dbSyncError; ?> </div>
</body>
</html>