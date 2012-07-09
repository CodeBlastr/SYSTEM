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
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.forms.views.elements
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
?>
<?php 
// this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
// it allows a database driven way of configuring elements, and having multiple instances of that configuration.
	if(!empty($instance) && defined('__REPORTS_ANALYTICS_'.$instance)) {
		extract(unserialize(constant('__REPORTS_ANALYTICS_'.$instance)));
	} else if (defined('__REPORTS_ANALYTICS')) {
		extract(unserialize(__REPORTS_ANALYTICS));
	}
	
// setup the defaults
$setAccount = !empty($setAccount) ? "_gaq.push(['_setAccount', '".$setAccount."']);" : null;
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
if (!empty($setAccount)) {
?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  <?php echo $setAccount; ?>
  <?php echo $setDomainName; ?>
  <?php echo $setAllowLinker; ?>
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php 
} 
?>