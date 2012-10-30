<?php echo $this->Html->script('plugins/jquery.masonry.min', array('inline' => false)); ?>
  
  
  <div class="masonry contacts dashboard">
        <div class="masonryBox tagLeads">
            <h3><i class="icon-th-large"></i> Needs Your Attention Fast </h3>
            <?php 
			if (!empty($leads)) {
				echo '<p>The latest incoming contacts, that have not been claimed yet.<ul>';
				foreach ($leads as $lead) {
					echo '<li>' . $this->Html->link('Assign', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'edit', $lead['Contact']['id']), array('class' => 'btn btn-mini btn-primary')) . ' ' . $this->Html->link($lead['Contact']['name'], array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'view', $lead['Contact']['id'])) . ' ' . date('M d, Y', strtotime($lead['Contact']['created'])) . '</li>';
				}
				echo '</ul>';
			} ?>
        </div>
  </div>