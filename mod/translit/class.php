<?php

class Realkit_translit {

	public static function convert($title, $raw_title = '', $context = '') {

		$rules  = self::get_rules();

		$title = urldecode($title);

		// Сущьности в символы
		$title = htmlspecialchars_decode($title);

		// В нижний регистр
		$title = mb_strtolower($title);

		// Транслитерация
		$title = strtr($title, self::get_rules());

		// Заменить все лишние символы на дефис
		$title = preg_replace('~[^a-z0-9\_\-\.]+~u', $rules['*'], $title);

		// Удалить больше одного дефиса подряд
		$title = preg_replace('~[-]+~u', $rules['*'], $title);

		// Удалить начальные и конечные дефисы
		$title = trim($title, $rules['*'] . '-._');

		return $title;

	}

	//
	public static function get_rules() {

		$rules = get_option('realkit_translit_rules');

		if (!$rules) {
			$rules = self::get_rules_default();
		}

		return $rules;

	}

	//
	public static function get_rules_default() {

		$rules = [
			'а' => 'a',  'б' => 'b',  'в' => 'v',  'г' => 'g',  'д' => 'd',  'е' => 'e',  'ё' => 'yo',
			'ж' => 'zh', 'з' => 'z',  'и' => 'i',  'й' => 'j',  'к' => 'k',  'л' => 'l',  'м' => 'm',
			'н' => 'n',  'о' => 'o',  'п' => 'p',  'р' => 'r',  'с' => 's',  'т' => 't',  'у' => 'u',
			'ф' => 'f',  'х' => 'h',  'ц' => 'c',  'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shh','ъ' => '',
			'ы' => 'y',  'ь' => '',   'э' => 'e',  'ю' => 'yu', 'я' => 'ya',
			'є' => 'ye', 'ѓ' => 'g',  'і' => 'i',  'ї' => 'yi',
			'_' => '_',  '-' => '-',  '*' => '-'
		];

		return $rules;

	}

}