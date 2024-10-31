<div class="wrap">
	<div class="realkit_settings">

		<h1><?php echo __('real.Kit', 'realkit'); ?></h1>

		<div class="notice notice-info">
			<div class="realkit_settings_donate">
				<?php echo sprintf(__('I would be very grateful for any %s support %s !', 'realkit'), '<a href="https://donate.qiwi.com/payin/Realist" target="_blank">', '</a>'); ?>
			</div>
		</div>

		<form action="options.php" method="POST">

			<?php settings_fields(REALKIT_PLUGIN_SETTINGS); ?>

			<?php $settings = realkit_settings(); ?>
			<?php foreach ($settings['order'] as $oredr => $groups) : ?>
				<?php foreach ($groups as $group_name) : ?>
					<?php $group = $settings['groups'][$group_name]; ?>
					<div class="realkit_settings_group">

						<?php if (!empty($group['title'])) : ?>
							<div class="realkit_settings_group_title">
								<h2><?php echo $group['title']; ?></h2>
							</div>
						<?php endif; ?>

						<?php if (!empty($group['desc'])) : ?>
							<div class="realkit_settings_group_desc">
								<p><?php echo $group['desc']; ?></p>
							</div>
						<?php endif; ?>

						<?php if (!empty($group['fields'])) : ?>
							<div class="realkit_settings_group_fields<?php echo empty($group['class']) ? '' : ' ' . $group['class']; ?>">
								<?php foreach ($group['fields'] as $field) : ?>

									<?php $disabled = $field['disabled'] ? ' disabled' : ''; ?>

									<?php if (isset($field['desc']) and !empty($field['desc'])): ?>
										<div>
											<p><?php echo $field['desc']; ?></p>
										</div>
									<?php endif ?>

									<?php // checkbox ?>
									<?php if ($field['type'] == 'checkbox') : ?>

										<label>
											<input type="checkbox" name="<?php echo $field['name']; ?>" value="on" class="realkit_checkbox"<?php checked('on', $field['value']); ?><?php echo $disabled; ?>>
											<?php if ($field['value'] == 'off') : ?>
												<input type="hidden" name="<?php echo $field['name']; ?>" value="off">
											<?php endif; ?>
											<span><?php echo $field['title']; ?></span>
										</label>

									<?php // textarea ?>
									<?php elseif ($field['type'] == 'textarea') : ?>
										<textarea name="<?php echo $field['name']; ?>"<?php echo $disabled; ?>><?php echo $field['value']; ?></textarea>

									<?php // custom ?>
									<?php elseif (file_exists($field['type'])) : ?>

										<?php require $field['type']; ?>

									<?php endif; ?>

								<?php endforeach; ?>
							</div>
						<?php endif; ?>

					</div>
				<?php endforeach; ?>
			<?php endforeach; ?>

			<?php submit_button(); ?>

		</form>

	</div>
</div>