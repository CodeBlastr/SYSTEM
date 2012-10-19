<?php
/**
 * Transactions Checkout View
 *
 * Displays the checkout form for conducting transactions.
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.orders.views
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
?>

<div id="transactionsCheckout" class="transactions checkout form">
    <?php
    echo $this->Html->script('system/jquery.validate.min');
    echo $this->Form->create('Transaction', array('action' => 'checkout'));
    ?>

    <h2>
	<?php echo __('You are 30 seconds away from ordering...'); ?>
    </h2>

    <div id="orderTransactionForm" class="orderTransactionForm text-inputs">
	<h3><?php echo __('Please fill in your billing details'); ?></h3>

	<div id="transactionCartLeft">

	    <div id="orderTransactionAddress">
		<fieldset id="billingAddress">
		    <legend>
			<?php echo __('Billing Address'); ?>
		    </legend>
		    <?php
		    echo $this->Form->input('TransactionPayment.first_name', array('class' => 'required', 'div' => array('style' => 'display:inline-block')));
		    echo $this->Form->input('TransactionPayment.last_name', array('class' => 'required', 'div' => array('style' => 'display:inline-block; margin-left: 5px;')));
		    echo $this->Form->input('TransactionPayment.street_address_1', array('label' => 'Street', 'class' => 'required', 'size' => '49'));
		    echo $this->Form->input('TransactionPayment.street_address_2', array('label' => 'Street 2', 'size' => '49'));
		    echo $this->Form->input('TransactionPayment.city', array('label' => 'City ', 'class' => 'required', 'size' => '29', 'div' => array('style' => 'display:inline-block')));
		    echo $this->Form->input('TransactionPayment.state', array('label' => 'State ', 'class' => 'required', 'type' => 'select', 'options' => array_merge(array('' => '--Select--'), states()), 'div' => array('style' => 'display:inline-block')));
		    echo $this->Form->input('TransactionPayment.zip', array('label' => 'Zip ', 'class' => 'required', 'size' => '10'));
		    echo $this->Form->hidden('TransactionPayment.country', array('label' => 'Country', 'value' => 'US'));
		    echo $this->Form->input('shipping', array('type' => 'checkbox', 'label' => 'Click here if your shipping address is different than your contact information.', 'checked' => $myCart['TransactionPayment'] != $myCart['TransactionShipment'] ? '' : 'checked'));
		    ?>
		</fieldset>
		<fieldset id="shippingAddress">
		    <legend><?php echo __('Shipping Address'); ?></legend>
		    <div id="shipping_error"></div>
		    <?php
		    echo $this->Form->input('TransactionShipment.first_name', array('label' => 'First Name ', 'div' => array('style' => 'display:inline-block')));
		    echo $this->Form->input('TransactionShipment.last_name', array('label' => 'Last Name ', 'div' => array('style' => 'display:inline-block; margin-left: 5px;')));
		    echo $this->Form->input('TransactionShipment.street_address_1', array('label' => 'Street', 'size' => '49'));
		    echo $this->Form->input('TransactionShipment.street_address_2', array('label' => 'Street 2', 'size' => '49'));
		    echo $this->Form->input('TransactionShipment.city', array('label' => 'City', 'size' => '29', 'div' => array('style' => 'display:inline-block')));
		    echo $this->Form->input('TransactionShipment.state', array('label' => 'State ', 'options' => array_merge(array('' => '--Select--'), states()), 'div' => array('style' => 'display:inline-block')));
		    echo $this->Form->input('TransactionShipment.zip', array('label' => 'Zip', 'size' => '10'));
		    echo $this->Form->hidden('TransactionShipment.country', array('label' => 'Country ', 'value' => 'US'));
		    ?>
		</fieldset>
	    </div><!-- #orderTransactionAddress -->


	    <fieldset id="paymentInformation">
		<legend><?php echo __('Payment Information'); ?></legend>
		<?php
		    echo $this->Element(strtolower($options['paymentMode']));
		?>
	    </fieldset><!-- #PaymentInformation -->

	</div>
	
	
	<div id="transactionCartRight">
	    <?php
		echo $this->Element('trust_logos', array('plugin' => 'orders'));
	    ?>
	    <fieldset id="orderTransactionItems" class="orderTransactionItems">
		<legend>Shopping Cart</legend>

		<?php
		//debug($myCart);
		foreach ($myCart['TransactionItem'] as $i => $transactionItem) {
		    echo $this->Form->hidden("TransactionItem.{$i}.id", array('value' => $transactionItem['id']));
		?>
    		<div class="transactionItemInCart">
			<?php
			echo $this->element('Transactions/cart_item', array(
			    'transactionItem' => $transactionItem,
			    'i' => $i
			    ),
				array('plugin' => ZuhaInflector::pluginize($transactionItem['model']))
			);
			?>
    		</div>

		<?php
		} // foreach($transactionItem)
		?>
	    </fieldset><!-- end orderTransactionItems -->
	    
	    <fieldset>
		<legend>Order Summary</legend>
	    <?php
		#echo !empty($enableShipping) ? $this->Form->input('Transaction.shipping_charge', array('readonly' => true, 'value' => ZuhaInflector::pricify($options['defaultShippingCharge']))) : $this->Form->hidden('OrderTransaction.shipping_charge', array('readonly' => true, 'value' => ''));
		#echo $this->Form->input('Transaction.order_charge', array('label'=>'Sub-Total', 'readonly' => true, 'value' => ZuhaInflector::pricify($myCart['Transaction']['order_charge'])));
		$orderTotal = floatval($options['defaultShippingCharge']) + floatval($myCart['Transaction']['order_charge']);
		$pricifiedOrderTotal = number_format($orderTotal, 2, null, ''); // field is FLOAT, no commas allowed
		echo $this->Form->input('Transaction.discount', array('label' => 'Discount', 'readonly' => true));
		?>
		<div>Subtotal: <span id="TransactionSubtotal" class="total" style="float:right; font-weight: bold; font-size: 110%">$<?php echo ZuhaInflector::pricify($myCart['Transaction']['order_charge']) ?></span></div>
		<div>Shipping: <span id="TransactionShipping" class="total" style="float:right; font-weight: bold; font-size: 110%">+ $<?php echo ZuhaInflector::pricify($options['defaultShippingCharge']) ?></span></div>
		<hr/>
		<div style="margin: 10px 0; font-weight: bold;">Total: <span id="TransactionTotal" class="total" style="float:right; font-weight: bold; font-size: 110%">$<?php echo $pricifiedOrderTotal ?></span></div>
		<div><small><a id="enterPromo" href="#">Enter Promo Code</a></small></div>
		<?php
		#echo $this->Form->input('Transaction.total', array('label' => 'Total <small><a id="enterPromo" href="#">Enter Promo Code</a></small>', 'readonly' => true, 'value' => $pricifiedOrderTotal, 'class' =>'uneditable-input',/* 'after' => defined('__USERS_CREDITS_PER_PRICE_UNIT') ? " Or Credits : " . __USERS_CREDITS_PER_PRICE_UNIT * $orderTotal : "Or Credits : " .  $orderTotal */));
		echo $this->Form->input('TransactionCoupon.code', array('label' => 'Code <small><a id="applyCode" href="#">Apply Code</a></small>'));
		echo $this->Form->hidden('Transaction.quantity');
		
	        echo $this->Form->end('Checkout');
	    ?>
	    </fieldset>
	</div>

    </div><!--  id="orderTransactionForm" class="orderTransactionForm text-inputs" -->
