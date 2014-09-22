<?php
$isHidden = field_get_items('node', $node, 'field_hidden');
if($isHidden[0]['value'] == '1') {
	include 'node.tpl.php';
} else {
	include 'node--gallery--teaser.tpl.php';
}
?>