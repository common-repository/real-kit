<div class="realkit_settings_sub_group">
	<h3><?php echo __('Emojis', 'realkit'); ?></h3>
	<p><?php echo __('WordPress connects to the site additional scripts and styles needed to display Emoji. After disabling them, you will see the usual smiles, but in some browsers (eg IE) they will be black and white.', 'realkit'); ?></p>
	<label>
		<input type="checkbox" name="<?php echo $field['name']; ?>" value="on" class="realkit_checkbox"<?php checked('on', $field['value']); ?><?php echo $disabled; ?>>
		<?php if ($field['value'] == 'off') : ?>
			<input type="hidden" name="<?php echo $field['name']; ?>" value="off">
		<?php endif; ?>
		<span><?php echo $field['title']; ?></span>
	</label>
</div>