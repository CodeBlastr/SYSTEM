<div class="accordion">
  <ul>
    <li> <a href="#" title="Users"><span>Users</span></a>
  </ul>
  <ul>
    <li><?php echo $this->Html->link('Users', array('plugin' => 'users', 'controller' => 'users', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('User Roles', array('plugin' => 'users', 'controller' => 'user_roles', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Groups', array('plugin' => 'users', 'controller' => 'user_groups', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Statuses', array('plugin' => 'users', 'controller' => 'user_statuses', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Walls', array('plugin' => 'users', 'controller' => 'user_walls', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Messages', array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'index')); ?></li>
  </ul>
</div>