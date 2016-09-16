<img src="http://<?php echo $_SERVER['HTTP_HOST'];?>/images/vmap_logo_grey.png" width="100px" style="padding-top: 5px; padding-bottom: 10px;" data-pin-nopin="true">
<?php if ( $page_title && !is_empty($page_title) ): ?>
<h1 class="page-title" style="text-align:center;"><?php echo $page_title; ?></h1>
<?php endif; ?>

<?php if ( isset($header) && iterable($header) ): ?>
<?php $colspan = sizeof($header); ?>
<!--div id="piechart" style="width: 900px; height: 500px;"></div!-->
<table class="list-table">
	<thead>
		<tr>
			<?php foreach ( $header as $header_text ): ?>
			<th><?php echo htmlentities($header_text); ?></th>
			<?php endforeach; ?>
		</tr>
	</thead>
	<?php if ( isset($data) && iterable($data) ): ?>
		<?php foreach ( $data as $index => $row ): ?>
			<tr class="<?php echo ($index % 2 ? 'odd' : 'even'); ?>">
			<?php foreach ( $row as $col ): ?>
				<td><?php echo htmlentities($col); ?></td>
			<?php endforeach; ?>
			</tr>
		<?php endforeach; ?>
	<?php else: ?>
	<tr>
		<td colspan="<?php echo $colspan; ?>">
			<p class="text-danger"><?php echo lang('txt_no_user_list'); ?></p>
		</td>
	</tr>
	<?php endif; ?>
</table>
<?php endif; ?>

<p class="text-summary">

	Total records: <?php echo sizeof($data); ?>
</p>