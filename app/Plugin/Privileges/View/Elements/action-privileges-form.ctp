<?php

echo __('<span id="%s"></span><hr /><h2> %s Access Privileges </h2><p>Set privileges by checking the box under the user role in the row of the action you want to allow access to.</p>', Inflector::underscore($name), Inflector::humanize(Inflector::underscore($name)));

echo $this->Form->create('Privilege', array('url' => array('plugin' => 'privileges', 'controller' => 'privileges', 'action' => 'add')));

echo '<table class="table"><thead>';
$tableHeaders[] = 'Action';
foreach ($groups as $g) {
	if ($g["UserRole"]["id"] != 1) {
		$tableHeaders[] = $g["UserRole"]["name"];
	}
}
echo $this->Html->tableHeaders($tableHeaders);
echo '</thead><tbody>';

foreach ($data as $ac) {
	
	$tableCells = array($ac['Section']["alias"]);
	
	for ($i = 0; $i < count($groups); $i++) {
		
		$field_name = $ac["Section"]["id"] . '_' . $groups[$i]["Requestor"]['id'];	
		$formInputs = '';
		$cell = '';
		
		// remove admin user role (they have access to everything)
		if (isset($ac["Requestor"][0]) && $groups[$i]['UserRole']['id'] != 1) {
			// loop through Requestors to see if it maches the given group
			$hasCheck = false;
			for ($j = 0; $j < count($ac["Requestor"]); $j++) {
				if ($ac["Requestor"][$j]['ArosAco']['_create'] == 1 && $ac["Requestor"][$j]['ArosAco']['aro_id'] == $groups[$i]["Requestor"]['id']) {
					$hasCheck = true;
				}
			}
			
			$cell .= '<div class="checkboxToggleDiv">';
			if($groups[$i]['UserRole']['id'] != 5) {
				if (!empty($userFields)) {
					$q = 0;
					foreach($userFields as $field) {
						if($hasCheck) {
							// check each user field to see if it is set
							$requestors = Set::combine($ac['Requestor'], '{n}.ArosAco.aro_id', '{n}.ArosAco.user_fields');
							$requestorUserFields = $requestors[$groups[$i]['Requestor']['id']];
							$isUserFieldSet = strpos($requestorUserFields, $field) > 0 || strpos($requestorUserFields, $field) === 0;
							$checked = $isUserFieldSet;
						} else {
							$checked = false;
						}
						$formInputs .= $this->Form->input('ArosAco' .  '.' . $field_name . '.' . $field, array('type' => 'checkbox', 'label' => __('Only %s', Inflector::pluralize(Inflector::humanize(strstr($field, '_', TRUE)))), 'checked' => $checked === false ? null : 'true', 'div' => false));
						$q++;
					}
				}
			}
			
			if ($hasCheck) {
				$cell .= $this->Form->input($field_name, array('type' => 'checkbox', 'label' => '', 'checked' => 'true', 'div' => false));
				$cell .= '<div class="ct-on">';
				$cell .= $formInputs;
				$cell .= '</div></div>';
			} else {
				$cell .= $this->Form->input($field_name, array('type' => 'checkbox', 'label' => '', 'div' => false));
				$cell .= '<div class="ct-on">';
				$cell .= $formInputs;
				$cell .= '</div></div>';	
			}
		} elseif ($groups[$i]["UserRole"]['id'] != 1) {
			$cell .= '<div class="checkboxToggleDiv">';
			if($groups[$i]['UserRole']['id'] != 5) {
				if (!empty($userFields)) {
					foreach($userFields as $field) {
						$formInputs .= $this->Form->input('ArosAco' .  '.' . $field_name . '.' . $field, array('type' => 'checkbox', 'label' => __('Only %s', Inflector::pluralize(Inflector::humanize(strstr($field, '_', TRUE)))), 'div' => false));
					}
				}			
			}
			$cell .= $this->Form->input($field_name, array('type' => 'checkbox', 'label' => '', 'div' => false));
			$cell .= '<div class="ct-on">';
			$cell .= $formInputs;
			$cell .= '</div></div>';
		}
		if($cell !== ''){
			$tableCells[] = $cell;
		}
		
	}

	echo $this->Html->tableCells(array($tableCells));
} // end <tr> loop

echo '</tbody></table>';

echo $this->Form->end(array('label' => __('Update %s Privileges', Inflector::humanize(Inflector::underscore($name))), 'class' => 'btn-primary', 'div' => false));
