<?php if (defined('__APP_LINK_PERMISSIONS') && Configure::read('debug') < 2) { ?>
<script type="text/javascript">
	$(function() {
		// first hide everything with data-check-acces 
		$('a[data-permissions="true"]').hide();
		<?php
		// then show the ones that are good
		foreach (unserialize(__APP_LINK_PERMISSIONS) as $uri => $userRoles) {
			$userRoles = explode(',', $userRoles);
			if (in_array($__userRoleId, $userRoles) || $__userRoleId == 1) { 
				echo __("$('a[data-permissions=\"true\"][href*=\"%s\"]').show();%s\t\t\t", $uri, PHP_EOL);
			}
		} ?>
	});
</script>
<?php } ?>
