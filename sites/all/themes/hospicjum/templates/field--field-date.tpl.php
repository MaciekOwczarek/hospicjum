<?php
$longMonths = array(1 => 'styczeń', 'luty', 'marzec', 'kwiecień', 'maj', 'czerwiec', 'lipiec',
				'sierpień', 'wrzesień', 'październik', 'listopad', 'grudzień');

$months = array(1 => 'sty', 'lut', 'mar', 'kwi', 'maj', 'cze', 'lip',
				'sie', 'wrz', 'paź', 'lis', 'gru');

$nuDate = new DateTime($element['#items'][0]['value']);
$y = $nuDate->format('Y');
$m = $months[$nuDate->format('n')];
$d = $nuDate->format('d');
?>
<div class="fancy-date">
	<span class="day"><?php print $d; ?></span>
	<span class="month"><?php print $m; ?></span>
</div>