<div id="helperText">
<?php if (!empty($_GET['e']) && $_GET['e'] == 'sent') { ?>

	<p>Thank you for the suggestion.</p>
    
<?php } else if ($this->params['plugin'] == 'users' && $this->params['controller'] == 'user_groups' && $this->params['action'] == 'admin_index') { ?>

	<p>Group users into departments and/or and group themselves for social networking. <a href="#" class="toggleClick" name="helperForm">Suggest Help Text Improvement</a></p>
    
<?php } else { ?>

  <p>No help text available for this page. <a href="#" class="toggleClick" name="helperForm">Please make a suggestion</a></p> 	
  
<?php }?>  
	<div style="display: none; margin: 1em 0 0 0;" id="helperForm">
		<form action="/js/ckeditor/email_process.php" method="post">
	    	<div class="inputs">
	     		<input type="hidden" name="subject" value="Zuha Helper Text Suggestion" />
		     	<input type="hidden" name="page" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
		      	<input type="hidden" name="sendto" value="admin@zuha.com" />
		      	<input type="hidden" name="redirectUrl" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
		      	<label for="suggestedHelpText">Your Suggestion</label>
		      	<textarea name="suggestedHelpText"></textarea>
		      	<input type="submit" name="submit" value="Submit" />
			</div>
	    </form>
	</div>
  	<a href="#" id="helpClose" title="Turns off help text for this browser through out the system."> Turn Off </a>
</div>