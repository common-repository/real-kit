jQuery(document).ready(function($) {

  // Транслит
  (function(){

    let $from = $('.realkit_translit_generator input[name="source"]'),
        $to   = $('.realkit_translit_generator input[name="translit"]');

    if (!$from.length || !$to.length) return;

    $from.on('input', function() {
      let repeat = setInterval(function() {
        $to.val($to.val() + '.');
      }, 800);
      realkit_translit_ajax($from.val(), '', function(res) {
        clearTimeout(repeat);
        $to.val(res.status ? res.translit : '');
      });
    });

  })();

  // Копировать в буфер
  (function(){

    let $label = $('.realkit_translit_generator_result'),
        $input = $label.find('input');

    if (!$label.length || !$input.length) return;

    $label.on('click', function() {
      if ($input.val()) {

        $input.select();
        document.execCommand('copy');
        document.getSelection().removeAllRanges();

        $label.addClass('pushed');
        setTimeout(function() {
          $label.removeClass('pushed');
        }, 500);

      }
    });

  })();

});