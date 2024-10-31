<div class="form-field realkit_taxonomy_thumbnail_add">
	<label for="realkit_thumbnail_url"><?php echo __('Thumbnail', 'realkit'); ?></label>
	<input type="hidden" name="realkit_thumbnail_id" value="">
	<input type="text" name="realkit_thumbnail_url" id="realkit_thumbnail_url" value="">
	<button type="button" class="button realkit_select_thumbnail"><?php echo __('Select'); ?></button>
	<button type="button" class="button realkit_remove_thumbnail"><?php echo __('Remove'); ?></button>
	<p><?php echo sprintf(__('To get the path of the thumbnail, use the PHP function: %s', 'realkit'), '<br><b>realkit_term_thumbnail($term_id, $size)</b>'); ?></p>
</div>