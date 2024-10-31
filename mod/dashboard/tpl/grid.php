<div class="realkit_dashboard_info">
	<div class="realkit_dashboard_info_desc"><?php echo __('Information about current, active and published data', 'realkit'); ?></div>
	<div class="realkit_dashboard_info_sep"></div>
	<?php foreach ($data as $item) : ?>
		<?php if (empty($item)) : ?>
			<div class="realkit_dashboard_info_sep"></div>
		<?php else : ?>
			<?php if (isset($item['href'])) : ?>
				<a href="<?php echo $item['href']; ?>" class="realkit_dashboard_info_row">
			<?php else : ?>
				<div class="realkit_dashboard_info_row">
			<?php endif; ?>
				<div class="realkit_dashboard_info_row_title">
					<?php echo $item['title']; ?>
				</div>
				<div class="realkit_dashboard_info_row_value">
					<?php echo $item['value']; ?>
				</div>
			<?php if (isset($item['href'])) : ?>
				</a>
			<?php else : ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	<?php endforeach; ?>
</div>