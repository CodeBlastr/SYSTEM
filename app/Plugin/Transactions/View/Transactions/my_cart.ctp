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
 * @todo		  Definitely need to do something about the redirect urls
 */
?>

<div id="transactionsCheckout" class="transactions checkout form">
    <?php
    echo $this->Html->script('system/jquery.validate.min');
    echo $this->Form->create('Transaction');
    ?>

    <h2>
	<?php echo __('My Cart'); ?>
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
		    echo $this->Form->input('TransactionPayment.city', array('label' => 'City ', 'class' => 'required', 'size' => '30', 'div' => array('style' => 'display:inline-block')));
		    echo $this->Form->input('TransactionPayment.state', array('label' => 'State ', 'class' => 'required', 'type' => 'select', 'options' => array_merge(array('' => '--Select--'), states()), 'div' => array('style' => 'display:inline-block')));
		    echo $this->Form->input('TransactionPayment.zip', array('label' => 'Zip ', 'class' => 'required', 'size' => '10'));
		    echo $this->Form->hidden('TransactionPayment.country', array('label' => 'Country', 'value' => 'US'));
		    echo $this->Form->hidden('TransactionPayment.user_id', array('value' => $this->Session->read('Auth.User.id')));
		    echo $this->Form->hidden('customer_id', array('value' => $this->Session->read('Auth.User.id')));
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
		    echo $this->Form->input('TransactionShipment.city', array('label' => 'City', 'size' => '30', 'div' => array('style' => 'display:inline-block')));
		    echo $this->Form->input('TransactionShipment.state', array('label' => 'State ', 'options' => array_merge(array('' => '--Select--'), states()), 'div' => array('style' => 'display:inline-block')));
		    echo $this->Form->input('TransactionShipment.zip', array('label' => 'Zip', 'size' => '10'));
		    echo $this->Form->hidden('TransactionShipment.country', array('label' => 'Country ', 'value' => 'US'));
		    echo $this->Form->hidden('TransactionShipment.user_id', array('value' => $this->Session->read('Auth.User.id')));
		    ?>
		</fieldset>
	    </div><!-- #orderTransactionAddress -->


	    <fieldset id="paymentInformation">
		<legend><?php echo __('Payment Information'); ?></legend>
		<?php
		echo $this->Form->input('mode', array('label' => 'Payment Type', 'options' => $options['paymentOptions'], 'default' => $options['paymentMode']));
		echo $this->Element(strtolower($options['paymentMode']));
		?>
		<fieldset id="creditCardInfo">
		    <?php echo $this->Form->input('card_number', array('label' => 'Card Number', 'class' => 'required')); ?>
		    <div class="input select">
			<label>Expiration Date</label>
			<?php
			echo $this->Form->input('card_exp_month', array('label' => false, 'type' => 'select', 'options' => array_combine(range(1, 12, 1), range(1, 12, 1)), 'div' => false));
			echo $this->Form->input('card_exp_year', array('label' => false, 'type' => 'select', 'options' => array_combine(range(date('Y'), date('Y', strtotime('+ 10 years')), 1), range(date('Y'), date('Y', strtotime('+ 10 years')), 1)), 'dateFormat' => 'Y', 'div' => false));
			?>
		    </div>
		    <?php echo $this->Form->input('card_sec', array('label' => 'CCV Code ' . $this->Html->link('?', '#ccvHelp', array('class' => 'helpBox', 'title' => 'You can find this 3 or 4 digit code on the back of your card, typically in the signature area.')), 'maxLength' => 4, 'size' => 4)); ?>
		</fieldset><!-- #creditCardInfo -->
		
	    </fieldset><!-- #PaymentInformation -->

	</div>
	<div id="transactionCartRight">
	    <?php
		echo $this->Element('trust_logos', array('plugin' => 'orders'));
	    ?>
	    <div id="orderTransactionItems" class="orderTransactionItems">

		<?php
		//debug($myCart);
		foreach ($myCart['TransactionItem'] as $i => $transactionItem) {
		    ?>
    		<div class="transactionItemInCart">
			<?php
			echo $this->element(
				'Transactions/cart_item', array('transactionItem' => $transactionItem), array('plugin' => ZuhaInflector::pluginize($transactionItem['model']))
			);
			?>
    		</div>

    <?php
    if ($options['enableShipping']) {
	$weight[$i] = $transactionItem['weight'];
	$length[$i] = $transactionItem['length'];
	$height[$i] = $transactionItem['height'];
	$width[$i] = $transactionItem['width'];

	// Hardcoded display none, because this shipping thing should never have been here.  You cannot choose different shipping type for each individual item.  That would just be a nightmare, and we've never gotten a request to make it this way.  So because of the time crunch I made it display none, but this needs to be removed all together, and the shipping needs to be calculator for the entire order --- there can be shipping difference for each item, but they would only be shown as part of the whole shipping cost. 
	?>
			<div id="shipping" class="hide">
			    <div id="dimmensions"> <?php echo $this->Form->hidden("length", array('value' => $length[$i])); ?> <?php echo $this->Form->hidden("width", array('value' => $width[$i])); ?> <?php echo $this->Form->hidden("height", array('value' => $height[$i])); ?> <?php echo $this->Form->hidden("weight", array('value' => $weight[$i])); ?> <?php echo $this->Form->hidden("shipping_ammount", array('value' => '')); ?> </div>
			    <div id="selector"> <?php echo $this->Form->select("shippingType", $fedexSettings, array('value' => $orderItem['CatalogItem']['shipping_type'], 'empty' => false, 'class' => 'shipping_type')); ?> </div>
			</div>


	<?php
	if (isset($transactionItem['shipping_charge'])) {
	    $defaultShippingCharge += $transactionItem['shipping_charge'];
	    ?>
	    		<script type="text/javascript">
	    		    var shippingamnt = parseFloat(<?php echo $transactionItem['shipping_charge']; ?>) ;
	    		    if(isNaN(shippingamnt))
	    			shippingamnt = 0;
	    		    var shippingCharge = parseFloat($('#TransactionShippingCharge').val());
	    		    if(isNaN(shippingCharge))
	    			shippingCharge = 0;

	    		    shippingCharge += shippingamnt;
	    		    var orderCharge = parseFloat(<?php echo $this->request->data['Transaction']['order_charge']; ?>);
	    		    if(isNaN(orderCharge))
	    			orderCharge = 0;
	    		    orderCharge += shippingCharge;
	    		    $('#TransactionShippingAmmount').val(shippingamnt);
	    		    $('#TransactionShippingCharge').val(shippingCharge);
	    		    $('#TransactionTotal').val(orderCharge);
	    		</script>
	    <?php
	} else {
	    $param = null;
	    # if dimensions are not set
	    if (!empty($weight[$i]) && !empty($length[$i]) && !empty($height[$i]) && !empty($width[$i])) {
		$param = 'weight:' . $weight[$i] . '/length:' . $length[$i] . '/height:' . $height[$i]
			. '/width:' . $width[$i];
	    }
	    ?>
	    		<script type="text/javascript">
	    		    $(document).ready(function(){
	    			$.ajax({
	    			    type: "POST",
	    			    data: $('#TransactionCheckoutForm').serialize(),
	    			    url: "/shipping/shippings/getShippingCharge/" ,
	    			    dataType: "text",
	    			    success:function(data){
	    				if (data.length > 0) {
	    				    var response = JSON.parse(data);
	    				    if(response['amount']) {
	    					var amt = parseFloat(response['amount']);
	    					var shipcharge = parseFloat($('#TransactionShippingCharge').val());
	    					if(isNaN(shipcharge))
	    					    shipcharge = 0;
	    					shipcharge += amt;
	    					var ocharge = parseFloat($('#TransactionOrderCharge').val());

	    					ocharge += shipcharge;
	    					$('#TransactionShippingAmmount').val(amt);
	    					$('#TransactionShippingCharge').val(shipcharge);
	    					$('#TransactionTotal').val(ocharge);
	    				    }
	    				}
	    			    }
	    			});
	    		    });
	    		</script>
	    <?php
	} //isset($orderItem['CatalogItem']['shipping_charge'])
    } // $enableShipping

    echo $this->Form->hidden("TransactionItem.{$i}.name", array('value' => $transactionItem['name']));
    echo $this->Form->hidden("TransactionItem.{$i}.id", array('value' => $transactionItem['id']));
    echo $this->Form->hidden("TransactionItem.{$i}.CatalogItem.id", array('value' => $transactionItem['id']));
    echo $this->Form->hidden("TransactionItem.{$i}.CatalogItem.model", array('value' => $transactionItem['model']));
    echo $this->Form->hidden("TransactionItem.{$i}.CatalogItem.foreign_key", array('value' => $transactionItem['foreign_key']));
    ?>
		    <?php
		} // foreach($transactionItem)
		?>
	    </div><!-- end orderTransactionItems -->

	    <?php
		echo!empty($enableShipping) ? $this->Form->input('Transaction.shipping_charge', array('readonly' => true, 'value' => ZuhaInflector::pricify($options['defaultShippingCharge']))) : $this->Form->hidden('OrderTransaction.shipping_charge', array('readonly' => true, 'value' => ''));
		echo $this->Form->input('Transaction.order_charge', array('label'=>'Sub-Total', 'readonly' => true, 'value' => ZuhaInflector::pricify($myCart['Transaction']['order_charge'])));
		$orderTotal = floatval($options['defaultShippingCharge']) + floatval($myCart['Transaction']['order_charge']);
		$pricifiedOrderTotal = number_format($orderTotal, 2, null, ''); // field is FLOAT, no commas allowed
		echo $this->Form->input('Transaction.discount', array('label' => 'Discount', 'readonly' => true));
		echo $this->Form->input('Transaction.total', array('label' => 'Total <small><a id="enterPromo" href="#">Enter Promo Code</a></small>', 'readonly' => true, 'value' => $pricifiedOrderTotal, 'class' =>'uneditable-input'/* 'after' => defined('__USERS_CREDITS_PER_PRICE_UNIT') ? " Or Credits : " . __USERS_CREDITS_PER_PRICE_UNIT * $orderTotal : "Or Credits : " .  $orderTotal */));
		echo $this->Form->input('TransactionCoupon.code', array('label' => 'Code <small><a id="applyCode" href="#">Apply Code</a></small>'));
		echo $this->Form->hidden('Transaction.quantity');
		
	        echo $this->Form->end('Checkout');
	    ?>
	</div>

    </div><!--  id="orderTransactionForm" class="orderTransactionForm text-inputs" -->
