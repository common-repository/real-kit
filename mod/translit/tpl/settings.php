<div class="realkit_translit_chars">

	<?php $disabled = $field['disabled'] ? ' disabled' : ''; ?>

	<?php foreach ($field['value'] as $k => $v): ?>
		<label>
			<i><?php echo $k; ?></i>
			<input type="text" name="<?php echo $field['name']; ?>[<?php echo $k; ?>]" value="<?php echo $v; ?>"<?php echo $disabled; ?>>
		</label>
	<?php endforeach ?>

	<div class="realkit_translit_chars_note">
		<i>*</i>
		<span><?php echo __('Other characters that are not valid for the URL', 'realkit'); ?></span>
	</div>

</div>