<?php if (isset($thumbnail_id) and isset($thumbnail_url)): ?>
	<fieldset class="realkit_taxonomy_thumbnail_quick">
		<div class="thumb inline-edit-col">
			<label>
				<span class="title"><?php echo __('Thumbnail', 'realkit'); ?></span>
				<span class="input-text-wrap">
					<input type="hidden" name="realkit_thumbnail_id" value="<?php echo $thumbnail_id; ?>">
					<input type="text" name="realkit_thumbnail_url" value="<?php echo $thumbnail_url; ?>">
					<button type="button" class="button realkit_select_thumbnail"><?php echo __('Select', 'realkit'); ?></button>
					<button type="button" class="button realkit_remove_thumbnail"><?php echo __('Remove', 'realkit'); ?></button>
				</span>
			</label>
		</div>
	</fieldset>
<?php endif ?>