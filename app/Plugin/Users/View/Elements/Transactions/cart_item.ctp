<div>
<?php
echo $this->Html->link($transactionItem['name'],
	'/users/users/view/'.$transactionItem['foreign_key'],
	array('style' => 'text-decoration: underline;'),
	'Are you sure you want to leave this page?'
	);
?>
</div>
<?php
echo $this->element('thumb', array(
	    'model' => 'User',
	    'foreignKey' => $transactionItem['foreign_key'],
	    'thumbSize' => 'small',
	    'thumbWidth' => 75,
	    'thumbHeight' => 75,
	    'thumbLink' => '/users/users/view/'.$transactionItem['foreign_key']
	    ),
	array('plugin' => 'galleries')
	);

echo $this->Form->hidden("TransactionItem.{$i}.quantity", array(
	'class' => 'TransactionItemCartQty',
    'value' => 1,
    ));

$transactionItemCartPrice = $transactionItem['price'] * $transactionItem['quantity'];
?>

<div class="TransactionItemCartPrice">
    $<span class="floatPrice"><?php echo number_format($transactionItemCartPrice, 2); ?></span>
	<span class="priceOfOne"><?php echo number_format($transactionItem['price'], 2) ?></span>
</div>
