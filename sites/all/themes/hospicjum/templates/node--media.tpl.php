<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
	<?php print render($title_prefix); ?>
	<?php print render($content['field_date']); ?>
	<h2<?php print $title_attributes; ?>>
		<?php print $title; ?>
	</h2>
	<?php print render($title_suffix); ?>
	<?php
	//$node = node_load($nid);
	$mediaTypes = field_get_items('node', $node, 'field_media_type');
	$type = field_view_value('node', $node, 'field_media_type', $mediaTypes[0]);
	?>	
	<?php switch($type['#title']): 
	case 'Video':?>
		video
	<?php break; ?> 
	<?php case 'Silverlight':?>
		<a href="<?php print render($content['field_url']); ?>" target="_blank">
			<i class="icon-share-alt"></i> obejrzyj film (silverlight)
		</a>
	<?php break; ?> 
	<?php case 'Mp3':?>
		<?php
			$file = field_get_items('node', $node, "field_file");
			$uri = file_create_url($file[0]['uri']);
			$themeRoot = '/' . path_to_theme();
			drupal_add_js($themeRoot . '/js/jquery.jplayer.min.js');
		?>
		<div id="jplayer_<?php print $nid ?>"></div>
		<div id="jp_container_<?php print $nid; ?>" class="jp-audio">
			<div class="jp-gui jp-interface">
				<a href="javascript:;" class="jp-play" tabindex="1">
					<img src="<?php print $themeRoot; ?>/img/jplayer/play.png">
				</a>
				<a href="javascript:;" class="jp-pause" tabindex="1"><img src="<?php print $themeRoot; ?>/img/jplayer/pause.png"></a>
				<span class="tap-to-play">kliknij aby odtworzyć</span>
				<div class="jp-progress">
					<div class="jp-seek-bar" style="width: 100%;">
						<div class="jp-play-bar" style="width: 0%;"></div>
					</div>
				</div>
				<a href="javascript:;" class="jp-stop" tabindex="1"><img src="<?php print $themeRoot; ?>/img/jplayer/stop.png"></a>
			</div>
			<div class="jp-no-solution">
				<span>Update Required</span>
				To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
			</div>
		</div>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			$("#jplayer_<?php print $nid ?>").jPlayer({
				ready: function (event) {
					$(this).jPlayer("setMedia", {
						mp3: "<?php print $uri ?>"
					});
				},
				play: function() {
					$(this).jPlayer("pauseOthers");
					$('.jp-audio:not("#jp_container_<?php print $nid; ?>") .jp-gui').removeClass('open');
					$('.jp-audio:not("#jp_container_<?php print $nid; ?>") .jp-stop').fadeOut();
					$('#jp_container_<?php print $nid; ?> .jp-gui').addClass('open');
					$('#jp_container_<?php print $nid; ?> .jp-stop').fadeIn();
				},
						
				supplied: "mp3",
				wmode: "window",
				cssSelectorAncestor: "#jp_container_<?php print $nid; ?>"
			});
			$('.jp-stop').click(function() {
				$(this).closest('.jp-gui').removeClass('open');
				$(this).fadeOut();
			});
			$('.tap-to-play').click(function() {
				$(this).parent().find('.jp-play').trigger('click');
			});
		});
		</script>
	
	<?php break; ?> 
	<?php case 'Link':?>
		<a href="<?php print render($content['field_url']); ?>" target="_blank">
			<i class="icon-share-alt"></i> odwiedź stronę
		</a>
	<?php break; ?> 
	<?php case 'Pdf':?>
		<?php print render($content['field_file']); ?>
	<?php break; ?> 
	<?php case 'Youtube':
		$url = render($content['field_url']);
		parse_str( parse_url( $url, PHP_URL_QUERY ), $tmp );
		$ytUrl = $tmp['v'];
		?>
		<figure class="thumbnail">
			<iframe width="650" height="400" src="http://www.youtube.com/embed/<?php print $ytUrl; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
		</figure>
	<?php break; ?>
	<?php default: ?>
		difolt
	<?php endswitch; ?>
</div>