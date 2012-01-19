<?php
$sorts = !empty($context_sort['sorter']) ? $context_sort['sorter'] : null;
if (!empty($sorts)) {
	# @todo	  split these types into separate sub elements of this element
	if ($context_sort['type'] == 'select') {
		$sorter = '<div class="contextSorter">';
		$sorter .= '<form class="contextSorterForm actions" action="" type="get">';
				foreach ($sorts as $sortGroup) :
					$sorter .= !empty($sortGroup['heading']) ? '<label class="sorterLabel" for="sorterId">'.$sortGroup['heading'].'</label>' : '<label class="sorterLabel" for="sorterId"> Sort by </label>';
					$sorter .= '<select name="contextSorter" class="sorterSelect" id="sorterId">';
					$sorter .= '<option value=""> -- Select -- </option>';
						if (!empty($sortGroup['items'])):
							foreach ($sortGroup['items'] as $item) :
								$doc = new DOMDocument();
								$doc->loadHTML($item);
								$xml = simplexml_import_dom($doc);
								$href = $xml->xpath('//a/@href');
								$class = substr($item, strpos($item, 'direction') + 10, 3);
								$sorter .= '<option value="'.$href[0].'" class="'.$class.'">'.$item.'</option>';
							endforeach;
						endif;
					$sorter .= '</select>';
					$sorter .= !empty($sortGroup['heading']) ? '<input type="submit" value="'.$sortGroup['heading'].'" />' : '<input type="submit" value="Sort" />';
				endforeach;
		$sorter .= '</form>';
		$sorter .= '</div>';
	} else {
		# default sort type output
		$sorter = '<div class="contextSorter actions">';
		$sorter .= '<ul class="drop">';
				foreach ($sorts as $sortGroup) :
					$sorter .= '<li class="actionHeading"><span>'.$sortGroup['heading'].'</span></a>';
						if (!empty($sortGroup['items'])):
							foreach ($sortGroup['items'] as $item) :
								$sorter .= '<li class="actionItem">'.$item.'</li>';
							endforeach;
						endif;
					$sorts .= '';
				endforeach;
		$sorter .= '</ul></div>';
	}
}
echo !empty($sorter) ? $sorter : null;
?>