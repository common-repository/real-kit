<?php

$del_autosaves = get_option('realkit_optimize_autosaves_delete') == 'on';
$del_revisions = get_option('realkit_optimize_revisions_delete') == 'on';

// Удалить ВСЕ ревизии (в т.ч. и автосохранения)
if ($del_autosaves and $del_revisions) {

	global $wpdb;

	$cnt = $wpdb->query("DELETE FROM $wpdb->posts WHERE `post_type` = 'revision'");

	// Сообщение об успешном удалении
	if (is_numeric($cnt)) {
		realkit_admin_notice('<p>' . sprintf(__('Revisions removed: %d', 'realkit'), $cnt) . '</p>', 'success', TRUE);
	}

	update_option('realkit_optimize_revisions_delete', 'off');
	update_option('realkit_optimize_autosaves_delete', 'off');

}

// Удалить существующие ревизии
elseif ($del_revisions) {

	global $wpdb;

	$cnt = $wpdb->query("DELETE FROM $wpdb->posts WHERE `post_name` LIKE '%-revision-%'");

	update_option('realkit_optimize_revisions_delete', 'off');

	// Сообщение об успешном удалении
	if (is_numeric($cnt)) {
		realkit_admin_notice('<p>' . sprintf(__('Revisions removed: %d', 'realkit'), $cnt) . '</p>', 'success', TRUE);
	}

}

// Удалить существующие автосэйвы
elseif ($del_autosaves) {

	global $wpdb;

	$cnt = $wpdb->query("DELETE FROM $wpdb->posts WHERE `post_name` LIKE '%-autosave-%'");

	update_option('realkit_optimize_autosaves_delete', 'off');

	// Сообщение об успешном удалении
	if (is_numeric($cnt)) {
		realkit_admin_notice('<p>' . sprintf(__('Autosaves removed: %d', 'realkit'), $cnt) . '</p>', 'success', TRUE);
	}

}