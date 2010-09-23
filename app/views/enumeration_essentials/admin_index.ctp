<div>
	<?php
	echo $paginator->prev();
	echo $paginator->numbers();
	echo $paginator->next();
	?>
	<div style='text-align:right;'><b>Type Filter:</b> | <?php  echo $paginator->link('ALL') ?> |
		<?php
		foreach(range('A','Z') as $letter) {
			echo ' ' . $paginator->link($letter,array('filter'=>$letter)) . ' |';
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
		<?php foreach($this->data as $enumerationEssential) { ?>
		<tr>
			<td><?php echo $enumerationEssential['EnumerationEssential']['type'] ?></td>
			<td><?php echo $enumerationEssential['EnumerationEssential']['name'] ?></td>
			<td>
				<a class='arrow-up-graphic' href='/admin/enumeration_essentials/changeOrder/<?php echo $enumerationEssential['EnumerationEssential']['id'] ?>/increase' title='Increase'>Increase</a>
				<a class='arrow-down-graphic' href='/admin/enumeration_essentials/changeOrder/<?php echo $enumerationEssential['EnumerationEssential']['id'] ?>/decrease' title='Decrease'>Decrease</a>
			</td>
			<td>
				<a class='sym-button' href='/admin/enumeration_essentials/edit/<?php echo $enumerationEssential['EnumerationEssential']['id'] ?>'>Edit</a>
				<a class='sym-button' href='/admin/enumeration_essentials/delete/<?php echo $enumerationEssential['EnumerationEssential']['id'] ?>' onclick='return confirmDelete("<?php echo $enumerationEssential['EnumerationEssential']['name'] ?>")' >Delete</a>
			</td>
		</tr>
		<?php } ?>
	</table>
	<?php
	echo $paginator->prev();
	echo $paginator->numbers();
	echo $paginator->next();
	?>
	<div style='text-align:right;margin-top:4px;'><a class='sym-button' href='/admin/<?php echo $this->params['controller'] ?>/add'>Add Enumeration Essential</a></div>
</div>
<script type='text/javascript'>
function confirmDelete(string) {
	return confirm('Are you sure you want to delete "' + string + '"');
}
</script>