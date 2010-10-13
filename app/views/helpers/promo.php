<?php

class PromoHelper extends AppHelper {
    var $beforeValue = '';
    var $afterValue = '';

    function afterRender() {
		# this is the default promo bar
		ob_start();
		?>
	    <div id="promo-bar">
	  		<div class="promo-box" id="promo-box-1">
	    	   	<h4>client <span class="punch">speaks</span></h4>
		        <p>client speaks content</p>
		    </div>
		    <div class="promo-box" id="promo-box-2">
		    	<h4>special <span class="punch">offers</span></h4>
		        <p>special offers content</p>
		    </div>
		    <div class="promo-box" id="promo-box-3">
		       	<h4>newsletter <span class="punch">sign-up</span></h4>
		        <p>special offers content</p>
		    </div>
		 </div>
		<div id="seo-wrap">
		  	<p>Disclaimer or promo, seo type text here. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec facilisis, mauris quis hendrerit ullamcorper, ligula eros ultrices metus, eu gravida purus lacus interdum ipsum. Mauris placerat sollicitudin vulputate. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce id leo nec urna ultricies aliquet sit amet sed arcu. Phasellus quam odio, congue ac facilisis at, malesuada et velit. In dignissim diam sed libero semper mattis. Quisque quis erat vitae velit dictum blandit. Quisque euismod blandit hendrerit. Vestibulum porttitor, diam ac volutpat tempor, sapien dui elementum eros, et vulputate turpis libero vel libero. Morbi eget augue sed arcu porta commodo.</p>
		</div>
		<?php 
		$default = ob_get_clean();
		# end default promo bar 
		
        $view = ClassRegistry::getObject('view');
		$promo = '';
		if (!empty($this->beforeValue)) {
			# show the first parameter before the promo bar
			$promo .= $this->beforeValue;
		}
		if (empty($this->renderDefault) || $this->renderDefault == true) {
			# if it isn't set explicitly to false show it
			$promo .= $default;
		}
		if (!empty($this->afterValue)) {
			# show the second parameter after the promo bar
			$promo .= $this->afterValue;
		} 
		if (!empty($promo)) {
			# wrap into an out put variable and send it to the default template
	    	$view->set('promo_for_layout', $promo);
		}
    }

    function setValue($beforeValue = null, $afterValue = null, $renderDefault = true) {
        $this->beforeValue = $beforeValue;
        $this->renderDefault = $renderDefault;
        $this->afterValue = $afterValue;
    }
}
?>