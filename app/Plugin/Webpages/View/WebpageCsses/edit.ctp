<div class="webpageCsses form">
	<fieldset>
		<?php echo $this->Form->create('WebpageCss', array('class'=> 'form-inline'));?>
		<div class="row-fluid">
			<?php echo $this->Form->input('WebpageCss.id'); ?>
			<?php echo $this->Form->input('WebpageCss.webpage_id', array('class' => 'input-small', 'label' => 'Template <a href="#" rel="tooltip" title="If blank then this css file will load with all templates"><i class="icon-info-sign"></i></a>', 'empty' => true)); ?>
			<?php echo $this->Form->input('WebpageCss.type', array('class' => 'input-small')); ?>
			<?php echo $this->Form->input('WebpageCss.name', array('class' => 'input-small', 'label' => 'File Name')); ?>
			<?php echo $this->Form->input('WebpageCss.is_requested', array('label' => 'Load manually? <a href="#" rel="tooltip" title="Advanced users may want to put css files into the template explicitly, and not have them loaded dynamically."><i class="icon-info-sign"></i></a>')); ?>
		</div>
		<div class="row-fluid block">
			<?php echo $this->Form->input('content', array('label' => false)); ?>
		</div>
		<?php echo $this->Form->end(__('Edit'));?>
	</fieldset>
</div>


<?php
// CodeMirror !
echo $this->Html->script('ckeditor/plugins/codemirror/js/codemirror.min');
echo $this->Html->script('ckeditor/plugins/codemirror/js/mode/matchbrackets');
echo $this->Html->script('ckeditor/plugins/codemirror/js/mode/htmlmixed');
echo $this->Html->script('ckeditor/plugins/codemirror/js/mode/xml');
echo $this->Html->script('ckeditor/plugins/codemirror/js/mode/javascript');
echo $this->Html->script('ckeditor/plugins/codemirror/js/mode/css');
echo $this->Html->script('ckeditor/plugins/codemirror/js/mode/clike');
echo $this->Html->script('ckeditor/plugins/codemirror/js/mode/php');
echo $this->Html->css('/js/ckeditor/plugins/codemirror/css/codemirror.min');
?>
<script type="text/javascript">
    // code mirror config
    var warn_on_unload = true;
    var editor = CodeMirror.fromTextArea(document.getElementById('WebpageCssContent'), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "css",
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift"
    });

    $('input[type=submit], a.btn-danger').click(function(e) {
        warn_on_unload = false;
    });

    // keyboard short cut for saving
    var isCtrl = false;
    document.onkeyup=function(e){
        if(e.keyCode === 17) isCtrl=false;
    };

    document.onkeydown=function(e) {
        console.log(e.keyCode);
        if(e.keyCode === 17 || e.keyCode === 224) isCtrl = true;
        console.log(e.keyCode);
        if(e.keyCode === 83 && isCtrl === true) {
            //run code for CTRL+S -- ie, save!
            $('#ViewFileEditForm').submit(function() {
            	warn_on_unload = false;
            });
            return false;
        }
    };
    window.onbeforeunload = function() {
    	if (warn_on_unload === true) {
    		return "Are you sure you want to leave this page? (Any changes will be lost)";
    	}
	};
</script>

<style type="text/css">
    .CodeMirror {
        border: 1px solid #ccc;
        margin: 0 0 10px 0;
        border-radius: 0.4em;
        height: 1000px;
    }
    .CodeMirror-scroll {
        overflow-y: hidden;
        overflow-x: auto;
    }
    .CodeMirror-lines {
	    /*background: none repeat scroll 0 0 #EFEFEF;*/
	    cursor: text;
	    font-size: 1.1em;
	    text-shadow: 0 0 0 #FF0000, 1px 1px 0 #FFFFFF;
	    margin-left: 10px;
	}
	/* control line number placement */
	.CodeMirror-gutters {
    	box-shadow: 11px 0 21px #808080;
    }
	.CodeMirror-linenumber {
		padding: 0 3px 0 7px;
		margin-left: -8px;
	    padding: 0 3px 0 0;
	}
</style>

<script type="text/javascript">
$(function() {	
	if ($("#WebpageIsDefault").is(":checked")) {
		$("#WebpageTemplateUrls").parent().hide();
	}

	$("#WebpageIsDefault").change(function() {
		if ($(this).is(":checked")) {
			$("#WebpageTemplateUrls").parent().hide();
		} else {
			$("#WebpageTemplateUrls").parent().show();
		}
	});
});
</script>


<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpage Csses',
		'items' => array(
			$this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('WebpageCss.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('WebpageCss.id'))),
			$this->Html->link(__('List Webpage Csses', true), array('action' => 'index')),
			)
		),
	))); ?>