<?php 
if (isset($context_crumbs) && !empty($context_crumbs['crumbs'])) {
	$count = count($context_crumbs['crumbs']);
	echo '<ul class="breadcrumb">';
	for ($i = 0; $i < $count; $i++) {
		echo '<li>';
		echo $context_crumbs['crumbs'][$i];
		echo $i+1 < $count ? '<span class="divider">/</span>' : null;
		echo '</li>';
	}
	echo '</ul>';
}