<?php

// Получает URL миниатюры таксономии (для использования в теме)
function realkit_term_thumbnail($term_id = null, $size = null) {
	return Realkit_thumbnails::get_term_thumbnail($term_id, $size);
}

// Deprecated (from 5.0.0)
function realkit_taxonomy_thumb($term_id = null, $size = null) {
	return realkit_term_thumbnail($term_id, $size);
}