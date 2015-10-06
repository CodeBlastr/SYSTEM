<?php
/**
 * Reports Analytics Element
 *
 * An element used to display Google Analytics tracking code.  You must put the template tag {element: reports.analytics} into your template for it to show, and set a setting with your Google Analytics account number at /admin/settings, where key=Element and value = "setAccount = U-XXXXXX"
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.forms.views.elements
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */

if (defined('__REPORTS_ANALYTICS')) :
// this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
// it allows a database driven way of configuring elements, and having multiple instances of that configuration.
	if(!empty($instance) && defined('__REPORTS_ANALYTICS_'.$instance)) {
		extract(unserialize(constant('__REPORTS_ANALYTICS_'.$instance)));
	} else if (defined('__REPORTS_ANALYTICS')) {
		extract(unserialize(__REPORTS_ANALYTICS));
	}
	
	// setup the defaults
	// $setAccount = !empty($setAccount) ? "_gaq.push(['_setAccount', '".$setAccount."']);" : null;
	// .domain.com  (its used when you want multiple sub domains for a single domain)
	$setDomainName = !empty($setDomainName) ? "_gaq.push(['_setDomainName', '".$setDomainName."']);" : null; 
	// either true or not
	if(!empty($setAllowLinker)) {
		$setAllowLinker = "_gaq.push(['_setAllowLinker', true]);";
		// if allowLinker is on then setDomainName must be set to "none", no matter what it was previously set to
		$setDomainName = "_gaq.push(['_setDomainName', 'none']);";
	} else {
		$setAllowLinker = null;
	}
	
	// display the actual script
	if (!empty($setAccount)) : ?>
		<script>
			  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			
			  ga('create', '<?php echo $setAccount; ?>', 'auto');
			  ga('send', 'pageview');
		</script>
	<?php endif; ?>
<?php endif; ?>