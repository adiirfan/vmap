<?php
$CI =& get_instance();

$CI->template->set_css('~/css/bootstrap-table.css');

if ( $has_data ) {
	// Calculate the total columns.
	$total_columns = $listing->get_total_column_weight();
	$total_width = 12;
	$width_occupied = 0;
	$column_widths = array();
	$last_header = end($headers);
	$last_id = $last_header['id'];
	
	// Calculate the showing results.
	$total_records = $listing->get_total_records();
	$current_page = $listing->get_current_page();
	$rpp = $listing->get_per_page();
	$current_index = ($current_page - 1) * $rpp;
	$current_number = $current_index + 1;
	$next_number = $current_index + $rpp;
	
	if ( $next_number > $total_records ) {
		$next_number = $total_records;
	}
	
	echo _lang('_listing_show_results', $current_number, $next_number, $total_records);
	
	// Print the header.
	echo '<div class="bootstrap-table">';
	echo '<div class="row header-row visible-md visible-lg">';
	
	foreach ( $headers as $header ) {
		$id = $header['id'];
		$col_width = 1;
		$label = $header['label'];
		$sort_link = $header['sort_link'];
		
		if ( $id != $last_id ) {
			$width = $listing->get_column_weight($id);
			
			$ratio = $width / $total_columns;
			
			$col_width = round($ratio * $total_width);
			
			$column_widths[] = $col_width;
			
			$width_occupied += $col_width;
		} else {
			$col_width = $total_width - $width_occupied;
			
			$column_widths[] = $col_width;
			
			$total_width = 0;
		}
		
		if ( !is_empty($sort_link) ) {
			$current_sort = strtolower($header['current_sort']);
			
			if ( $listing->is_sort_applied($id) ) {
				$sort_class = ($current_sort == 'asc' ? 'fa fa-sort-amount-asc' : 'fa fa-sort-amount-desc');
			} else {
				$sort_class = '';
			}
			
			$label = '<a href="' . $sort_link . '" class="' . $current_sort . '"><i class="' . $sort_class . '"></i> ' . $label . '</a>';
		}
		
		echo '<div class="col-md-' . $col_width . ' cell">';
		echo $label;
		echo '</div>';
	}
	
	echo '</div>';
	
	// Done, now let's print the data.
	echo '<div class="data-rows">';
	
	foreach ( $data as $row_index => $row ) {
		if ( iterable($row) ) {
			$class = ($row_index % 2 ? 'odd' : 'even');
			
			echo '<div class="row data-row ' . $class . '">';
			
			foreach ( $row as $column_index => $column_data ) {
				echo '<div class="col-md-' . $column_widths[$column_index] . ' cell">';
				if ( !is_empty($column_data) ) {
					echo '<span class="column-label visible-sm-block visible-xs-block">' . $headers[$column_index]['label'] . ': </span>';
				}
				echo '<span class="column-data">' . $column_data . '</span>';
				echo '</div>';
			}
			
			echo '</div>';
		}
	}
	
	echo '</div>';
	
	if ( isset($pagination) && !is_empty($pagination) ) {
		echo '<div class="pagination">';
		echo $pagination;
		echo '</div>';
	}
	
	echo '</div>';
} else {
	echo '<div class="text-danger">';
	echo lang('_listing_no_records');
	echo '</div>';
}