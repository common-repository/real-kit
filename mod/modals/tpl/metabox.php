<label>
	<span><?php echo __('Text', 'realkit'); ?></span>
	<input type="text" name="realkit_modals_shortcode_text" value="<?php echo $text; ?>" autocomplete="off">
</label>
<label>
	<span><?php echo __('id', 'realkit'); ?></span>
	<input type="text" name="realkit_modals_shortcode_id" value="<?php echo $id; ?>" autocomplete="off">
</label>
<label>
	<span><?php echo __('class', 'realkit'); ?></span>
	<input type="text" name="realkit_modals_shortcode_class" value="<?php echo $class; ?>" autocomplete="off">
</label>
<p><b><?php echo __('Button shortcode:', 'realkit'); ?></b></p>
<p class="realkit_modals_shortcode_cover">[modal open="<?php echo $post->ID; ?>"<i class="realkit_modals_shortcode_id"><?php echo $attr_id; ?></i><i class="realkit_modals_shortcode_class"><?php echo $attr_class; ?></i>]<i class="realkit_modals_shortcode_text"><?php echo $text; ?></i>[/modal]</p>
<label class="checkbox">
	<input type="checkbox" name="realkit_modals_if_need_only"<?php echo ($smart ? ' checked' : ''); ?>>
	<div><?php echo __('Generate this window only if there is a shortcode on the page to open it', 'realkit'); ?></div>
</label>