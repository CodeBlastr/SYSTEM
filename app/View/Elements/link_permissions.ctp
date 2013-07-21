<?php if (defined('__APP_LINK_PERMISSIONS') && $__userRoleId != 1) { ?>
<script type="text/javascript">
	$(function() {
		// first hide everything with data-check-acces 
		//$('a[data-permissions="true"]').hide();
		// lets add an attribute instead and let the site css handle it
		$('a[data-permissions="true"]').attr('data-access', 'false');
		<?php
		foreach (unserialize(__APP_LINK_PERMISSIONS) as $uri => $userRoles) {
			$userRoles = explode(',', $userRoles);
			// then show the links that we have access to
			// echo __("$('a[data-permissions=\"true\"][href*=\"%s\"]').show();%s\t\t\t", $uri, PHP_EOL);
			// make data-access attribute true for the items that we have access to
			if (in_array($__userRoleId, $userRoles) || $__userRoleId == 1) {
				echo __("$('a[data-permissions=\"true\"][href*=\"%s\"]').attr('data-access', 'true');%s\t\t\t", $uri, PHP_EOL);
				if(strpos($uri, 'index')) {
					// get everything up to the first slash because 'index' values can be shortened
					preg_match('/\/[^\/]*/', $uri, $shortUri);
					// remove the * after href for an exact match on the short href value
					echo __("$('a[data-permissions=\"true\"][href=\"%s\"]').attr('data-access', 'true');%s\t\t\t", $shortUri[0], PHP_EOL);
				} 
			}
		} ?>
	});
</script>
<?php } ?>
