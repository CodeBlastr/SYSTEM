<?php 
	echo $this->Html->script('/galleries/js/fancybox/jquery.mousewheel-3.0.4.pack'); 
	echo $this->Html->script('/galleries/js/fancybox/jquery.fancybox-1.3.4.pack');	
	echo $this->Html->css('/galleries/css/fancybox/jquery.fancybox-1.3.4');	

	$userId = $this->Session->read('Auth.User.id');?>

<?php if (!isset($userId)) {?>
<script>
	$("#loginss").fancybox({
		'scrolling'	: 'no',
		'titleShow'	: false,
		'onClosed'	: function() {
			$("#mesg").hide();
		}
	});
	$("#login_form_submit").live("click", function(e) {
		e.preventDefault();
		$.fancybox.showActivity();
		data = $('#login_form').serializeArray();
		$.ajax({
			type : "POST",
			cache : false,
			dataType: "json",
			url	: "<?php echo $this->Html->url(array("plugin" => "users", "controller" => "users", "action" => "checkLogin")); ?>", 
			data : data,
			success : function(data) {
				if(data['login'] == "1"){
					$("#mesg").hide();
					$('#login_form').submit();
					return true;
				} else {
					$("#mesg").show();
					$("#mesg").html("Login Failed! Invalid username or password");
					return false;
				}
			}
		});
	});

	$("#register_submit").live("click", function(e) {
		$('.requiredFancyBoxField').each(function(){
			$('#' + $(this).attr('id') + 'Error').hide();
			if($(this).val() == '' && $(this).attr('id') != '') {
				$('#' + $(this).attr('id') + 'Error').show();
				e.preventDefault();
			}
		});
	});

</script>
<a href ="#login_page" id ="loginss"></a>
<div style="display: none;">
	<div id="login_page" style="width: 700px; height: 310px; padding:20px 20px;">
		<fieldset style="float: left; padding:20px; width: 310px;">
		<h1><?php echo __('Welcome.', true); ?></h1>
		<h3><?php echo __('Please register or login to access this page.', true); ?></h3>
		<?php 
			if(defined('__APP_DEFAULT_USER_REGISTRATION_ROLE_ID')) { 
				echo $form->create('User', array('type' => 'file', 'id' => 'register_form', 'action' => 'register'));
				echo $form->input('Contact.id', array('type' => 'hidden')); 
				
				if (!empty($this->params['named']['user'])) {
					echo $form->input('User.id', array('type' => 'hidden', 'value' => $this->params['named']['user']));
				} else {
					if(defined('__APP_DEFAULT_USER_REGISTRATION_CONTACT_TYPE')) { 
						echo $form->input('User.contact_type', array('type' => 'hidden', 'value' => __APP_DEFAULT_USER_REGISTRATION_CONTACT_TYPE));
					} else {
						echo $form->input('User.contact_type', array('type' => 'hidden', 'value' => 'person'));
					}
					if(defined('__APP_DEFAULT_USER_REGISTRATION_ROLE_ID')) {
						echo $form->input('User.user_role_id', array('type' => 'hidden', 'value' => __APP_DEFAULT_USER_REGISTRATION_ROLE_ID));
					} else {
						echo $form->input('User.user_role_id');
					}
		?>
					<label> <b>EMAIL OR USERNAME :</b> </label>
				<?php 			
					echo $form->input('User.username', array('label' => false, 'size' => 40, 'class' => 'requiredFancyBoxField'));
				?>
					<div id="UserUsernameError" style="display: none;"><font color="red"> Username Is Required. </font></div>
					<label> <b>PASSWORD :</b> </label>
				<?php 
					echo $form->input('User.password', array('label' => false, 'size' => 40, 'class' => 'requiredFancyBoxField'));
				?>
					<div id="UserPasswordError" style="display: none;"><font color="red">  Password Is Required. </font></div>
					<label> <b>CONFIRM PASSWORD :</b> </label>
				<?php 	
					echo $form->input('User.confirm_password', array('type' => 'password', 'label' => false, 'size' => 40, 'class' => 'requiredFancyBoxField'));
				?>
					<div id="UserConfirmPasswordError" style="display: none;"><font color="red"> Confirm Password Is Required. </font></div>
				<?php 	
					echo $form->submit('Submit', array('id'=>'register_submit'));
				} // end named user if
				echo $form->end(); 
			} else {
				__('__APP_DEFAULT_USER_REGISTRATION_ROLE_ID must be defined for public user registrations to work.');
			}
		?>
		</fieldset>
		<fieldset style="background-color: #E5E5E5; width:310 float:right; padding:20px 20px 70px ">
			<h2><?php echo __('Already Registered?', true); ?></h1>
			<h3><?php echo __('Please login here.', true); ?></h3>
			<?php
		    	echo $form->create('User', array('id' => 'login_form', 'action' => 'login'));
		    ?>
			    <label> <b>EMAIL OR USERNAME :</b> </label>
		    <?php 	
		    	echo $form->input('username', array('label' => false, 'size' => 30));
		    ?>
			    <label> <b>PASSWORD :</b> </label>
		    <?php 	
		    	echo $form->input('password', array('label' => false, 'size' => 30));
		    	echo $html->tag('span', '', array('id' => 'mesg','', 'style' => 'color:red;'));
		    	echo $form->submit('Submit', array('id'=>'login_form_submit', 'div' => array('style' => 'float:right;')));
		    	echo $form->end();
		    ?>
		</fieldset>
	</div>
</div>
<script>
$().ready(function() {

	// Creating custom :internal selector
	$.expr[':'].internal = function(obj){
	    return !obj.href.match(/^mailto\:/)
	            && (obj.hostname == location.hostname);
	};

	$("a:internal").click(function (e) {
		url = $(this).attr('href');

		// if '#' or 'fancy box' dont show this
		if ($(this).attr('id') == 'loginss' || url == '#') {
			return true;
		}
		
		$.ajax({
	        type: "POST",
			url: url,
	        dataType: 'html',
	        async: false,
	        success:function(data){
				return true;
	       	},
	        error:  function(){
		    	$('#loginss').fancybox().trigger('click');
		    	e.preventDefault();
	        },
	    });
		
	});
	
});
</script>
<?php }?>
