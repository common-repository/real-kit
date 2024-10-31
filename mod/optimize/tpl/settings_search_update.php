<div class="realkit_settings_sub_group">
	<h3><?php echo __('Updates', 'realkit'); ?></h3>
	<p><?php echo __('Each time, when any admin panel page is loading, WordPress, at different intervals (depending on the specific page), search for updates core, themes and plugins. In some situations, this greatly slows down the loading of the admin panel pages.', 'realkit'); ?></p>
	<p><?php echo __('In addition, the search for updates runs once an hour in the background, which does not affect the speed of page loading.', 'realkit'); ?></p>
	<label>
		<input type="checkbox" name="<?php echo $field['name']; ?>" value="on" class="realkit_checkbox"<?php checked('on', $field['value']); ?><?php echo $disabled; ?>>
		<?php if ($field['value'] == 'off') : ?>
			<input type="hidden" name="<?php echo $field['name']; ?>" value="off">
		<?php endif; ?>
		<span><?php echo $field['title']; ?></span>
	</label>
</div>