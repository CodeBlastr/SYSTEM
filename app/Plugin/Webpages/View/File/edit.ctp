<div class="webpages file">
    <p>Select a theme: 
        <select onchange="selectTheme()" id=select>
            <option selected>default</option>
            <option>ambiance</option>
            <option>blackboard</option>
            <option>cobalt</option>
            <option>eclipse</option>
            <option>elegant</option>
            <option>erlang-dark</option>
            <option>lesser-dark</option>
            <option selected="selected">monokai</option>
            <option>neat</option>
            <option>night</option>
            <option>rubyblue</option>
            <option>solarized dark</option>
            <option>solarized light</option>
            <option>twilight</option>
            <option>vibrant-ink</option>
            <option>xq-dark</option>
        </select>
    </p>
    <?php
    echo $this->Form->create('ViewFile');
    echo $this->Form->input('ViewFile.contents', array('type' => 'textarea', 'label' => false, 'value' => $contents, 'style' => 'display: none;'));
    echo $this->Form->submit('Save', array('label' => false, 'id' => 'saveAndGo', 'after' => __(' %s %s ', $this->Form->submit('Save & Continue', array('type' => 'submit', 'div' => false, 'label' => false)), $this->Html->link(__('Cancel Edits'), $saveRedirect, array('class' => 'btn', 'rel' => 'tooltip', 'title' => __('Only cancels changes since last save.'))))));
    echo $this->Form->end(); ?>
    <div id="editor"></div>
</div>

<?php
echo $this->Html->script('ckeditor/plugins/codemirror/js/codemirror');
echo $this->Html->css('/js/ckeditor/plugins/codemirror/css/codemirror');
echo $this->Html->css('/js/ckeditor/plugins/codemirror/theme/neat');
echo $this->Html->css('/js/ckeditor/plugins/codemirror/theme/elegant');
echo $this->Html->css('/js/ckeditor/plugins/codemirror/theme/monokai');
echo $this->Html->css('/js/ckeditor/plugins/codemirror/theme/erlang-dark');
echo $this->Html->css('/js/ckeditor/plugins/codemirror/theme/night');
echo $this->Html->css('/js/ckeditor/plugins/codemirror/theme/cobalt');
echo $this->Html->css('/js/ckeditor/plugins/codemirror/theme/eclipse');
echo $this->Html->css('/js/ckeditor/plugins/codemirror/theme/rubyblue');
echo $this->Html->css('/js/ckeditor/plugins/codemirror/theme/lesser-dark');
echo $this->Html->css('/js/ckeditor/plugins/codemirror/theme/xq-dark');
echo $this->Html->css('/js/ckeditor/plugins/codemirror/theme/ambiance');
echo $this->Html->css('/js/ckeditor/plugins/codemirror/theme/blackboard');
echo $this->Html->css('/js/ckeditor/plugins/codemirror/theme/vibrant-ink');
echo $this->Html->css('/js/ckeditor/plugins/codemirror/theme/solarized');
echo $this->Html->css('/js/ckeditor/plugins/codemirror/theme/twilight'); 
echo $this->Html->script('ckeditor/plugins/codemirror/js/javascript'); ?>

<script type="text/javascript">
    // code mirror config
    var editor = CodeMirror.fromTextArea(document.getElementById('ViewFileContents'), {
        mode:  "javascript",
        lineNumbers : true,
        indentUnit: 4,
        lineWrapping: true
    });
    
    // theme chooser 
    var input = document.getElementById("select");
    function selectTheme() {
        var theme = input.options[input.selectedIndex].innerHTML;
        editor.setOption("theme", theme);
    }
    selectTheme();

    // save vs save & continue
    $('#saveAndGo').click(function(e) {
        e.preventDefault();
        $('#ViewFileEditForm').prepend('<input type="hidden" name="data[Override][redirect]" value="<?php echo $saveRedirect; ?>" />');
        $('#ViewFileEditForm').submit();
    });

    // keyboard short cut for saving
    var isCtrl = false;
    document.onkeyup=function(e){
        if(e.keyCode == 17) isCtrl=false;
    }

    document.onkeydown=function(e) {
        console.log(e.keyCode);
        if(e.keyCode == 17 || e.keyCode == 224) isCtrl = true;
        console.log(e.keyCode);
        if(e.keyCode == 83 && isCtrl == true) {
            //run code for CTRL+S -- ie, save!
            $('#ViewFileEditForm').submit();
            return false;
        }
    }  
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
</style>


<?php
$viewFile = !empty($this->request->params['named']['view']) ? $this->request->params['named']['view'] : 0;
$this->set('context_menu', array('menus' => array(
    array(
		'heading' => 'Customization',
		'items' => array(			 
             $this->Html->link(__('Reset to Default'), array('plugin' => 'webpages', 'controller' => 'file', 'action' => 'reset', implode('/', $this->request->params['pass']), 'view' => $viewFile), array('class' => 'btn-danger'), 'Are you sure? (cannot be undone)'),
			 )
		)
	))); ?>