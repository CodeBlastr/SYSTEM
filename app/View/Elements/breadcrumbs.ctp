<?php
if (isset($context_crumbs) && !empty($context_crumbs['crumbs'])) {
	$count = count($context_crumbs['crumbs']);
	echo '<ul class="breadcrumb">';
	for ($i = 0; $i < $count; $i++) {
		if (!empty($context_crumbs['crumbs'][$i])) {
			echo '<li>' . $context_crumbs['crumbs'][$i] . '</li>';
		}
	}
	echo '</ul>';
}