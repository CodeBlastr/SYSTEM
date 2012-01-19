<div class="index enumerations">
	<h2><?php echo $page_title_for_layout; ?></h2>
	<p><span class="label">Filter:</span> | <?php  echo $this->Html->link('ALL', array('controller' => 'enumerations', 'action' => 'index')) ?> |
	<?php
	foreach(range('A','Z') as $letter) {
		echo ' ' . $this->Html->link($letter, array('start:type' => $letter)) . ' |';
	}?>
	</p>
	<table>
		<tr>
			<th>Type</th>
			<th>Name</th>
			<th>Order</th>
			<th>Actions</th>
		</tr>
		<?php foreach($this->request->data as $enumeration) { ?>
		<tr>
			<td><?php echo $enumeration['Enumeration']['type'] ?></td>
			<td><?php echo $enumeration['Enumeration']['name'] ?></td>
			<td>
				<a class='arrow-up-graphic' href='/admin/enumerations/changeOrder/<?php echo $enumeration['Enumeration']['id'] ?>/increase' title='Increase'>Increase</a>
				<a class='arrow-down-graphic' href='/admin/enumerations/changeOrder/<?php echo $enumeration['Enumeration']['id'] ?>/decrease' title='Decrease'>Decrease</a>
			</td>
			<td>
            	<?php echo $this->Html->link('Edit', array('action' => 'edit', $enumeration['Enumeration']['id'])); ?>
				<a class='sym-button' href='/admin/enumerations/delete/<?php echo $enumeration['Enumeration']['id'] ?>' onclick='return confirmDelete("<?php echo $enumeration['Enumeration']['name'] ?>")' >Delete</a>
			</td>
		</tr>
		<?php } ?>
	</table>
</div>
<?php
echo $this->element('paging');
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Enumerations',
		'items' => array(
			$this->Html->link('Add', array('plugin' => null, 'controller' => 'enumerations', 'action' => 'add')),    
			)
		),
	))); ?>