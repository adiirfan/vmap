<?php if ( $has_data ): ?>
<table class="list">
	<thead>
		<tr>
			<?php
			foreach ( $headers as $header ) {
				$label = $header['label'];
				$sort_link = $header['sort_link'];
				$current_sort = $header['current_sort'];
				
				echo '<th>';
				if ( !is_empty($sort_link) ) {
					echo '<a href="' . $sort_link . '">' . $label . '</a>';
				} else {
					echo $label;
				}
				echo '</th>';
			}
			?>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ( $data as $row ) {
			echo '<tr>';
			foreach ( $row as $value ) {
				echo '<td>' . $value . '</td>';
			}
			echo '</tr>';
		}
		?>
	</tbody>
</table>

<br />
<div class="pagination">
	<?php echo $pagination; ?>
</div>
<?php else: ?>
<p class="error"><?php echo lang('_listing_no_records'); ?></p>
<?php endif; ?>