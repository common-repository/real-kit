jQuery(document).ready(function($) {

  // Активирует поле с html
	(function(){

		var $input = $('input[name="realkit_maintenance_toggle"]'),
				$texta = $('textarea[name="realkit_maintenance_html"]');

		if (!$input.length || !$texta.length) {
			console.error('real.Kit', 'Maintenance');
			return;
		}

		$input.on('change', function() {
			if ($input.is(':checked')) {
				$texta.removeAttr('disabled').prop('disabled', false);
			}
			else {
				$texta.attr('disabled', 'disabled').prop('disabled', true);
			}
		});

	})();

});