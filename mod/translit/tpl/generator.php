<div class="wrap">
	<div class="realkit_translit_generator">

		<h1><?php echo __('Translit', 'realkit'); ?></h1>

		<form action="" method="post">
			<label>
				<div><?php echo __('Cyrillic', 'realkit'); ?>:</div>
				<input type="text" name="source">
			</label>
			<label class="realkit_translit_generator_result">
				<div><?php echo __('Translit', 'realkit'); ?>:</div>
				<input type="text" name="translit" readonly title="<?php echo __('Click to copy', 'realkit') ?>">
			</label>
		</form>

	</div>
</div>