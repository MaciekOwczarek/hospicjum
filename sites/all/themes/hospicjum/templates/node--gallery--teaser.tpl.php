<?php
$longMonths = array(1 => 'styczeń', 'luty', 'marzec', 'kwiecień', 'maj', 'czerwiec', 'lipiec',
				'sierpień', 'wrzesień', 'październik', 'listopad', 'grudzień');

$months = array(1 => 'sty', 'lut', 'mar', 'kwi', 'maj', 'cze', 'lip',
				'sie', 'wrz', 'paź', 'lis', 'gru');

$nuDate = new DateTime("@$created");
$y = $nuDate->format('Y');
$m = $months[$nuDate->format('n')];
$d = $nuDate->format('d');

$photoField = field_get_items('node', $node, 'field_photo');
$countPhotos = count($photoField);
$photos = array($content['field_photo'][0], $content['field_photo'][0], $content['field_photo'][0]);
?>


<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
	<?php print render($title_prefix); ?>
	<?php print render($title_suffix); ?>
	<div class="fancy-date">
		<span class="day"><?php print $d; ?></span>
		<span class="month"><?php print $m; ?></span>
	</div>
	<a href="<?php print $node_url; ?>" data-click="open-gallery">
		<div class="mini-photos">
			<?php print render($photos); ?>
		</div>
		<h2<?php print $title_attributes; ?>>
			<?php print $title; ?>
		</h2>
		<div class="photos-count">
			Liczba zdjęć: <span class="badge badge-warning"><?php print $countPhotos; ?></span>
		</div>
	</a>
</div>