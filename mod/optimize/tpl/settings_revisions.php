<div class="realkit_settings_sub_group">
	<h3><?php echo __('Revisions', 'realkit'); ?></h3>
	<p><?php echo __('Every time you update a post/page, WordPress creates a new row in the database (and store it for 7 days). This makes it possible, if necessary, to restore any of the revisions. But the more rows in the database - the slower the site.', 'realkit'); ?></p>
	<label>
		<input type="number" name="<?php echo $field['name']; ?>" value="<?php echo $field['value']; ?>">
		<span><?php echo $field['title']; ?></span>
		<div class="realkit_settings_optimize_vaiant">
			<code>-1</code>
			<span> - <?php echo __('infinite (default)', 'realkit'); ?></span>
		</div>
		<div class="realkit_settings_optimize_vaiant">
			<code>&nbsp;0</code>
			<span> - <?php echo __('off', 'realkit'); ?></span>
		</div>
	</label>
</div>