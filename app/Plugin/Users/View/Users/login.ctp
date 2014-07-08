<div id="content" class="userLoginRegistrationElement">
	<div id="register" class="collapse">
		<div class="row table">
			<div class="col-sm-6 table-cell">
				<?php echo $this->element('register'); ?>
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
				<?php echo $this->element('login_form'); ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function() {
		$('.userLoginRegistrationElement a[data-parent]').click(function(e) {
			var parent = $(this).attr('data-parent');
			var self = $(this).attr('data-target');
			//console.log(parent + ' ' + self);
			$(parent + ' .collapse').removeClass('in');
			$(parent + ' ' + self).addClass('in');
			return false;
		});

		// link to /users/users/login/#register to show the register form
		if (window.location.hash.length > 0) {
			//console.log(window.location.hash + '.collapse');
			$('.collapse').removeClass('in');
			$(window.location.hash + '.collapse').addClass('in');
		}
	});
</script>