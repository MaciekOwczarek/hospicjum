<?php if(count($items) > 0): ?>
<?php $g = md5(time() . rand(0, 10));
$thumbStyle = $element['#view_mode'] != 'node_embed' ? 'medium-thumbnail' : 'mini-thumbnail';
?>
<div class="thumbs mini">
<?php foreach ($items as $delta => $item): ?>
	<?php
		$thumbUrl = image_style_url($thumbStyle, $item['#item']['uri']);
		$fileUrl = file_create_url($item['#item']['uri']);
	?>
	<a href="<?php print($fileUrl); ?>" class="thumbnail fancybox" rel="gallery-<?php print $g; ?>">
		<img src="<?php print($thumbUrl); ?>">
	</a>
<?php endforeach; ?>
</div>
<?php endif; ?>