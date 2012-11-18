<div class="webpages form">
	<?php echo $this->Form->create('Webpage');?>
    
	<fieldset>
    	<?php
		echo $this->Form->input('Webpage.type', array('type' => 'hidden', 'value' => 'content'));
		echo $this->Form->input('Webpage.name', array('label' => 'Internal Page Name'));
		echo $this->Form->input('Webpage.content', array('type' => 'richtext')); ?>
	</fieldset>
    
	<fieldset>
		<legend class="toggleClick"><?php echo __('Search Engine Optimization');?></legend>
    	<?php 
		echo $this->Form->input('Alias.name', array('label' => 'SEO Url (unique)'));
		echo $this->Form->input('Webpage.title', array('label' => 'SEO Title'));
		echo $this->Form->input('Webpage.keywords', array('label' => 'SEO Keywords'));
		echo $this->Form->input('Webpage.description', array('label' => 'SEO Description')); ?>
    </fieldset>
    
	<fieldset>
		<legend class="toggleClick"><?php echo __('<span class="hoverTip" title="User role site privileges are used by default. Choose an option to restrict access to only the chosen group for this specific page.">Access Restrictions (optional)</span>');?></legend>
    	<?php 
		echo $this->Form->input('RecordLevelAccess.UserRole', array('label' => 'User Roles', 'type' => 'select', 'multiple' => 'checkbox', 'options' => $userRoles)); ?>
    </fieldset>
    
	<?php echo $this->Form->end('Save Webpage');?>
</div>

<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			 $this->Html->link(__('List', true), array('action' => 'index')),									 
			 )
		)
	))); ?>

<style type="text/css">
    #permaLink {
        background: #fff7c9;
    }
</style>
<script type="text/javascript">

$(function() {
    var formId = '#WebpageEditForm';
    var permaLink = $('#permaLink').html();
    var aliasId = $("#AliasId");
    
    $('#permaLink, #permaLinkEdit').live('click', function() {
       permaLink = $('#permaLink').html();
       $('#permaLink').replaceWith('<div class="form-inline" id="aliasForm"><input type="text" value="' + permaLink + '" id="slugInput"> <a class="btn" id="saveSlug">Done</a> <a class="btn" id="cancelSlug">Cancel</a> <span id="saveOld"></span></div>');
       $('#permaLinkEdit').hide();
    });
    $('#slugInput').live('keyup', function () {
        $("#AliasName").val($(this).val());
        $("#saveOld").replaceWith('<a id="saveOldLink" class="btn btn-danger" rel="tooltip" title="Click here to keep the old url working, so that links pointing to the old page will not break.">Keep old url live?</a></small>');
        $("a[rel=tooltip]").tooltip();
    });
    $('#saveOldLink').live('click', function () {
        $(".tooltip").remove();
        $("#AliasId").remove();
        $("#saveOldLink").replaceWith('<a id="oldLinkSaved" class="btn btn-success" rel="tooltip" title="This means that old links pointing to the old url will still work. If this was a mistake, you will need to refresh the page before saving any changes.">Old url has been preserved! &nbsp;&nbsp; <button type="button" class="close" data-dismiss="alert">×</button></a></small>');
        $("a[rel=tooltip]").tooltip();
    });
    $('.close').live('click', function() {
        $(".tooltip").remove();
    });
    $('#saveSlug').live('click', function () {
        // check alias availability, append a number at the end if not available
        var newPermaLink = $('#slugInput').val();
        if (newPermaLink != permaLink) {
            $.getJSON('/aliases/count/' + newPermaLink + '.json', 
                function(data) {
                    // if there is a conflict append a number at the end of the alias
                    var conflict = false;
                    if (data.alias) {
                        conflict = true;
                    }
                    if (conflict) {
                        newPermaLink = newPermaLink + data.alias;
                    }
                    $("#aliasForm").replaceWith('<span id="permaLink">' + newPermaLink + '</span>'); // needed here instead of just the bottom because the update doesn't get past here for some reason
                    $("#AliasName").val(newPermaLink);
                    $('#permaLinkEdit').show();
                }
            );
        } else {
            $("#aliasForm").replaceWith('<span id="permaLink">' + newPermaLink + '</span>');
            $("#AliasName").val(newPermaLink);
            $('#permaLinkEdit').show();
        }
    });
    $('#cancelSlug').live('click', function () {
        $(formId).prepend(aliasId); // bring back the alias id in case it was removed with the #saveOldLink button
        $('#aliasForm').replaceWith('<span id="permaLink">' + permaLink + '</span>');
        $('#permaLinkEdit').show();
    });
});
</script>