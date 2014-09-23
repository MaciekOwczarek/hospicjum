<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
	<header>
		<?php print render($title_prefix); ?>
		<?php print render($content['field_date']); ?>
		<?php hide($content['links']); ?>
		<?php if ($page): ?>
			<h1<?php print $title_attributes; ?>><?php print $title; ?></h1>
		<?php else: ?>
			<a href="<?php print $node_url; ?>">
				<h2<?php print $title_attributes; ?>><?php print $title; ?></h2>
			</a>
		<?php endif; ?>
		<?php if($view_mode == 'full'): ?>
		<time pubdate datetime="<?php print date('d-m-Y', $created); ?>">
			Opublikowano: <?php print format_date($created, 'blog_date'); ?>
		</time>
		<?php endif; ?>
		<?php print render($content['field_tags']); ?>
	</header>
	<?php print render($title_suffix); ?>
	<div class="content<?php if(!$is_front) echo ' content-wrapper'; ?>"<?php print $content_attributes; ?>>
		<?php print render($content); ?>
	</div>
	<?php if(true ||
			strlen($content['body']['#items'][0]['summary']) > 0 ||
			$content['body']['#items'][0]['safe_value'] != $content['body'][0]['#markup'] 
		): ?>
		<?php print render($content['links']); ?>
	<?php endif; ?>
	<fb:like href="<?php print $node_url; ?>"></fb:like>
</article>

<script>
jQuery(document).ready(function($) {
	$('a.link2gallery').click(function() {
		$gallery = $(this).closest('article').find('.field-name-field-gallery');
		$('html, body').animate({ scrollTop: $gallery.offset().top });
	});
});
</script>