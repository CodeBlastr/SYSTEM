<?php
echo $form->create('Enumeration');
echo $form->input('Enumeration.id');
echo $form->input('Enumeration.name');
if(count($enumerationTypes)) {
	echo $form->input('Enumeration.type',array('type'=>'select','options'=>array_merge($enumerationTypes,array('+'=>'+ Add new type'))));
}
else {
	echo $form->input('Enumeration.type');
}
echo $form->button('Done',array('type'=>'submit'));
?>

<script type='text/javascript'>
$(document).ready(function() {
	$('select<#EnumerationType').change(function() {
		if($(this).val() == '+') {
			$(this).replaceWith('<input name="data[Enumeration][type]" id="EnumerationType" type="text" />')
		}
	});
});
</script>