<!-- PaySimple -->
<?php
echo $this->Form->input('mode', array(
    'label' => 'Payment Method',
    'options' => $options['paymentOptions'],
    'default' => $options['paymentMode']
    ));
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
<fieldset id="echeckInfo">
    <?php echo $this->Form->input('ach_routing_number', array('label' => 'Routing Number', 'class' => 'required')); ?>
    <?php echo $this->Form->input('ach_account_number', array('label' => 'Account Number', 'class' => 'required')); ?>
    <?php echo $this->Form->input('ach_bank_name', array('label' => 'Bank Name', 'class' => 'required')); ?>
    <?php echo $this->Form->input('ach_is_checking_account', array('type' => 'checkbox', 'label' => 'Is this a checking account?')); ?>

    <?php #echo $this->Form->input('card_sec', array('label' => 'CCV Code ' . $this->Html->link('?', '#ccvHelp', array('class' => 'helpBox', 'title' => 'You can find this 3 or 4 digit code on the back of your card, typically in the signature area.')), 'maxLength' => 4, 'size' => 4)); ?>
</fieldset><!-- #creditCardInfo -->

<script type="text/javascript">
    function changePaymentInputs() {
	if ($('#TransactionMode').val() == 'PAYSIMPLECHECK') {
	    $('#TransactionCardNumber').removeClass('required');
	    $('#creditCardInfo').hide('fast');
	    $('#echeckInfo').show('slow');
	} else {
	    $('#TransactionCardNumber').addClass('required');
	    $('#echeckInfo').hide('fast');
	    $('#creditCardInfo').show('slow');
	}
    }
    $('#TransactionMode').change(function(e){
	changePaymentInputs();
    });
    changePaymentInputs();
</script>