<div class="ui-widget">
  <label for="userSearchAC"><h6>Find Other Users</h6><p>enter email or username</p></label>
  <input id="userSearchAC" />
</div>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="/js/jquery-ui/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript">
	$(function() {
	    var url = '<?php echo $this->Html->url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'searchUsers')); ?>'+'.json';
	    var userurl = '<?php echo $this->Html->url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view')); ?>';
	    $( "#userSearchAC" ).autocomplete({
	      source: function( request, response ) {
	        $.get(url , { search: $('#userSearchAC').val() })
				.done(function(data) {
					response( $.map( data.users, function( item ) {
			              return {
			                label: item.User.username,
			                value: item.User.id
			              }
			            }));
				});
	          },
	      minLength: 2,
	      select: function( event, ui ) {
	      	console.log(ui);
	      	window.location = userurl+'/'+ui.item.value;
	      },
	      open: function() {
	        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
	      },
	      close: function() {
	        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
	      }
	    });
	    
  	});
</script>
