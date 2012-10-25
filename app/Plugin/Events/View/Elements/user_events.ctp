<?php
/**
 * User's Events Element
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.events.views.elements
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @author	  <joel@razorit.com>
 */


// Get the Data
$myEvents = $this->requestAction('/events/events/myEvents/' . $userId);
//debug($myEvents);


// Generate the Output
$output = '<h2>' . $title . '</h2>';
$lastDay = '';
foreach ($myEvents as $event) {
    $currentDay = date('F jS, Y', strtotime($event['Event']['start']));
    if ($lastDay !== $currentDay) {
	$output .= '<hr /><h3>' . ($currentDay) . '</h3><hr />';
    }

    $output .= $this->Element('singleEvent', array('event' => $event), array('plugin' => 'events'));

    $lastDay = date('F jS, Y', strtotime($event['Event']['start']));
}


if (empty($myEvents)) {
    $output .= '<i>no events found</i>';
}
?>

<div id="ELEMENT_EVENTS_MYEVENTS">
    <ul>
<?php echo $output ?>
    </ul>
</div>
