<div class="accordion">
  <ul>
    <li data-role="list-divider"> <a href="#"><span>Design</span></a></li>
  </ul>
  <ul>
    <li><?php echo $this->Html->link('Site Template', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'type' => 'template')); ?></li>
    <li><?php echo $this->Html->link('Global Boxes', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'type' => 'element')); ?></li>
    <li><?php echo $this->Html->link('Css Styles', array('plugin' => 'webpages', 'controller' => 'webpage_csses', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Javascript', array('plugin' => 'webpages', 'controller' => 'webpage_jses', 'action' => 'index')); ?></li>
  </ul>
</div>