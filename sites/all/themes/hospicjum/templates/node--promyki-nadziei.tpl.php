<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
	<?php print render($title_prefix); ?>
	<?php if ($page): ?>
		<h1<?php print $title_attributes; ?>><?php print $title; ?></h1>
	<?php endif; ?>
	<?php print render($title_suffix); ?>
	
	<a href="<?php print file_create_url($node->field_pdf['und'][0]['uri']); ?>" class="thumbnail"<?php print $content_attributes; ?> target="_blank">
		<?php print render($content['field_cover']); ?> 
		<figcaption>
			<i class="icon icon-download"></i> <?php print $title; ?>
		</figcaption>
	</a>
</div>