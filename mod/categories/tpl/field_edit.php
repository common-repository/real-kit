<tr class="form-field realkit_taxonomy_category_edit">
	<th scope="row" valign="top">
		<label for="realkit_categories_posts_per_page">
			<?php echo __('Posts per page', 'realkit'); ?>
		</label>
	</th>
	<td>
		<input type="text" name="realkit_categories_posts_per_page" id="realkit_categories_posts_per_page" value="<?php echo $custom ?>">
		<p class="description"><?php echo __('By default for all categories', 'realkit') . ': ' . $default; ?></p>
	</td>
</tr>