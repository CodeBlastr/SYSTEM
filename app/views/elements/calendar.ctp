<?php // Jeff Linse's Calendar Element for CakePHP  ?>

<?php
	if ($month < 10) {
		$nextmonth = $month+1;
		$previousmonth = $month-1;
		$month = '0'.$month;
	}
	if ($previousmonth < 10) {
		$previousmonth = '0'.$previousmonth;
	}
	if ($nextmonth < 10) {
		$nextmonth = '0'.$nextmonth;
	}
	$first_of_month = mktime(0, 0, 0, $month, 1, $year);
	$num_days = cal_days_in_month(0, $month, $year);
	$offset = date('w', $first_of_month);
	$rows = 1;
?>
<div class="calendar">
<h1>
<?php echo $html->link('<<<', $month_link.$year.'/'.$previousmonth); ?> 
<?php echo date('F Y', $first_of_month); ?> 
<?php echo $html->link('>>>', $month_link.$year.'/'.$nextmonth); ?>
</h1>
<table>
	<tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr>
	<tr>
	
	<?php for( $i = 1; $i < $offset + 1; ++$i ): ?>
		<td></td>
	<?php endfor; ?>
	
	<?php for( $day = 1; $day <= $num_days; ++$day ): ?>
		<?php if( ($day + $offset - 1) % 7 == 0 && $day != 1 ): ?>
			</tr><tr>
			<?php ++$rows; ?>
		<?php endif; ?>
		<td><?php echo $html->link($day, $day_link.$year.'/'.$month.'/'.$day.'/'); ?></td>
	<?php endfor; ?>
	
	<?php for( $day; ($day + $offset) <= $rows * 7; ++$day ): ?>
		<td></td>
	<?php endfor; ?>
	
	</tr>
</table>
</div>