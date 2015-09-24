<div class="row">
	<div class="col-sm-3">
		<h1>Bulk User Creation (CSV)</h1>
		<?php echo $this->Form->create('User', array('type' => 'file')); ?>
		<?php echo $this->Form->input('Import.csv', array('type' => 'file', 'label' => false)); ?>
		<?php echo $this->Form->input('User.notify', array('type' => 'checkbox', 'label' => 'Send users notification?')); ?>
		<?php echo $this->Form->end('Upload CSV'); ?>
	</div>
	<div class="col-sm-9">
		<h3>Notes About CSV Upload <small>(<?php echo $this->Html->link('Download Sample CSV File - Required Fields Only', array('action' => 'import.csv')); ?>)</small></h3>
		<ul>
			<li>Column names should be in the top line of the CSV file.</li>
			<li>Do not include an id, or password column. </li>
			<li>New Users will be emailed about their new account, and be asked to create a password.</li>
			<li>If full_name field is blank, the first_name and last_name field will auto generate it, and vice versa.</li>
			<li>Created and Modified dates will be auto generated if blank.</li>
			<li>Username will be the user's email address if username column does not exist.</li>
			<li>If the email address is already exists errors will happen. </li>
			</ul>
		<table>
			<thead>
				<tr>
					<th>Field Name</th>
					<th>Field Type</th>
					<th>Max Length</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($schema as $name => $detail) : ?>
					<?php if ($name !== 'id' && $name !== 'password') : // exclude some fields ?>
						<tr>
							<td><?php echo $name; ?> <?php echo $detail['null'] === false ? '<span class="text-danger">*</span>' : null; ?></td>
							<td><?php echo $detail['type']; ?></td>
							<td><?php echo $detail['type'] == 'datetime' ? 'YYYY-MM-DD HH:MM:SS' : $detail['length']; ?></td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<?php 
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Admin Dashboard'), '/admin'),
	$this->Html->link(__('User Dashboard'), '/admin/users/users/dashboard'),
	$page_title_for_layout,
)));
