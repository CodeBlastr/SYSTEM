<div id="content">
	<div id="register" class="collapse">
		<div class="row table">
			<div class="col-sm-6 table-cell">
				<?php echo $this->element('Users.register'); ?>
			</div>
			<div class="col-sm-6 text-center vertical-center table-cell">
				<a href="#login" class="btn btn-default" data-parent="#content" data-target="#login">I already have an account</a>
			</div>
		</div>
	</div>

	<div id="login" class="collapse in">
		<div class="row table">
			<div class="col-sm-6 text-center vertical-center table-cell">
				<a href="#register" class="btn btn-default" data-parent="#content" data-target="#register">Register a new account</a>
			</div>
			<div class="col-sm-6 table-cell">
				<h2>Login</h2>
				<?php echo $this->element('Users.login-form'); ?>
			</div>
		</div>
	</div>
</div>
<?php $script =
<<< EOT
	jQuery(function() {
		jQuery('a[data-parent]').click(function(e) {
			var parent = jQuery(this).attr('data-parent');
			var self = jQuery(this).attr('data-target');
			console.log(parent + ' ' + self);
			jQuery(parent + ' .collapse').removeClass('in');
			jQuery(parent + ' ' + self).addClass('in');
		});

		// link to /users/users/login/#register to show the register form
		if (window.location.hash.length > 0) {
			console.log(window.location.hash + '.collapse');
			jQuery('.collapse').removeClass('in');
			jQuery(window.location.hash + '.collapse').addClass('in');
		}
	});
EOT;
echo $this->Html->scriptBlock($script, array('inline' => false)); ?>