jQuery(document).ready(function($) {

	var $metabox = $('#realkit_modals_shortcode');

	// Формировать атрибуты шорткода
	$metabox.find('input').on('input', function() {

		var $input = $(this),
				value  = $input.val();

		if (value != '') {
			if ($input.attr('name') == 'realkit_modals_shortcode_id') {
				value = ' id="' + value + '"';
			}
			else if ($input.attr('name') == 'realkit_modals_shortcode_class') {
				value = ' class="' + value + '"';
			}
		}

		$metabox.find('.' + $input.attr('name')).text(value);

	});

	// Копировать в буфер
	$('.realkit_modals_shortcode_cover').on('click', function() {

		var $this = $(this),
				$temp = $('<input>');

		$('body').append($temp);
		$temp.val($this.text()).select();
		document.execCommand('copy');
		$temp.remove();

		$this.addClass('pushed');
		setTimeout(function() {
		  $this.removeClass('pushed');
		}, 500);

	});

});