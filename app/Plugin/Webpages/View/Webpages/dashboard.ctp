<div class="dashboard masonry">
    
    <div class="dashboardBox">
		<ul>
			<li><?php echo $this->Html->link('Webpages', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'type' => 'page_content')); ?></li>
        </ul>
    </div>
    
    <div class="dashboardBox">
		<ul>
			<li><?php echo $this->Html->link('Image Manager', array('plugin' => 'media', 'controller' => 'media', 'action' => 'images')); ?></li>
            <li><?php echo $this->Html->link('Document Manager', array('plugin' => 'media', 'controller' => 'media', 'action' => 'files')); ?></li>
        </ul>
    </div>
    
    <div class="dashboardBox">
		<ul>
			<li><?php echo $this->Html->link('Blogs', array('plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link('Comments', array('plugin' => 'comments', 'controller' => 'comments', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link('Ratings', array('plugin' => 'ratings', 'controller' => 'ratings', 'action' => 'index')); ?></li>
        </ul>
    </div>
    
    <div class="dashboardBox">
		<ul>
			<li><?php echo $this->Html->link('Invites', array('plugin' => 'invite', 'controller' => 'invites', 'action' => 'invitation')); ?></li>
        </ul>
    </div>
    
    <div class="dashboardBox">
		<ul>
            <li><?php echo $this->Html->link('Galleries', array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link('Faqs', array('plugin' => 'faqs', 'controller' => 'faqs', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link('Maps', array('plugin' => 'maps', 'controller' => 'maps', 'action' => 'index')); ?></li>
            <li><?php echo $this->Html->link('Wikis', array('plugin' => 'wikis', 'controller' => 'wikis', 'action' => 'index')); ?></li>
        </ul>
    </div>
    
    <div class="dashboardBox">
		<ul>
            <li><?php echo $this->Html->link('Categories', array('plugin' => 'categories', 'controller' => 'categories', 'action' => 'index')); ?></li>
            <li><?php echo $this->Html->link('Tags', array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'index')); ?></li>
            <li><?php echo $this->Html->link('Enumerations', array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index')); ?></li>
        </ul>
    </div>
</div>