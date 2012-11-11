<?php
echo __('<span id="%s"></span><hr /><h2> %s Access Privileges </h2><p>Set privileges by checking the box under the user role in the row of the action you want to allow access to.</p>', Inflector::underscore($name), Inflector::humanize(Inflector::underscore($name)));

$groupCount = count($groups);
echo $this->Form->create('Privilege' , array('url'=> array('plugin'=> 'privileges', 'controller'=> 'privileges', 'action'=> 'add'))); ?>
<table>
    <thead>
         <tr>
            <th>Action</th>
            <?php 
            foreach($groups as $g) { 
                if($g["UserRole"]["id"] != 1) { 
                    echo __('<th>%s</th>', $g["UserRole"]["name"]);
                }
            } ?>
        </tr>
    </thead>
    <tbody>
  


    <?php
    foreach($data as $ac) { ?>
        <tr>
            <td> <?php echo $ac['Section']["alias"]; ?> </td>
            <?php
            for($i = 0; $i < $groupCount; $i++) { 
                $field_name = $ac["Section"]["id"] . '_' . $groups[$i]["Requestor"]['id']; 
                if(isset($ac["Requestor"][0]) && $groups[$i]['UserRole']['id'] != 1){
                    // loop throug Requestors to see if it maches the given group
                    $has_check  = false;
                    for($j = 0 ; $j < count($ac["Requestor"]); $j++){
                        if($ac["Requestor"][$j]['ArosAco']['_create'] == 1 && $ac["Requestor"][$j]['ArosAco']['aro_id'] == $groups[$i]["Requestor"]['id']){
                            $has_check = true;
                        }
                    }
                    if($has_check) { 
                        echo '<td>' . $this->Form->input($field_name , array('type' => 'checkbox' , 'label'=>'' , 'checked'=>'true')) . '</td>';
                    } else { 
                        echo '<td>' . $this->Form->input($field_name , array('type' => 'checkbox' , 'label'=>'')) . '</td>';
                    }
                } elseif($groups[$i]["UserRole"]['id'] != 1) {
                    echo '<td>' . $this->Form->input($field_name , array('type' => 'checkbox' , 'label'=>'')) . '</td>';
                }
            } ?>
        </tr>
    <?php
    } ?>
    </tbody>
</table>

<?php
echo $this->Form->end(array('label' => __('Update %s Privileges', Inflector::humanize(Inflector::underscore($name))), 'class' => 'btn-primary'));
echo $this->Html->link(__('Back to Top'), '#sections_view', array('class' => 'pull-right')); ?>