<?php

// В админке
if (is_admin()) {

	add_action('registered_taxonomy', function($taxonomy, $object_type, $args) {

		if (!in_array($taxonomy, ['category', 'post_tag'])) return;

		// Добавить поле на странице редактирования
		add_action($taxonomy . '_edit_form_fields', function($tag, $taxonomy) {

			$custom  = get_term_meta($tag->term_id, 'realkit_categories_posts_per_page', TRUE);
			$default = get_option('posts_per_page');

			require REALKIT_PLUGIN_DIR_MOD . '/categories/tpl/field_edit.php';

		}, 10, 2);

		// Сохранить при редактировании таксономии
		add_action('edited_' . $taxonomy, function($term_id, $tt_id) {

			$name = 'realkit_categories_posts_per_page';

			if (!isset($_POST[$name])) return;

			$can_add   = isset($_POST['_wpnonce_add-tag'])
								 ? wp_verify_nonce($_POST['_wpnonce_add-tag'], 'add-tag')
								 : FALSE;
			$can_edit  = isset($_POST['_wpnonce'])
								 ? wp_verify_nonce($_POST['_wpnonce'], 'update-tag_' . $term_id)
								 : FALSE;
			$can_quick = isset($_POST['_inline_edit'])
								? wp_verify_nonce($_POST['_inline_edit'], 'taxinlineeditnonce')
								: FALSE;

			if (!$can_add && !$can_edit && !$can_quick) return;

			$val = intval($_POST[$name]);

			if (!$val) {
				delete_term_meta($term_id, $name);
			}
			else {
				update_term_meta($term_id, $name, $val);
			}

			return $term_id;

		}, 10, 2);

	}, 10, 3);

}

// На сайте
else {

	// Задать лимит
	add_filter('pre_get_posts', function() {

	  if (is_admin()) return;

	  global $wp_query;

	  // $cat_slug = $wp_query->tax_query->queries[0]['terms'][0];
	  $cat_title = single_cat_title('', FALSE);
	  $cat = get_term_by('name', $cat_title, 'category', ARRAY_A);
	  $ppp = $cat ? get_term_meta($cat['term_id'], 'realkit_categories_posts_per_page', TRUE) : FALSE;

    if (is_numeric($ppp)) {
      $wp_query->set('posts_per_page', $ppp);
    }

	});

}