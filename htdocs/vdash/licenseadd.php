<div class="box">
	
	<h2 class="page-title">Submit Your License</h2>
	
	
	<form class="form-horizontal flexiwidth" role="form" name="business_form" action="http://<?php echo $_SERVER['HTTP_HOST'];?>/vdash/test.php" method="post" enctype="application/x-www-form-urlencoded" data-toggle="validator">



	<div class="form-group">
		<label for="business-name" class="col-sm-2 control-label" data-toggle="tooltip" data-placement="top" title="" data-original-title="The company or business name.">
			<span class="required">*</span> 			License ID					<i class="glyphicon glyphicon-question-sign"></i>
					</label>
		<div class="col-sm-10">
			<input type="text" name="name" value="" id="name" class="form-control form-control" size="50">			
						
			<div class="help-block with-errors"></div>
		</div>
	</div>
		<div class="form-group">
		<label for="business-code" class="col-sm-2 control-label" data-toggle="tooltip" data-placement="top" title="" data-original-title="This business code is needed by the agent installed at client side. Leave empty to allow the system auto generate a code.">
						License Code						<i class="glyphicon glyphicon-question-sign"></i>
					</label>
		<div class="col-sm-10">
			<input type="text" name="keys" value="" id="keys" class="form-control form-control" size="20" maxlength="20">			
						
			<div class="help-block with-errors"></div>
		</div>
	</div>
		
		
	<div class="form-group">
		<div class="col-sm-2"></div>
		<div class="col-sm-10">
			<button type="submit" class="btn btn-primary">
				Submit		</button>
						
					</div>
	</div>

</form>
</div>