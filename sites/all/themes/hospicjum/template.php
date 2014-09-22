<?php

/**
 * Add body classes if certain regions have content.
 */
function hospicjum_preprocess_html(&$variables) {
	if (!empty($variables['page']['featured'])) {
		$variables['classes_array'][] = 'featured';
	}

	// Add conditional stylesheets for IE
	drupal_add_css(path_to_theme() . '/css/ie.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 'preprocess' => FALSE));
	drupal_add_css(path_to_theme() . '/css/ie6.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'IE 6', '!IE' => FALSE), 'preprocess' => FALSE));

	/**
	TODO: check this shitty workaround
	*/
	$variables['head_title'] = strip_tags(htmlspecialchars_decode(drupal_get_title()));
}

/**
 * Override or insert variables into the page template for HTML output.
 */
function hospicjum_process_html(&$variables) {
	// Hook into color.module.
	if (module_exists('color')) {
		_color_html_alter($variables);
	}
}

function hospicjum_css_alter(&$css) {
	unset($css[drupal_get_path('module','system').'/system.menus.css']);
	unset($css[drupal_get_path('module', 'system') . '/defaults.css']);
	unset($css[drupal_get_path('module', 'system') . '/system.css']);
	unset($css[drupal_get_path('module', 'system') . '/system.menus.css']);
	unset($css[drupal_get_path('module', 'system') . '/system.theme.css']);
	unset($css[drupal_get_path('module', 'user') . '/user.css']);
}

/**
 * Override or insert variables into the page template.
 */
function hospicjum_process_page(&$variables) {
	// Hook into color.module.
	if (module_exists('color')) {
		_color_page_alter($variables);
	}
	// Always print the site name and slogan, but if they are toggled off, we'll
	// just hide them visually.
	$variables['hide_site_name']   = theme_get_setting('toggle_name') ? FALSE : TRUE;
	$variables['hide_site_slogan'] = theme_get_setting('toggle_slogan') ? FALSE : TRUE;
	if ($variables['hide_site_name']) {
		// If toggle_name is FALSE, the site_name will be empty, so we rebuild it.
		$variables['site_name'] = filter_xss_admin(variable_get('site_name', 'Drupal'));
	}
	if ($variables['hide_site_slogan']) {
		// If toggle_site_slogan is FALSE, the site_slogan will be empty, so we rebuild it.
		$variables['site_slogan'] = filter_xss_admin(variable_get('site_slogan', ''));
	}
	// Since the title and the shortcut link are both block level elements,
	// positioning them next to each other is much simpler with a wrapper div.
	if (!empty($variables['title_suffix']['add_or_remove_shortcut']) && $variables['title']) {
		// Add a wrapper div using the title_prefix and title_suffix render elements.
		$variables['title_prefix']['shortcut_wrapper'] = array(
				'#markup' => '<div class="shortcut-wrapper clearfix">',
				'#weight' => 100,
		);
		$variables['title_suffix']['shortcut_wrapper'] = array(
				'#markup' => '</div>',
				'#weight' => -99,
		);
		// Make sure the shortcut link is the first item in title_suffix.
		$variables['title_suffix']['add_or_remove_shortcut']['#weight'] = -100;
	}
}

/**
 * This will replace the default version of jquery with a newer version.
 */
function hospicjum_js_alter(&$js) {
	if (arg(0) != 'admin' || !(arg(1) == 'add' && arg(2) == 'edit') || arg(0) != 'panels' || arg(0) != 'ctools') {
		$theme_path = drupal_get_path('theme', variable_get('theme_default', NULL));
		$new_jquery = $theme_path . '/js/jquery-1.9.1.min.js';

		// Copy the current jQuery file settings and change
		$js[$new_jquery] = $js['misc/jquery.js'];

		// Update necessary settings
		$js[$new_jquery]['version'] = '1.9.1';
		$js[$new_jquery]['data'] = $new_jquery;

		// Finally remove the original jQuery
		unset($js['misc/jquery.js']);
	}
}

/**
 * Implements hook_preprocess_maintenance_page().
 */
function hospicjum_preprocess_maintenance_page(&$variables) {
	if (!$variables['db_is_active']) {
		unset($variables['site_name']);
	}
}

/**
 * Override or insert variables into the maintenance page template.
 */
function hospicjum_process_maintenance_page(&$variables) {
	// Always print the site name and slogan, but if they are toggled off, we'll
	// just hide them visually.
	$variables['hide_site_name']   = theme_get_setting('toggle_name') ? FALSE : TRUE;
	$variables['hide_site_slogan'] = theme_get_setting('toggle_slogan') ? FALSE : TRUE;
	if ($variables['hide_site_name']) {
		// If toggle_name is FALSE, the site_name will be empty, so we rebuild it.
		$variables['site_name'] = filter_xss_admin(variable_get('site_name', 'Drupal'));
	}
	if ($variables['hide_site_slogan']) {
		// If toggle_site_slogan is FALSE, the site_slogan will be empty, so we rebuild it.
		$variables['site_slogan'] = filter_xss_admin(variable_get('site_slogan', ''));
	}
}

/**
 * Override or insert variables into the node template.
 */
function hospicjum_preprocess_node(&$variables) {
	if ($variables['view_mode'] == 'full' && node_is_page($variables['node'])) {
		$variables['classes_array'][] = 'node-full';
	}
	if ($variables['view_mode'] == 'teaser') {
		$variables['theme_hook_suggestions'][] = 'node__'.$variables['node']->type.'__teaser';
	}
	$variables['classes_array'][] = 'node-' .$variables['view_mode'];
	$variables['title'] = $variables['node']->title;
}

/**
 * Override or insert variables into the block template.
 */
function hospicjum_preprocess_block(&$variables) {
	// In the header region visually hide block titles.
	if ($variables['block']->region == 'header') {
		$variables['title_attributes_array']['class'][] = 'element-invisible';
	}
}

function hospicjum_entity_view($entity, $type, $view_mode, $langcode) {
	if ($view_mode == 'teaser') {
		$entity->content['field_photo']['#items'] = array_slice($entity->content['field_photo']['#items'], 0, 1);
	}
}

/**
 * Implements theme_menu_tree().
 */
function hospicjum_menu_tree($variables) {
	return '<ul class="menu">' . $variables['tree'] . '</ul>';
}

/**
 * Implements theme_field__field_type().
 */
function hospicjum_field__taxonomy_term_reference($variables) {
	$output = '';

	// Render the label, if it's not hidden.
	if (!$variables['label_hidden']) {
		$output .= '<h3 class="field-label">' . $variables['label'] . ': </h3>';
	}

	// Render the items.
	$output .= ($variables['element']['#label_display'] == 'inline') ? '<ul class="links inline">' : '<ul class="links">';
	foreach ($variables['items'] as $delta => $item) {
		$output .= '<li class="taxonomy-term-reference-' . $delta . '"' . $variables['item_attributes'][$delta] . '><i class="icon-tag"></i> ' . drupal_render($item) . '</li>';
	}
	$output .= '</ul>';

	// Render the top-level DIV.
	$output = '<div class="' . $variables['classes'] . (!in_array('clearfix', $variables['classes_array']) ? ' ' : '') . '">' . $output . '</div>';
	// 	$output = '<div class="' . $variables['classes'] . (!in_array('clearfix', $variables['classes_array']) ? ' clearfix' : '') . '">' . $output . '</div>';

	return $output;
}

function hospicjum_preprocess_page(&$variables, $hook) {
	global $user;

	$user = user_load($user->uid);
	$variables['userRoles'] = $user->roles;

	if(isset($variables['node']) && $variables['node']->type == 'project') {
		$breadcrumbs = drupal_get_breadcrumb();
		$breadcrumbs[] = $variables['node']->title;
		drupal_set_breadcrumb($breadcrumbs);
	}
}

function hospicjum_menu_alter(&$items) {
	$items['node/%node/view']['context'] = MENU_CONTEXT_INLINE | MENU_CONTEXT_PAGE;
	$items['node/%node/edit']['context'] = MENU_CONTEXT_INLINE | MENU_CONTEXT_PAGE;
	$items['node/%node/moderation']['context'] = MENU_CONTEXT_INLINE | MENU_CONTEXT_PAGE;
	$items['node/%node/delete']['context'] = MENU_CONTEXT_INLINE | MENU_CONTEXT_PAGE;
}

function hospicjum_node_view_alter(&$build) {
	drupal_add_library('contextual', 'contextual-links');
	$node = $build['#node'];
	if (!empty($node->nid)) {
		$build['#contextual_links']['node'] = array('node', array($node->nid));
	}
}

function hospicjum_menu_contextual_links_alter(&$links, $router_item, $root_path) {
	unset($links['node-view']);
}

function hospicjum_contextual_links_view_alter(&$element, $items) {
	if (isset($element['#element']['#node']->nid)) {
		unset($element['#links']['node-delete']);
	}
}

function hospicjum_form_alter(&$form, &$form_state, $form_id) {
	if(isset($form['submitted'])) {
		foreach ($form['submitted'] as $key => &$value) {
			if ($value["#type"] == "textfield" || $value["#type"] == 'textarea' || $value["#type"] == 'webform_email'){
				//$value['#attributes']["placeholder"] = array(t($value["#title"]));
			}
		}
	}
	$form['actions']['submit']['#attributes']['class'][] = 'btn';
}

function hospicjum_file_icon($variables) {
	return null;
}

function hospicjum_file_link($variables) {
	$file = $variables['file'];
	$icon_directory = $variables['icon_directory'];

	$url = file_create_url($file->uri);
	$icon = theme('file_icon', array('file' => $file, 'icon_directory' => $icon_directory));

	// Set options as per anchor format described at
	// http://microformats.org/wiki/file-format-examples
	$options = array(
			'attributes' => array(
					'type' => $file->filemime . '; length=' . $file->filesize,
					'class' => array('icon'),
			),
	);

	// Use the description as the link text if available.
	if (empty($file->description)) {
		$link_text = $file->filename;
	}
	else {
		$link_text = $file->description;
		$options['attributes']['title'] = check_plain($file->filename);
	}

	return $icon . ' ' . l($link_text, $url, $options);
}

function hospicjum_date_display_single($variables) {
	$date = $variables['date'];
	$timezone = $variables['timezone'];
	$attributes = $variables['attributes'];

	// Wrap the result with the attributes.
	return '<span class="date-display-single"' . drupal_attributes($attributes) . '>' . $date . $timezone . '</span>';
}

function hospicjum_pager($variables) {
	$tags = $variables['tags'];
	$element = $variables['element'];
	$parameters = $variables['parameters'];
	$quantity = $variables['quantity'];
	global $pager_page_array, $pager_total;

	// Calculate various markers within this pager piece:
	// Middle is used to "center" pages around the current page.
	$pager_middle = ceil($quantity / 2);
	// current is the page we are currently paged to
	$pager_current = $pager_page_array[$element] + 1;
	// first is the first page listed by this pager piece (re quantity)
	$pager_first = $pager_current - $pager_middle + 1;
	// last is the last page listed by this pager piece (re quantity)
	$pager_last = $pager_current + $quantity - $pager_middle;
	// max is the maximum page number
	$pager_max = $pager_total[$element];
	// End of marker calculations.

	// Prepare for generation loop.
	$i = $pager_first;
	if ($pager_last > $pager_max) {
		// Adjust "center" if at end of query.
		$i = $i + ($pager_max - $pager_last);
		$pager_last = $pager_max;
	}
	if ($i <= 0) {
		// Adjust "center" if at start of query.
		$pager_last = $pager_last + (1 - $i);
		$i = 1;
	}
	// End of generation loop preparation.

	$li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('« first')), 'element' => $element, 'parameters' => $parameters));
	$li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('‹ previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
	$li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('next ›')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
	$li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t('last »')), 'element' => $element, 'parameters' => $parameters));

	$li_first = $li_last = false;
	if ($pager_total[$element] > 1) {
		if ($li_first) {
			$items[] = array(
					'class' => array('pager-first'),
					'data' => $li_first,
			);
		}
		if ($li_previous) {
			$items[] = array(
					'class' => array('pager-previous'),
					'data' => $li_previous,
			);
		}

		// When there is more than one page, create the pager list.
		if ($i != $pager_max) {
			if ($i > 1) {
				$items[] = array(
						'class' => array('pager-ellipsis'),
						'data' => '…',
				);
			}
			// Now generate the actual pager piece.
			for (; $i <= $pager_last && $i <= $pager_max; $i++) {
				if ($i < $pager_current) {
					$items[] = array(
							'class' => array('pager-item'),
							'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
					);
				}
				if ($i == $pager_current) {
					$items[] = array(
							'class' => array('active'),
							'data' => '<span>' . $i . '</span>',
					);
				}
				if ($i > $pager_current) {
					$items[] = array(
							'class' => array('pager-item'),
							'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
					);
				}
			}
			if ($i < $pager_max) {
				$items[] = array(
						'class' => array('pager-ellipsis'),
						'data' => '<span>…</span>',
				);
			}
		}
		// End generation.
		if ($li_next) {
			$items[] = array(
					'class' => array('pager-next'),
					'data' => $li_next,
			);
		}
		if ($li_last) {
			$items[] = array(
					'class' => array('pager-last'),
					'data' => $li_last,
			);
		}
		return '<h2 class="element-invisible">' . t('Pages') . '</h2><div class="pagination pagination-centered">' . theme('item_list', array(
				'items' => $items,
				'attributes' => array('class' => array('')),
		)) . '</div>';
	}
}
?>