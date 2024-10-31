<?php if (isset($thumbnail_id) and isset($thumbnail_url)): ?>
	<tr class="form-field realkit_taxonomy_thumbnail_edit">
		<th scope="row" valign="top">
			<label for="realkit_thumbnail_url">
				<?php echo __('Thumbnail', 'realkit'); ?>
				<?php if (isset($src) and !empty($src)) : ?>
					<br>
					<img src="<?php echo $src; ?>">
				<?php endif ?>
			</label>
		</th>
		<td>
			<input type="hidden" name="realkit_thumbnail_id" value="<?php echo $thumbnail_id; ?>">
			<input type="text" name="realkit_thumbnail_url" id="realkit_thumbnail_url" value="<?php echo $thumbnail_url; ?>">
			<button type="button" class="button realkit_select_thumbnail"><?php echo __('Select'); ?></button>
			<button type="button" class="button realkit_remove_thumbnail"><?php echo __('Remove'); ?></button>
			<p class="description"><?php echo sprintf(__('To get the path of the thumbnail, use the PHP function: %s', 'realkit'), '<br><b>realkit_term_thumbnail($term_id, $size)</b>'); ?></p>
		</td>
	</tr>
<?php endif ?>