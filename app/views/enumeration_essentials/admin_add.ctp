<?php
echo $form->create('EnumerationEssential');
echo $form->input('EnumerationEssential.id',array('type'=>'hidden'));
echo $form->input('EnumerationEssential.name');
if(count($enumerationEssentialTypes)) {
	echo $form->input('EnumerationEssential.type',array('type'=>'select','options'=>array_merge($enumerationEssentialTypes,array('+'=>'+ Add new type'))));
}
else {
	echo $form->input('EnumerationEssential.type');
}
echo $form->button('Done',array('type'=>'submit'));
?>

<script type='text/javascript'>
$(document).ready(function() {
	$('select<#EnumerationEssentialType').change(function() {
		if($(this).val() == '+') {
			$(this).replaceWith('<input name="data[EnumerationEssential][type]" id="EnumerationEssentialType" type="text" />')
		}
	});
});
</script>