</div>
<script type="text/javascript">

	    
    changePaymentInputs();
    // hide / show the coupon code input dependent on value
    if (!$("#TransactionCouponCode").val()) {
	$("#TransactionCouponCode").parent().hide();
	$("#enterPromo").click(function(e){
	    e.preventDefault();
	    $("#TransactionCouponCode").parent().toggle();
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

    $('#TransactionMode').change(function(e){
	changePaymentInputs();
    });


    $('.shipping_type').change(function(e){
	shipTypeValue = $(this).val();
	var dimmensions = new Array();
	$(this).parent().siblings().children().each(function() {
	    dimmensions[$(this).attr("id")] = $(this).val() ;

	});
	getShipRate(shipTypeValue, dimmensions);
    });

    function changePaymentInputs() {
	if ($('#TransactionMode').val() == 'CREDIT') {
	    if ($('#creditCardInfo').is(":visible"))
		$('#TransactionCardNumber').removeClass('required');
	    $('#creditCardInfo').hide();
	} else {
	    $('#TransactionCardNumber').addClass('required');
	    $('#creditCardInfo').show();
	}
    }

    function getShipRate(shipTypeValue, dimmensions) {
	if (shipTypeValue == ' ') {
	    //$('#step3').hide();
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
	    $scrollingDiv
		    .stop()
		    .animate({"marginTop": ($(window).scrollTop() + 30) + "px"}, "slow" );			
    });
    
</script>
