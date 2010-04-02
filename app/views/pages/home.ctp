<h2>No homepage configured.</h2>
<ul>
	<li><?php echo $html->link(__('login', true), array('controller' => 'users', 'action' => 'login', 'admin' => 1)); ?></li>
	<li><?php echo $html->link(__('register', true), array('controller' => 'users', 'action' => 'add', 'admin' => 1)); ?></li>
</ul>

<p>&nbsp;</p>
<p><strong>File: </strong>/app/views/pages/home.ctp</p>