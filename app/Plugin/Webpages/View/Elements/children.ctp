<?php
foreach ($webpage['Child'] as $child) {

	$isRestrictable = empty($child['user_roles']) ? '' : 'restricted ' . preg_replace("/[^[:alnum:]]/", '', $child['user_roles']);

	echo __(
			'<div class="indexRow '.$isRestrictable.'"><div class="indexCell"><div class="indexCell titleCell"><h3> %s </h3></div><div class="indexCell descriptionCell"> <p>%s</p> </div></div></div>',
			$this->Html->link(
					$child['name'],
					array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'view', $child['id'])
			),
			$this->Text->truncate(strip_tags($child['content']))
	);

}
