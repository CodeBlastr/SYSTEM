<div class="contacts index">
<h2><?php __('Customer Relationship Manager');?></h2>

<h3><?php __('People');?></h3>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('ContactPerson.last_name');?></th>
	<th><?php echo $paginator->sort('contact_rating_id');?></th>
	<th><?php echo $paginator->sort('created');?></th>
</tr>
<?php
$i = 0;
foreach ($contacts as $contact):
	if ($contact['ContactPerson']['id']) :
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($contact['ContactPerson']['last_name'].', '.$contact['ContactPerson']['first_name'], array('controller' => 'contact_people', 'action' => 'view', $contact['ContactPerson']['id'])); ?>
		</td>
		<td>
			<?php echo $contact['ContactRating']['name']; $peopleRatings[] = $contact['ContactRating']['name']; ?>
		</td>
		<td>
			<?php echo $time->relativeTime($contact['Contact']['created']); ?>
		</td>
		<!--td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $contact['Contact']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $contact['Contact']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $contact['Contact']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contact['Contact']['id'])); ?>
		</td-->
	</tr>
<?php endif; endforeach; ?>
</table>


<h3><?php __('Companies');?></h3>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('ContactCompany.name');?></th>
	<th><?php echo $paginator->sort('contact_rating_id');?></th>
	<th><?php echo $paginator->sort('created');?></th>
</tr>
<?php
$i = 0;
foreach ($contacts as $contact):
	if ($contact['ContactCompany']['id']) :
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($contact['ContactCompany']['name'], array('controller' => 'contact_companies', 'action' => 'view', $contact['ContactCompany']['id'])); ?>
		</td>
		<td>
			<?php echo $contact['ContactRating']['name']; $companyRatings[] = $contact['ContactRating']['name'];  ?>
		</td>
		<td>
			<?php echo $time->relativeTime($contact['Contact']['created']); ?>
		</td>
		<!--td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $contact['Contact']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $contact['Contact']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $contact['Contact']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contact['Contact']['id'])); ?>
		</td-->
	</tr>
<?php endif; endforeach; ?>
</table>
</div>
<div class="paging">
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>


<?php
	#chart values
	$peopleRatingCounts = array_count_values($peopleRatings);
	$companyRatingCounts = array_count_values($companyRatings);
	$n = 0;
	foreach ($peopleRatingCounts as $key => $value) : 
		$peopleChart[$n]['Peep']['count'] = $value;
		$peopleChart[$n]['Peep']['name'] = $key;
		$n++;
	endforeach;
	$i = 0;
	foreach ($companyRatingCounts as $key => $value) : 
		$companyChart[$i]['Comp']['count'] = $value;
		$companyChart[$i]['Comp']['name'] = $key;
		$i++;
	endforeach;
	
	#print charts
    echo $flashChart->begin(array('prototype'=>true));  
	
	#chart one
	$flashChart->setTitle('People Ratings', '{color:#f1a334;font-size:25px;padding-bottom:20px;}');
    echo $flashChart->setData($peopleChart, '{n}.Peep.count', '{n}.Peep.name', 'peeps', 'dig'); 
	echo $flashChart->chart('pie', array(), 'peeps', 'dig');
    echo $flashChart->render(300, 300, 'dig');
	#chart two
	$flashChart->setTitle('Company Ratings', '{color:#f1a334;font-size:25px;padding-bottom:20px;}');
    echo $flashChart->setData($companyChart, '{n}.Comp.count', '{n}.Comp.name', 'comps'); 
	echo $flashChart->chart('pie', array(), 'comps');
    echo $flashChart->render(300, 300);
	
?> 

<?php 
// set the contextual menu items
// itemid, style, and item must be set item is what goes between the <li> tags the other two are css for the <li> tags
$menu->setValue(array($html->link(__('New Person', true), '/admin/contact_people/edit'), $html->link(__('New Company', true), '/admin/contact_companies/edit'))); 
?>