</div>
<script type="text/javascript">

    // hide / show the coupon code input dependent on value
    if (!$("#TransactionCouponCode").val()) {
	$("#TransactionCouponCode").parent().hide();
	$("#enterPromo").click(function(e){
	    e.preventDefault();
	    $("#TransactionCouponCode").parent().toggle('slow');
	});
    }
    // hide the discount input if empty
    if (!$("#TransactionDiscount").val()) {
	$("#TransactionDiscount").parent().hide();
    }
    // handle a submitted code for verification (update total)
    $("#applyCode").click(function(e){
	e.preventDefault();
	$.ajax({
	    type: "POST",
	    data: $('#TransactionCheckoutForm').serialize(),
	    url: "/transactions/transaction_coupons/verify.json" ,
	    dataType: "json",
	    success:function(data){
		var discount = $("#TransactionOrderCharge").val() - data['data']['Transaction']['order_charge'];
		$('#TransactionTotal').val(data['data']['Transaction']['order_charge']);
		$("#TransactionDiscount").val(discount.toFixed(2));
		$("#TransactionDiscount").parent().show();
		//total();
	    },
	    error:function(data){
		$("#TransactionDiscount").val('');
		$("#TransactionDiscount").parent().hide();
		$('#TransactionTotal').val($("#TransactionOrderCharge").val());
		alert('Code out of date or does not apply.');
	    }
	});
    });



    var shipTypeValue = $('#TransactionShippingType').val();
