<div id="loginWrapper">

	<div id="Register" class="panel">
		<div id="userRegisterWrapper" class="row">
			<div class="col-sm-6">
				<h2>Register</h2>
				<?php echo $this->element('register'); ?>
			</div>
			<div id="sidebarPromo" class="col-sm-6 text-center">
				<a class="btn btn-default scrnChange" href="#Login">I already have an account</a>
			</div>
		</div>
	</div>

	<div id="Login" class="panel">
		<div id="userLoginWrapper" class="row">
			<div class="col-sm-6 text-center">
				<a class="btn btn-default scrnChange" href="#Register">Register a new account</a>
			</div>
			<div class="col-sm-6">
				<h2>Login</h2>
				<?php echo $this->element('login_form'); ?>
			</div>
		</div>
	</div>

</div>

<script type="text/javascript">
	(function($) {

		if (window.location.hash.length > 0) {
			$('#loginWrapper a[href="' + window.location.hash + '"]').tab('show');
		} else {
			$('#Login').hide();
		}

		window.addEventListener('popstate', function(event) {
			if (window.location.hash.length > 0) {
				$('#loginWrapper a[href="' + window.location.hash + '"]').tab('show');
			}
		});

		$('.scrnChange').click(function(e) {
			//console.log('click');
			e.preventDefault();
			var id = $(this).attr('href');
			$('#loginWrapper .panel').hide();
			$(id).show('fast');
		});

	})(jQuery); 
</script>