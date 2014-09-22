<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
	<?php print render($title_prefix); ?>
	<?php if ($page): ?>
		<h1<?php print $title_attributes; ?>>
			<?php if($content['field_fullfilled']['#items'][0]['value'] == 1): ?>
				<small class="badge badge-warning">zrealizowana</small>
			<?php endif; ?>
			<?php print $title; ?>
		</h1>
	<?php else: ?>
		<a href="<?php print $node_url; ?>">
			<h2<?php print $title_attributes; ?>>
				<?php if($content['field_fullfilled']['#items'][0]['value'] == 1): ?>
					<small class="badge badge-warning">zrealizowana</small>
				<?php endif; ?>
				<?php print $title; ?>
			</h2>
		</a>
	<?php endif; ?>
	<?php print render($title_suffix); ?>

	<div class="content<?php if(!$is_front) echo ' content-wrapper'; ?>"<?php print $content_attributes; ?>>
		<?php print render($content); ?>
	</div>
</div>