<div class="webpages form">
	<?php echo $this->Form->create('Webpage');?>
	<fieldset>
	    <?php echo $this->Form->input('Webpage.id'); ?>
	    <?php echo $this->Form->input('Override.redirect', array('value' => '/admin/webpages/webpages/index/element/sort:modified/direction:desc', 'type' => 'hidden')); ?>
	    <?php echo $this->Form->hidden('Webpage.type', array('value' => 'element')); ?>
	    <?php echo $this->Form->input('Webpage.name', array('label' => 'Internal Element Name')); ?>
		<?php echo $this->Form->input('Webpage.content'); ?>
	</fieldset>
	<fieldset>
	    <legend class="toggleClick"><?php echo __('<span class="hoverTip" title="User role site privileges are used by default. Choose an option to restrict access to only the chosen group for this specific element.">Access Restrictions (optional)</span>');?></legend>
	    <?php echo $this->Form->input('RecordLevelAccess.UserRole', array('label' => 'User Roles', 'type' => 'select', 'multiple' => 'checkbox', 'options' => $userRoles)); ?>    
	</fieldset>
	<?php echo $this->Form->end('Save Element');?>
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
    var editor = CodeMirror.fromTextArea(document.getElementById('WebpageContent'), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "php",
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
        height: auto;
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
	.CodeMirror .form-group {
		margin-bottom: 0;
	}
</style>


<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Admin Dashboard'), '/admin'),
	$this->Html->link(__('All Elements'), array('action' => 'index', 'element')),
	'Element Builder'
)));
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			 $this->Html->link(__('List'), array('action' => 'index', 'element')),
			 $this->Html->link(__('Advanced Editor'), array('action' => 'add', 'element', '?' => array('advanced' => true))),
			 )
		)
	)));