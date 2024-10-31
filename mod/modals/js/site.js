jQuery(document).ready(function($) {

	// Открытие
	(function(){

		var $trigs = $('.realkit_modal_open');

		if (!$trigs.length) return;

		$trigs.each(function() {
			var $trig = $(this);
			$trig.on('click', function() {
				realkit_modals_open($trig.attr('realkit_modal_target'));
				return false;
			});
		});

	})();

	// Закрытие
	(function(){

		var $trigs = $('.realkit_modal_close');

		if (!$trigs.length) return;

		$trigs.on('click', function() {
			realkit_modals_close();
		});

	})();

	function realkit_modals_open(target_id) {

		var target  = $(target_id),
				content = target.find('.realkit_modal_window'),
				win     = $(window);

		if (target.length == 0 || content.length == 0) return false;

		// Закрыть открытое окно
		realkit_modals_close();

		// Показать окно
		target.css('visibility', 'visible').animate({
			'opacity': 1
		}, 300, function() {
			$(this).addClass('opened');
		});

		// Закрыть по клику на подложку
		target.on('click', function(event) {
			if ($(event.target).hasClass('realkit_modal')) realkit_modals_close();
			return true;
		});

		// Закрыть по нажатию клавиши "Esc"
		win.on('keyup', function(event) {
			if (event.which === 27) realkit_modals_close();
		});

	}

	function realkit_modals_close() {

		var $targ = $('.realkit_modal.opened');

		if (!$targ.length) return false;

		$targ.animate({
			'opacity': 0
		}, 200, function() {
			$(this).css('visibility', 'hidden').removeClass('opened');
		});

	}

});