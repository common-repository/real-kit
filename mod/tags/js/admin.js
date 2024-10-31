jQuery(document).ready(function($) {

  (function(){

    let $tags_boxes = $('.tagsdiv');

    if (!$tags_boxes.length) return;

    // Для всех типов меток
    $tags_boxes.each(function (i, e) {

      let $e      = $(e),
          $box    = $e.closest('.postbox'),
          $input  = $box.find('input.newtag'),
          $button = $box.find('input.tagadd'),
          $inside = $box.find('.inside');

      if (!$input.length || !$button.length || !$inside.length) return;

      // Получить все метки
      $.ajax({
        url:  window.ajaxurl,
        type: 'POST',
        dataType: 'JSON',
        data: {
          'action':   'realkit_ajax_get_all_tags',
          'taxonomy': $e.attr('id')
        },
        success: function(res) {
          if (res) {

            let $list  = $('<div class="realkit_tags"></div>'),
                $added = $box.find('.ntdelbutton');

            $.each(res, function(index, val) {

              let $btn = $('<button type="button" class="button button-small">' + val + '</button>');

              // Добавить метку и скрыть кнопку добавления
              $btn.on('click', function() {
                $input.val($btn.text());
                $button.click();
                $btn.addClass('realkit_tag_active');
                return false;
              });

              // Скрыть кнопки добавления ранее присвоенных меток
              if ($added.length) {
                $added.each(function (i, e) {
                  if (e.parentNode.lastChild.textContent == val) {
                    $btn.addClass('realkit_tag_active');
                    return;
                  }
                });
              }

              $list.append($btn);

            });

            $inside.append($list);

          }
        }
      });

    });

    // При клике на кнопку удаления метки
    $(document).on('mousedown', '.ntdelbutton', function(e) {

      let $box      = $(this).closest('.postbox'),
          $active   = $box.find('.realkit_tag_active'),
          tag_title = this.parentNode.lastChild.textContent;

      // Найти и показать кнопку добавления удаленной метки
      if ($active.length) {
        $active.each(function (i, e) {
          let $e = $(e);
          if ($e.text() == tag_title) {
            $e.removeClass('realkit_tag_active');
          }
        });
      }


    });

  })();
});