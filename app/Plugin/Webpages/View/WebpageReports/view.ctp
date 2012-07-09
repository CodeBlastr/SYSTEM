<?php  $type = is_array($type) ? implode(' , ', $type) : $type;?>
<h3><?php echo $type . '  ';?> Items For Manufacturer</h3>
<table><tr>
<?php 		foreach(range('A', 'Z') as $letter) {	
				echo '<td>';		
				if ( isset($alphabet) && $letter == $alphabet) {
					echo $letter;
				} else {
					 echo  $this->Html->link($letter, array('controller'=>'reports'
						, 'action'=>'view', $type, $letter));
				}
				echo '</td>';
}?>
<td><?php echo  $this->Html->link('Show All', array('controller'=>'reports'
						, 'action'=>'view', $type));?></td>
</tr></table>
<?php 
if (!isset($data) || empty($data)) {
	echo 'No report found';
} else {?>
<?php $direction = ucfirst(isset($this->request->params['named']['direction'])
		 ? ($this->request->params['named']['direction']): 'Asc');?>
Sort Order:<?php echo $this->Paginator->sort($direction, 'name');?>
<table>
<?php 
	foreach($data as $cibrand){
		$i = 0;
?>
<tr>
	<td><div class="th1">
		Manufacturer Name
	</div>
	</td>
	<td>
	<div class="th1"><?php echo $cibrand['CatalogItemBrand']['name'];?></div>
	</td>
</tr>
	

	<tr>
		<th><div class="th1">Item</div></th>
		<th><div class="th1">Qty</div></th>
		<th><div class="th1">Price</div></th>
		<th><div class="th1">Created</div></th>
	</tr>
	<?php
		$total = array();
		foreach($cibrand['CatalogItem'] as $ci) {
			$price = 0.0;
			$quantity = 0;
	?>
		<?php
		if (!empty($ci['OrderItem'] )) {
			foreach($ci['OrderItem'] as $oi) {
				$i++;
				$price += $oi['price'];
				$quantity += $oi['quantity'];
		?>
			<tr>
				<td><div class="th2"><?php echo $this->Html->link($oi['name'],
						array('plugin'=>'orders',
								'controller'=>'order_transactions',
							'action'=>'view', $oi['order_transaction_id'])); ?></div></td>
				<td><div class="th2"><?php echo $oi['quantity']; ?></div></td>
				<td><div class="th2"><?php echo $oi['price']; ?></div></td>
				<td><div class="th2"><?php echo $oi['created']; ?></div></td>
			</tr>
		<?php 
			}
			$total[$cibrand['CatalogItemBrand']['name']][] = array('price'=>$price, 'quantity' => $quantity);
			?>
			<tr><td>Total:</td><td><?php echo $quantity?></td><td><?php echo $price?></td></tr> 
		<?php }
		}
	}
	
	?>
</table>
<?php echo $this->element('paging')?>

<?php }?>