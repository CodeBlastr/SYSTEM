<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head>
<?php echo $html->charset(); ?>
<title><?php echo $title_for_layout; __(' : Zuha Business Management'); ?></title>
<?php
	echo $this->Html->meta('icon');
	echo $this->Html->css('admin/ui_design');
	echo $this->Html->css('admin/early_zuha');
	echo $this->Html->css('admin/admin');
	echo $this->Html->script('jquery-1.5.2.min');
	echo $this->Html->script('jquery.jeditable');
	echo $this->Html->script('admin/jquery.truncator');
	echo $this->Html->script('admin/admin');
	echo $this->Html->script('admin/jquery-ui-1.8.custom.min');
	echo $scripts_for_layout;  
?>
</head>
<body class="<?php echo $this->params['controller']; ?><?php if($session->read('Auth.User')) : __(' authorized'); else : __(' restricted'); endif; ?>">
<?php echo $this->Element('admin/global_nav'); ?>
<?php echo $this->Session->flash(); ?>
<?php echo $this->Session->flash('auth'); ?>
<div id="contentWrapper">
  <h1 class="contentHeading"><?php echo !empty($page_title_for_layout) ? $page_title_for_layout : null; ?></h1>
  
<div id="tabs">
  <ul>
    <li><span class="ls">&nbsp;</span><a href="#t1" class="active"><span class="text"><?php echo $title_for_layout; ?></span></a><span class="rs">&nbsp;</span></li>
    <?php if (!empty($tabs_for_layout)) : foreach ($tabs_for_layout as $tab) : ?>
    <li><span class="ls">&nbsp;</span><a href="<?php echo $tab['link']; ?>"><span class="text"><?php echo $tab['linkText']; ?></span></a><span class="rs">&nbsp;</span></li>
    <?php endforeach; endif; ?>
  </ul>
  <img class="fix shadow" id="bs" src="/img/admin/shadow_knowhow_top.png" width="899" height="10" alt=""> </div>
<div class="content">
<div id="sideBar">
  <div id="sideBarArrow"> <img src="/img/admin/compare_bubble_alert_arrow.png" width="12" height="31" alt=""> </div>
  <a href="#" class="close"></a>
  <?php echo (!empty($menu_for_layout) ? $menu_for_layout : ''); ?>
</div>
<!-- end side bar -->
<div id="t1" class="leftContent">
  <div id="compareChart">
    <div class="compareChartHeader">
      <ul>
        <li class="info">
          <h2>Explanation Text</h2>
          <p>Some text describing this section, so that its easy to use. (put an x button so that you can turn off hints if you want to.</p>
        </li>
      </ul>
    </div>
    <!-- #compareChartHeader -->
    <div class="contentSection">
  <?php echo $content_for_layout; ?>
    </div>
    <!-- #compareChart -->
  </div>
</div>

</div>
<?php echo $this->Element('admin/footer_nav'); ?>
<?php  echo $this->Element('sql_dump'); ?>
</body>
</html>