<?php

// Запомнить и больше НЕ показывать сообщение (когда юзер нажал на одну из кнопок)
if (isset($_GET['realkit_translit_hide_notice']) or isset($_GET['realkit_translit_convert'])) {
	update_option('realkit_translit_hide_notice', TRUE);
}

// Восстановить правила по умолчанию
if (get_option('realkit_translit_toggle_default') == 'on') {
	update_option('realkit_translit_rules', Realkit_translit::get_rules_default());
	update_option('realkit_translit_toggle_default', 'off');
}

// Преобразовать существующие
if (get_option('realkit_translit_toggle_convert') == 'on') {

	global $wpdb;

	$cnt = 0;

	// Записи
	$posts = $wpdb->get_results("SELECT ID, post_name, post_title, post_type FROM {$wpdb->posts} WHERE post_type != 'attachment'");
	foreach ((array) $posts as $post) {

		$name = empty($post->post_name) ? $post->post_title : $post->post_name;
		$slug = Realkit_translit::convert($name);

		if ($slug != $post->post_name) {
			$updated = $wpdb->update(
				$wpdb->posts,
				array('post_name' => $slug),
				array('ID' => $post->ID),
				array('%s'),
				array('%d')
			);
			if ($updated) {
				$cnt++;
			}
		}

	}

	// Таксономии
	$terms = $wpdb->get_results("SELECT term_id, slug FROM {$wpdb->terms}");
	foreach ((array) $terms as $term) {

		$slug = Realkit_translit::convert($term->slug);

		if ($slug != $term->slug) {
			$updated = $wpdb->update(
				$wpdb->terms,
				array('slug' => $slug),
				array('term_id' => $term->term_id),
				array('%s'),
				array('%d')
			);
			if ($updated) {
				$cnt++;
			}
		}

	}

	// Сообщение об успешной перегенерации
	realkit_admin_notice('
		<p>' . sprintf(__('Converted slugs: %d', 'realkit'), $cnt) . '</p>
	', 'success', TRUE);

	update_option('realkit_translit_toggle_convert', 'off');

}