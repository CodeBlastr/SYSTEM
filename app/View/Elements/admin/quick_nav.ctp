	<div data-role="header">
		<?php echo $this->Element('page_title'); ?>		
		<?php echo !empty($quickNavBeforeBack_callback) ? $quickNavAfterBack_callback : '' ; ?><?php echo !empty($quickNavAfterBack_callback) ? $quickNavAfterBack_callback : '<a data-rel="back" data-icon="back" data-iconpos="notext" data-direction="reverse">Back</a>' ; ?>
		<a href="/forms/forms/add" data-icon="search" data-iconpos="notext" data-rel="dialog" data-transition="fade">Search</a>
	</div>
