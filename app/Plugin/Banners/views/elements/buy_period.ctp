<fieldset>
<?php
	if(defined('__ELEMENT_BANNERS_POSITIONS_'.$instance)) {
		extract(unserialize(constant('__ELEMENT_BANNERS_POSITIONS_'.$instance)));
	} else if (defined('__ELEMENT_BANNERS_POSITIONS')) {
		extract(unserialize(__ELEMENT_BANNERS_POSITIONS));
	}
	$bannerType = !empty($bannerType) ? $bannerType : null;
	if($this->params['named']['bannerType'] == $bannerType) {
		echo '<h3>Now you can select a period of dates with one click</h3>';
		echo '<table><tr><td>';
	
		echo $form->button('Week', array('type'=>'button', 'value' => 'week', 
						'class' => 'BannerDateOption submit2'));
		echo '</td><td>';
		echo $form->button('Month', array('type'=>'button', 'value' => 'month', 
						'class' => 'BannerDateOption submit2'));
		echo '</td>';	
	} 
	echo '</tr></table>'
?></fieldset>
