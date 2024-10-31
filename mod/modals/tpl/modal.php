<?php if (isset($modal) and is_object($modal)) : ?>

  <div id="realkit_modal_<?php echo $modal->ID; ?>" class="realkit_modal">
    <div class="realkit_modal_window">
      <div class="realkit_modal_content">
        <?php echo apply_filters('the_content', $modal->post_content); ?>
      </div>
      <div class="realkit_modal_close"></div>
    </div>
  </div>

<?php endif; ?>