<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
	<?php print render($title_prefix); ?>
	<?php if($view_mode != 'node_embed' && substr($title, 0, 8) != "[hidden]"):?>
		<?php if ($page): ?>
			<h1<?php print $title_attributes; ?>><?php print $title; ?></h1>
		<?php else: ?>
			<a href="<?php print $node_url; ?>">
				<h2<?php print $title_attributes; ?>>
					<?php print $title; ?>
				</h2>
			</a>
		<?php endif; ?>
	<?php endif; ?>
	<?php print render($title_suffix); ?>

	<div class="content<?php if(!$is_front) echo ' content-wrapper'; ?>"<?php print $content_attributes; ?>>
		<?php print render($content); ?>
	</div>
</div>