<?php 
if (isset($this->Paginator) && !empty($this->Paginator)) {
	echo '<div class="paging">';
	
	if ($this->Paginator->counter('{:pages}') > 1) {
		echo __('<p>%s</p>', $this->Paginator->counter('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}.')); 
		echo __('<p>%s %s %s</p>', $this->Paginator->prev('Previous', array(), null, array('class'=>'disabled')), $this->Paginator->numbers(array('separator' => '')), $this->Paginator->next('Next', array(), null, array('class' => 'disabled')));
	} else {
		echo __('<p>%s</p>', $this->Paginator->counter('Showing {:current} records out of {:count} total.')); 
	}
	echo '</div>';
} 