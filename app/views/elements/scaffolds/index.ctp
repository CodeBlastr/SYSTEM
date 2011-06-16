<div class="projects index">
  <div class="drop-holder pageDrop"> <img src="/img/admin/btn-down.png" />
    <ul class="drop">
      <li><?php echo __('Sort by');?></li>
      <li><?php echo $paginator->sort('star');?></li>
      <li><?php echo $paginator->sort('name');?></li>
      <li><?php echo $paginator->sort('quick_note');?></li>
      <li><?php echo $paginator->sort('Company', 'Contact.ContactCompany.name');?></li>
      <li><?php echo $paginator->sort('modified');?></li>
    </ul>
  </div>
  <div class="indexContainer">
    <?php
$i = 0;
foreach ($datas as $data):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' altrow';
	}
?>
    <div class="indexRow <?php echo $class;?>" id="row<?php echo $data['Project']['id']; ?>">
      <div class="indexCell image"> <span><img src="/img/admin/img01.jpg" alt="image description" /></span>
        <div class="drop-holder indexDrop"> <span><img src="/img/admin/btn-down.png" /></span>
          <ul class="drop">
            <li><?php echo $html->link('View', array('controller' => 'projects', 'action' => 'view', 'admin' => 1, $data['Project']['id'])); ?></li>
            <li><?php echo $html->link('Delete', array('controller' => 'projects', 'action' => 'delete', 'admin' => 1, $data['Project']['id']), array(), 'Are you sure you want to delete "'.$data['Project']['id'].'"'); ?></li>
          </ul>
        </div>
      </div>
      <div class="indexCell">
        <div class="recordData">
          <h3>
            <?php if (!empty($data['Contact']['ContactCompany']['id'])) : echo $html->link(__($data['Contact']['ContactCompany']['name'], true), array('plugin' => 'contacts', 'controller' => 'contact_companies', 'action' => 'view', $data['Contact']['ContactCompany']['id'])); endif; ?>
            <?php echo $html->link(__($data['Project']['name'], true), array('action' => 'view', $data['Project']['id'])); ?></h3>
        </div>
      </div>
      <div class="indexCell">
        <ul class="metaData">
          <li><span class="metaDataLabel"> Star : </span><span class="metaDataDetail edit" name="star" id="<?php __($data['Project']['id']); ?>"><?php echo $data['Project']['star']; ?></span></li>
          <li><span class="metaDataLabel"> Company : </span><span class="metaDataDetail">
            <?php if (!empty($data['Contact']['ContactCompany']['id'])) : echo $html->link(__($data['Contact']['ContactCompany']['name'], true), array('plugin' => 'contacts', 'controller' => 'contact_companies', 'action' => 'view', $data['Contact']['ContactCompany']['id'])); endif; ?>
            </span></li>
          <li><span class="metaDataLabel"> Modified : </span><span class="metaDataDetail"> <?php echo $time->timeAgoInWords($data['Project']['modified']); ?> </span></li>
          <li><span class="metaDataLabel"> Manager : </span><span class="metaDataDetail"> <?php echo $data['Manager']['username']; ?> </span></li>
        </ul>
      </div>
      <div class="indexCell">
        <div class="recordData">
          <!--div class="truncate"-->
          <span name="quicknote" class="edit" id="<?php __($data['Project']['id']); ?>"><?php echo $data['Project']['quick_note']; ?></span>
          <!--/div-->
        </div>
      </div>
    </div>
    <?php
  # used for ajax editing
  # needs to be here because it hsa to be before the forech ends
  $editFields[] =  array(
	'name' => 'quicknote',
	'tagId' => $data['Project']['id'],
	'plugin' => 'projects',
	'controller' => 'projects',
	'fieldId' => 'data[Project][id]',
	'fieldName' => 'data[Project][quick_note]',
	'type' => 'text'
	);
  $editFields[] =  array(
	'name' => 'star',
	'tagId' => $data['Project']['id'],
	'plugin' => 'projects',
	'controller' => 'projects',
	'fieldId' => 'data[Project][id]',
	'fieldName' => 'data[Project][star]',
	'type' => 'text'  
	);
endforeach;
?>
  </div>
</div>
<?php echo $this->Element('paging'); ?>
<?php echo $this->element('ajax_edit',  array('editFields' => $editFields)); ?>