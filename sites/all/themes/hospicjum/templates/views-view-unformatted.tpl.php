<?php if (!empty($title)): ?>
	<div class="group-header center">
		<h2><?php print $title; ?></h2>
	</div>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
    <?php print $row; ?>
<?php endforeach; ?>