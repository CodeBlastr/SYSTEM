<div>
	<?php
	echo $this->Paginator->prev();
	echo $this->Paginator->numbers();
	echo $this->Paginator->next();
	?>
	<div style='text-align:right;'><b>Type Filter:</b> | <?php  echo $this->Paginator->link('ALL') ?> |
		<?php
		foreach(range('A','Z') as $letter) {
			echo ' ' . $this->Paginator->link($letter,array('filter'=>$letter)) . ' |';
		}
		?>
	</div>
	<table>
		<tr>
			<th>Type</th>
			<th>Name</th>
			<th>Order</th>
			<th>Actions</th>
		</tr>
		<?php foreach($this->data as $enumeration) { ?>
		<tr>
			<td><?php echo $enumeration['Enumeration']['type'] ?></td>
			<td><?php echo $enumeration['Enumeration']['name'] ?></td>
			<td>
				<a class='arrow-up-graphic' href='/admin/enumerations/changeOrder/<?php echo $enumeration['Enumeration']['id'] ?>/increase' title='Increase'>Increase</a>
				<a class='arrow-down-graphic' href='/admin/enumerations/changeOrder/<?php echo $enumeration['Enumeration']['id'] ?>/decrease' title='Decrease'>Decrease</a>
			</td>
			<td>
				<a class='sym-button' href='/admin/enumerations/edit/<?php echo $enumeration['Enumeration']['id'] ?>'>Edit</a>
				<a class='sym-button' href='/admin/enumerations/delete/<?php echo $enumeration['Enumeration']['id'] ?>' onclick='return confirmDelete("<?php echo $enumeration['Enumeration']['name'] ?>")' >Delete</a>
			</td>
		</tr>
		<?php } ?>
	</table>
	<?php
	echo $this->Paginator->prev();
	echo $this->Paginator->numbers();
	echo $this->Paginator->next();
	?>
	<div style='text-align:right;margin-top:4px;'><a class='sym-button' href='/admin/<?php echo $this->params['controller'] ?>/add'>Add <?php echo ucwords(Inflector::singularize($this->params['controller'])); ?></a></div>
</div>
<script type='text/javascript'>
function confirmDelete(string) {
	return confirm('Are you sure you want to delete "' + string + '"');
}
</script>