<div>
<?php
/*echo $this->Html->link($transactionItem['name'],
	'/products/products/view/'.$transactionItem['foreign_key'],
	array('style' => 'text-decoration: underline;'),
	'Are you sure you want to leave this page?'
	);  */
    echo $transactionItem['name'];
?>
</div>
<?php
/* echo $this->element('thumb', array(
	    'model' => 'Product',
	    'foreignKey' => $transactionItem['foreign_key'],
	    'thumbSize' => 'small',
	    'thumbWidth' => 75,
	    'thumbHeight' => 75,
	    'thumbLink' => '/products/products/view/'.$transactionItem['foreign_key']
	    ),
	array('plugin' => 'galleries')
	);  */

//$minQty = !empty($product['Product']['cart_min']) ? $product['Product']['cart_min'] : 0;
//$maxQty = !empty($product['Product']['cart_max']) ? $product['Product']['cart_max'] : null;

echo $this->Form->hidden("TransactionItem.{$i}.quantity", array(
    'label' => 'Qty.',
	'class' => 'TransactionItemCartQty',
    'div' => array('style' => 'display:inline-block'),
    'value' => 1,
    'min' => $minQty, 'max' => $maxQty,
    'size' => 1,
    'after' => __(' %s', $this->Html->link('x', array('plugin' => 'transactions', 'controller' => 'transaction_items', 'action' => 'delete', $transactionItem['id']), array('title' => 'Remove from cart')))
    ));

$transactionItemCartPrice = $transactionItem['price'] * 1; 
?>

<div class="TransactionItemCartPrice" style="margin-top: -43px !important;">
    $<span class="floatPrice"><?php echo number_format($transactionItemCartPrice, 2); ?></span>
	<span class="priceOfOne"><?php echo number_format($transactionItem['price'], 2) ?></span>
</div>
