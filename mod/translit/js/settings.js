jQuery(document).ready(function($) {

  // Активирует поля с кастомными правилами
	(function(){

		var $toggle = $('input[name="realkit_translit_toggle"]'),
				$target = $toggle.closest('.realkit_settings_group').find('input').not('input[name="realkit_translit_toggle"]');

		if (!$toggle.length || !$target.length) {
			console.error('real.Kit', 'Translit');
			return;
		}

		$toggle.on('change', function() {
			if ($toggle.is(':checked')) {
				$target.removeAttr('disabled').prop('disabled', false);
			}
			else {
				$target.attr('disabled', 'disabled').prop('disabled', true);
			}
		});

	})();

});