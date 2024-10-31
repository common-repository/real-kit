<?php

if (is_admin()) {

	// Добавить обработку ajax (при ручном редактировании)
	add_action('wp_ajax_realkit_translit_get', function() {

		if (!isset($_POST['cyrillic'])) {
			$ret['status'] = FALSE;
		}
		else {
			$ret = array(
				'status'   => TRUE,
				'translit' => Realkit_translit::convert($_POST['cyrillic'])
			);
		}

		header('Content-Type: application/json');

		echo json_encode($ret, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT);

		wp_die();

	});

}