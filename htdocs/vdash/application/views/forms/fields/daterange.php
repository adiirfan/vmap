<div class="bootstrap-daterangepicker input-group">
	<div class="input-group">
		<input type="text" name="<?php echo $name; ?>[from]" class="form-control date-input from-date"<?php echo $html_attribute; ?> value="<?php echo $field->get_value('from'); ?>" />
		<span class="input-group-addon">To</span>
		<input type="text" name="<?php echo $name; ?>[till]" class="form-control date-input till-date"<?php echo $html_attribute; ?> value="<?php echo $field->get_value('till'); ?>" />
	</div>
	
	<input type="hidden" class="system-date from-date" name="<?php echo $name; ?>[sys_from]" value="<?php echo $field->get_value('sys_from'); ?>" />
	<input type="hidden" class="system-date till-date" name="<?php echo $name; ?>[sys_till]" value="<?php echo $field->get_value('sys_from'); ?>" />
</div>