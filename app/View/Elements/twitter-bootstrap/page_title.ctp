<?php
$formsSearch = !empty($forms_search) ? $forms_search : @$formsSearch; // deprecated var name 2013-08-31 RK
?>

<nav class="page-title navbar navbar-default navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/admin">
    	<?php echo !empty($page_title_for_layout) ? $page_title_for_layout : Inflector::humanize($this->request->params['controller']); ?>
    </a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <?php echo !empty($formsSearch) ? $this->Element('forms/search', array('formOptions' => array('class' => 'navbar-form navbar-left'))) : null; ?>
    <?php echo $this->Element('twitter-bootstrap/context_menu'); ?>
  </div><!-- /.navbar-collapse -->
</nav>



<?php /*
<div class="page-title navbar navbar-fixed-top">
	<div class="container">
		
		<div class="navbar-left">
		   	<div class="nav-collapse collapase navbar-collapse pull-left">
		   		
		   	
	    		<?php echo $this->Element('twitter-bootstrap/context_menu'); ?>
	    	</div>
		</div>
	</div>
</div> */