jQuery(document).ready(function($) {

	// Клик по названию опции (для дефолтной верстки)
	/*(function(){
		$('.realkit_settings .form-table th').on('click', function() {
			$(this).next('td').find('input').trigger('click');
		});
	})();*/

  // Фикс, чтоб в БД сохранялись НЕ отмеченные чекбоксы (со значением "off")
  $('.realkit_settings input[type="checkbox"]').on('change', function() {
  	var $checkbox = $(this);
  	if ($checkbox.is(':checked')) {
  		$checkbox.next('input').remove();
  	}
  	else {
  		$checkbox.after('<input type="hidden" name="' + $checkbox.attr('name') + '" value="off">');
  	}
  });

});