    <div data-role="header" data-theme="c">
		<?php echo $this->Element('page_title'); ?>	
        <a href="/admin" class="floManagrLogo">flo<span class="floManagrLogoBlue">Managr</spa></a>
		<?php echo !empty($quickNavBeforeBack_callback) ? $quickNavAfterBack_callback : '' ; ?><?php echo !empty($quickNavAfterBack_callback) ? $quickNavAfterBack_callback : '<a data-rel="back" data-icon="back" data-iconpos="notext" data-direction="reverse">Back</a>' ; ?>
		<?php /*<a href="/forms/forms/add" data-icon="search" data-iconpos="notext" data-rel="dialog" data-transition="fade">Search</a> */ ?>
        
        <?php echo $this->Element('context_menu'); ?>
        
	</div>
