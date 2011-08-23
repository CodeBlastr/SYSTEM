<?php 
	echo $this->Html->script('/galleries/js/fancybox/jquery.mousewheel-3.0.4.pack'); 
	echo $this->Html->script('/galleries/js/fancybox/jquery.fancybox-1.3.4.pack');	
	echo $this->Html->css('/galleries/css/fancybox/jquery.fancybox-1.3.4');	

	$auth_user_id = $this->Session->read('Auth.User.id');?>

<?php if (!isset($auth_user_id)) {?>
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
</script>
<a href ="#login_form" id ="loginss"></a>
<div style="display:none">
	<?php
    	echo $form->create('User', array('id' => 'login_form', 'action' => 'login'));
    	echo $form->input('username');
    	echo $form->input('password', array('label' => 'Password '));
    	echo $html->tag('span', '', array('id' => 'mesg','', 'style' => 'color:red;'));
    	echo $form->submit('Login', array('id'=>'login_form_submit'));
    	 echo $form->end();
	?>
</div>

<script>
$().ready(function() {

	$("a").click(function (e) {
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
