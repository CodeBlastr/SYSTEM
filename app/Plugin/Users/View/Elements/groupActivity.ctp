<?php

$userGroup = $this->requestAction("/users/userGroups/groupActivity/$id");
$output = '';

if ( !empty($userGroup['UserGroupWallPost']) ) {
	//debug($userGroup);break;
	foreach ( $userGroup['UserGroupWallPost'] as $message ) {

		$output .= $this->Html->tag('div',
				$this->Html->tag('div', $message['Creator']['full_name'] . ' <b class="muted">wrote:</b>', array('class' => 'inboxElement_sender'))
				. $this->Html->tag('div', $message['post'], array('class' => 'inboxElement_body'))
			, array('class' => 'inboxElement_message')
		);

		if ( !empty($message['Comment']) ) {
			foreach ( $message['Comment'] as $child ) {
				$output .= $this->Html->tag('div',
					$this->Html->tag('div', 'From: ' . $child['Creator']['full_name'], array('class' => 'inboxElement_sender'))
					. $this->Html->tag('div', $child['post'], array('class' => 'inboxElement_body'))
					, array('class' => 'inboxElement_childMessage')
				);
			}
		}

	}
} else {
	$output .= '<i>no new activity</i>';
}

echo $this->Html->tag('div', $output, array('id' => 'userGroupActivityElement'));
