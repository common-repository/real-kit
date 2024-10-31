jQuery(document).ready(function($) {

	// Можно объединить: realkit_translit_bind_on_quick_post и realkit_translit_bind_on_quick_tag
	// добавив несколько переменных

	// Определяет какой скрипт выполнить на текущей странице
	window.realkit_translit_init = function() {

		$body = $('body');

		// Страница редактирования записи
		if ($body.hasClass('post-php')) {
			realkit_translit_bind_on_edit();
		}

		// Страница всех записей (быстрое редактирование)
		else if ($body.hasClass('edit-php')) {
			realkit_translit_bind_on_quick('post');
		}

		// Страница добавления термина
		else if ($body.hasClass('edit-tags-php')) {

			// Форма добавления
			realkit_translit_bind_on_add_term();

			// Форма быстрого редактирования
			realkit_translit_bind_on_quick('tag');

		}

		// Страница добавления термина
		else if ($body.hasClass('term-php')) {}

		// else console.error('real.Kit', 'Translit');

	}

	// Роутер для обработки быстрого редактирования
	window.realkit_translit_bind_on_quick = function(type) {
		var $triggers = $('.editinline');
		if ($triggers.length) {
			$triggers.on('click', function() {
				var $row = $(this).closest('tr');
				if ($row.length) {
					var id = $row.attr('id').replace(type + '-', '');
					if ($.isNumeric(id)) {
						if (type == 'post') {
							realkit_translit_bind_on_quick_post(id);
						}
						else if (type == 'tag') {
							realkit_translit_bind_on_quick_tag(id);
						}
					}
					else console.error('real.Kit', 'Translit');
				}
				else console.error('real.Kit', 'Translit');
			});
		}
		else console.error('real.Kit', 'Translit');
	}

	// Страница всех записей (быстрое редактирование)
	window.realkit_translit_bind_on_quick_post = function(id, cnt) {

		var cnt  = cnt || 1,
				$row = $('#edit-' + id);

		if ($row.length) {

			var $name = $row.find('input[name="post_title"]'),
					$slug = $row.find('input[name="post_name"]');

			if (!$name.length || !$slug.length) {
				console.error('real.Kit', 'Translit');
				return;
			}

			// Заодно убрать автокомплит
			$name.attr('autocomplete', 'off');
			$slug.attr('autocomplete', 'off');

			// При потере фокуса
			$slug.on('blur', function(){
				realkit_translit_ajax($name.val(), $slug.val(), function(res) {
					$slug.val(res.translit);
				});
			});

		}

		else if (cnt < 50) {
			setTimeout(function() {
				realkit_translit_bind_on_quick_post(id, ++cnt);
			}, 100);
		}

		else console.error('real.Kit', 'Translit');

	}

	// Страница всех записей (быстрое редактирование)
	window.realkit_translit_bind_on_quick_tag = function(id, cnt) {

		var cnt  = cnt || 1,
				$row = $('#edit-' + id);

		if ($row.length) {

			var $name = $row.find('input[name="name"]'),
					$slug = $row.find('input[name="slug"]');

			if (!$name.length || !$slug.length) {
				console.error('real.Kit', 'Translit');
				return;
			}

			// Заодно убрать автокомплит
			$name.attr('autocomplete', 'off');
			$slug.attr('autocomplete', 'off');

			// При потере фокуса
			$slug.on('blur', function(){
				realkit_translit_ajax($name.val(), $slug.val(), function(res) {
					$slug.val(res.translit);
				});
			});

		}

		else if (cnt < 50) {
			setTimeout(function() {
				realkit_translit_bind_on_quick_tag(id, ++cnt);
			}, 100);
		}

		else console.error('real.Kit', 'Translit');

	}

	// Страница редактирования записи
	window.realkit_translit_bind_on_edit = function(cnt) {

		var cnt    = cnt || 1,
				$title = $('.editor-post-title__input'),
				$input = $('.components-text-control__input'),
				$link  = $('.components-external-link'),
				$old   = $('#titlewrap input[name="post_title"]');

		if ($input.length && $title.length && $link.length) {

			// На всякий случай с задержкой
			setTimeout(function() {

				// Заодно убрать автокомплит
				$input.attr('autocomplete', 'off');

				// При вводе
				$input.on('input', function(){
					realkit_translit_ajax($title.text(), $input.val(), function(res) {
						var prefix = $link.find('.edit-post-post-link__link-prefix').text(),
								suffix = $link.find('.edit-post-post-link__link-suffix').text();
						$link.attr('href', prefix + res.translit + suffix);
						$link.find('.edit-post-post-link__link-post-name').text(res.translit);
					});
				});

				// При потере фокуса
				$input.on('blur', function(){
					realkit_translit_ajax($title.text(), $input.val(), function(res) {
						$input.val(res.translit);
					});
				});

			}, 50);

		}

		else if (cnt < 50) {
			setTimeout(function() {
				realkit_translit_bind_on_edit(++cnt);
			}, 100);
		}

	}

	// Страница добавления термина
	window.realkit_translit_bind_on_add_term = function() {

		var $name = $('#tag-name'),
				$slug = $('#tag-slug');

		if ($slug.length && $name.length) {

			// Заодно убрать автокомплит
			$name.attr('autocomplete', 'off');
			$slug.attr('autocomplete', 'off');

			// При вводе имени
			$name.on('input', function(){
				realkit_translit_ajax($name.val(), '', function(res) {
					$slug.val(res.translit);
				});
			});

			// При потере фокуса у слага
			$slug.on('blur', function(){
				realkit_translit_ajax($name.val(), $slug.val(), function(res) {
					$slug.val(res.translit);
				});
			});

		}

		else console.error('real.Kit', 'Translit');

	}

	window.realkit_translit_ajax = function(title, slug, callback) {
		$.post(ajaxurl, {
			action: 'realkit_translit_get',
			cyrillic: (slug == '') ? title : slug
		}, function(res) {
			if (res.status) {
				if (typeof callback == 'function') {
					callback(res);
				}
				else console.error('real.Kit', 'Translit');
			}
			else console.error('real.Kit', 'Translit');
		});
	}

	realkit_translit_init();

});