<?php // $requestUrl = strpos($this->request->url, '/') === 0 ? $this->request->url : '/'.$this->request->url; 
debug('header');
$id = !empty($id) ? $id : 'headerNavFloManagr'; 
$showEditMode = !empty($showEditMode) ? true : false;
$showContext = !empty($showContext) ? true : false; ?>
<div class="navbar navbar-inverse navbar-fixed-bottom floManagrNav" id="<?php echo $id; ?>">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".floManagrNav .nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <ul class="nav">
            	<li class="dropdown">
            		<a class="brand dropdown-toggle" data-toggle="dropdown" href="#">buildrr<b class="caret"></b></a>
            		<?php echo !empty($showContext) ? $this->Element('context_menu', array('before' => __('<li>%s</li><li>%s</li><li class="divider"></li>', $this->Html->link('Dashboard', '/admin/', array('title' => 'Admin Dashboard')), $this->Html->link('View Site', '/')))) : null; ?>   
            	</li>
            </ul>
            
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="nav-mode"><?php echo $this->Html->link('Content', '/admin/#tagPages+tagMedia+tagDiscussion+tagElements', array('title' => 'Pages, Modules, Media, Categories, Tags, Enumerations', 'onclick' => 'window.location.replace(this.href);window.location.reload(true)')); // takes extra js, because of the hash tags ?></li>
                    <li class="nav-mode"><?php echo $this->Html->link('Contacts', '/admin/contacts/contacts/dashboard', array('title' => 'Leads, Opportunities')); ?></li>
    				<?php if (in_array('Transactions', CakePlugin::loaded())) { ?><li class="nav-mode"><?php echo $this->Html->link('Ecommerce', array('admin' => true, 'plugin' => 'products', 'controller' => 'products', 'action' => 'dashboard'), array('title' => 'Catalogs, Orders', 'id' => 'navProducts')); ?></li><?php } ?>
   					<?php if (in_array('Invoices', CakePlugin::loaded())) { ?><li class="nav-mode"><?php echo $this->Html->link('Billing', array('admin' => true, 'plugin' => 'invoices', 'controller' => 'invoices', 'action' => 'dashboard'), array('title' => 'Estimates, Invoices', 'id' => 'navBilling')); ?></li><?php } ?>
    				<?php if (in_array('Projects', CakePlugin::loaded())) { ?><li class="nav-mode"><?php echo $this->Html->link('Projects', array('admin' => true, 'plugin' => 'projects', 'controller' => 'projects', 'action' => 'dashboard'), array('title' => 'Projects, Tasks & Timesheets', 'onclick' => 'window.location.replace(this.href);window.location.reload(true)')); ?></li><?php } ?>
    				<li class="nav-mode"><?php echo $this->Html->link('Users', array('plugin' => 'users', 'controller' => 'users', 'action' => 'dashboard'), array('title' => 'Social, Groups, Members, Messages', 'id' => 'navUsers')); ?></li>
                    <li class="edit-mode"><?php unset($templates[$templateId]); echo $this->Form->create('Webpage', array('url' => '/admin/webpages/webpages/save/', 'class' => 'form-inline')) . $this->Form->input('url', array('type' => 'hidden', 'value' => serialize($this->request->params))) . $this->Form->input('Webpage.type', array('type' => 'hidden', 'value' => 'template')) . $this->Form->input('Webpage.template_id', array('type' => 'hidden', 'value' => $templateId)) . $this->Form->input('Webpage.id', array('type' => 'select', 'label' => false, 'div' => false, 'empty' => '-- Change Page Template --', 'options' => $templates)) . $this->Form->end(array('label' => 'Save', 'class' => 'btn btn-small')); ?></li>
                    <li class="edit-mode"><?php $viewFile = !empty($_view) && $_view != $this->request->action ? $_view : 0; echo $this->Html->link(__('Html Editor'), array('plugin' => 'webpages', 'controller' => 'file', 'action' => 'edit', $this->request->plugin, $this->request->controller, $this->request->action, implode('/', $this->request->params['pass']), 'view' => $viewFile)); ?></li>
      			</ul>
                
                <ul class="nav pull-right">
                    <li><a href="/users/users/my"><?php echo $this->Session->read('Auth.User.username'); ?></a></li>
                    <li><a href="/users/users/logout" >logout</a></li>
                    <li class="span1 last">
                        <label class="toggle well header-toggle">
                        <input type="checkbox" id="toggleMode">
                        <p><span><i class="icon-off" title="Navigation"></i></span><span><i class="icon-eye-open" title="Design"></i></span></p>
                        <a class="btn btn-mini slide-button"></a>
                        </label>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function() {
    $('.edit-mode').hide();
    toggleMode();
    $('#toggleMode').change(function() {
        toggleMode();
    });
    function toggleMode() {
        if ($('#toggleMode').is(':checked')) {
            $('.nav-mode').fadeOut('slow', function() {
                $('.edit-mode').fadeIn('slow');
            });
        } else {
            $('.edit-mode').fadeOut('slow', function() {
                $('.nav-mode').fadeIn('slow');
            });
        }
    }
});
</script>
