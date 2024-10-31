jQuery(document).ready(function($) {

	// Клик по кнопке "Выбрть" (выбор файла из галереи или его загрузка)
	(function(){

		var $trig = $('.realkit_select_thumbnail');

		if (!$trig.length) return;

		$trig.on('click', function(event) {

			var $btn = $(this),
					frame;

			event.preventDefault();

			if (frame) { frame.open(); return; }

			frame = wp.media();
			frame.on('select', function() {

				var attach = frame.state().get('selection').first(),
						$cover = $btn.parent();

				$cover.find('input[name="realkit_thumbnail_id"]').val(attach.id);
				$cover.find('input[name="realkit_thumbnail_url"]').val(attach.attributes.url);

				frame.close();

			});

			frame.open();

		});

	})();

	// Клик по кнопке "Удалить"
	(function(){

		var $trig = $('.realkit_remove_thumbnail');

		if (!$trig.length) return;

		$trig.on('click', function() {
			var $cover = $(this).parent();
			$cover.find('input[name="realkit_thumbnail_id"]').val('');
			$cover.find('input[name="realkit_thumbnail_url"]').val('');
			return false;
		});

	})();

	// Клик по всплывающей кнопке "Свойства" (быстрое редактирование)
	// Подставить адрес миниатюры в поле редактирования
	(function(){

		var $trig = $('.editinline');

		if (!$trig.length) return;

		$trig.on('click', function() {

			var $tr  = $(this).closest('tr'),
					$img = $tr.find('.realkit_column_thumbnail img'),
					id   = $img.attr('thumbnail-id'),
					url  = $img.attr('thumbnail-url');

			setTimeout(function() {
				$('.inline-editor input[name="realkit_thumbnail_id"]').val(id);
				$('.inline-editor input[name="realkit_thumbnail_url"]').val(url);
			}, 100);

		});

	})();

});