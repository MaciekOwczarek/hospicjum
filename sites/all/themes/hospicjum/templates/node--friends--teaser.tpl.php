<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
	<?php print render($title_prefix); ?>
	<?php print render($title_suffix); ?>

	<div class="content<?php if(!$is_front) echo ' content-wrapper'; ?>"<?php print $content_attributes; ?>>
		<?php print render($content['field_friend_logo']); ?>
	</div>
</div>