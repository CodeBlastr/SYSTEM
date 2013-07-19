<?php
if (defined('__APP_LINK_PERMISSIONS') && @unserialize(__APP_LINK_PERMISSIONS)) { ?>
	<script type="text/javascript">
		$(document).ready(function() {
		<?php
		$linkPermissions = unserialize(__APP_LINK_PERMISSIONS);
		foreach ($linkPermissions['link'] as $uri => $userRoles) {
			$userRoles = explode(',', $userRoles);
			// first hide everything with data-check-acces ?>
			$('a[data-permissions="true"]').hide();
			<?php
			// then show the ones that are good
			if (in_array($__userRoleId, $userRoles) || $__userRoleId == 1) { ?>
				$.each($('a[data-permissions="true"]'), function () {
					if ($(this).attr('href') == '<?php echo $uri; ?>') {
						$(this).show();
					}
				});
			<?php
			}
		} ?>
		});
	</script>
<?php
} ?>