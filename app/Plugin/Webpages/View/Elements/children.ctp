<?php
foreach ($webpage['Child'] as $child) {
	echo __('<div class="indexRow"><div class="indexCell"><div class="indexCell titleCell"><h3> %s </h3></div><div class="indexCell descriptionCell"> <p>%s</p> </div></div></div>', $this->Html->link($child['name'], array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'view', $child['id'])), strip_tags($child['content']));
}

