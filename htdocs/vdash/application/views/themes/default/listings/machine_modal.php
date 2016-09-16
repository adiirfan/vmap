<?php
$CI =& get_instance();

$CI->template->set_css('~/css/bootstrap-table.css');

if ( $has_data ) {
	$query = $listing->get_query();
	$result = $query->result_array();
?>
<?php foreach ( $result as $machine ): ?>
<div class="block" data-machine-id="<?php echo $machine['machine_id']; ?>">
	<div class="block-inner">
		<div class="block-avatar">
			<i class="fa fa-desktop"></i>
		</div>
		<div class="block-detail">
			<div class="block-title"><?php echo $machine['machine_name']; ?></div>
			<div class="block-info">
				<div class="block-info-row">
					<div class="block-info-label"><?php echo lang('machine_ip_address'); ?></div>
					<div class="block-info-data"><?php echo $machine['machine_ip_address']; ?></div>
				</div>
				<div class="block-info-row">
					<div class="block-info-label"><?php echo lang('machine_mac_address'); ?></div>
					<div class="block-info-data"><?php echo $machine['machine_mac_address']; ?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endforeach; ?>
<?php
} else {
	echo '<div class="text-danger">';
	echo lang('_listing_no_records');
	echo '</div>';
}