<?php if ($allVirtual) : ?>
        $("#TransactionShipping").parent().hide();
<?php endif; ?>

    $('#TransactionShipping').change(function(e){
	if ( $('#TransactionShipping').attr("checked") == undefined) {
	    $('#TransactionShipmentFirstName').val($('#TransactionPaymentFirstName').val());
	    $('#TransactionShipmentLastName').val($('#TransactionPaymentLastName').val());
	    $('#TransactionShipmentStreetAddress1').val($('#TransactionPaymentStreetAddress1').val());
	    $('#TransactionShipmentStreetAddress2').val($('#TransactionPaymentStreetAddress2').val());
	    $('#TransactionShipmentCity').val($('#TransactionPaymentCity').val());
	    $('#TransactionShipmentState').val($('#TransactionPaymentState').val());
	    $('#TransactionShipmentZip').val($('#TransactionPaymentZip').val());
	    $('#TransactionShipmentCountry').val($('#TransactionPaymentCountry').val());
	    $('#shippingAddress').hide('slow');
	}
	if ( $('#TransactionShipping').attr("checked") == 'checked') {
	    $('#shippingAddress').show('slow');
	}
    });

    $('.shipping_type').change(function(e){
	shipTypeValue = $(this).val();
	var dimmensions = new Array();
	$(this).parent().siblings().children().each(function() {
	    dimmensions[$(this).attr("id")] = $(this).val() ;

	});
	getShipRate(shipTypeValue, dimmensions);
    });


    function getShipRate(shipTypeValue, dimmensions) {
	if (shipTypeValue == ' ') {
	    $('#TransactionShippingCharge').val(0);
	    $('#TransactionTotal').val(parseFloat(<?php echo $this->request->data['Transaction']['order_charge']; ?>));
	    return;
	}

	$.ajax({
	    type: "POST",
	    data: $('#TransactionCheckoutForm').serialize(),
	    url: "/shipping/shippings/getShippingCharge/" ,
	    dataType: "text",
	    success:function(data){
		response(data, dimmensions['OrderTransactionShippingAmmount'])
	    }
	});

    }

    function response(data, prevShippingAmmount) {
	if (data.length > 0) {
	    var response = JSON.parse(data);
	    if(response['Message']) {
		$('#shipping_error').html(response['Message']);
		//$('#step3').hide();
	    }
	    else if(response['amount']) {
		$('#shipping_error').html('');

		var ordershipcharge = parseFloat($('#TransactionShippingCharge').val());
		if(isNaN(ordershipcharge))
		    ordershipcharge = 0;
		ordershipcharge -= parseFloat(prevShippingAmmount) ;
		ordershipcharge += parseFloat(response['amount']) ;
		$('#TransactionShippingCharge').val(ordershipcharge);

		$('#TransactionTotal').val(parseFloat(<?php echo $myCart['Transaction']['order_charge']; ?>) + parseFloat(response['amount']) );
		//$('#step3').show();
	    }
	}
    }

    function shipping_response(data, option_value, option_key) {
	if (data.length > 0) {
	    var response = JSON.parse(data);
	    if(response['amount']) {
		$('#TransactionShippingType').append('<option value="' + option_value + '">'+ option_key +'</option>');
		$('#TransactionShippingCharge').val(response['amount']);
		$('#TransactionTotal').val(parseFloat(<?php echo $myCart['Transaction']['order_charge']; ?>) + parseFloat(response['amount']) );
	    }
	}
    }
    $().ready(function() {
	$("#TransactionCheckoutForm").validate();
    });
    
    var $scrollingDiv = $("#orderTransactionItems");

    $(window).scroll(function(){
	if($(window).scrollTop() + $("#orderTransactionItems").innerHeight() >= $("#transactionCartLeft")[0].scrollHeight) {
	    $scrollingDiv.stop();
	} else {
	$scrollingDiv
	    .stop()
	    .animate({"marginTop": ($(window).scrollTop() + 30) + "px"}, "slow" );
	}
    });
    
</script>
