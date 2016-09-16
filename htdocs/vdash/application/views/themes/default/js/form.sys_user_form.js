(function($) {
	var userTypeChanged = function() {
		var value = $(this).val();
		
		if ( value == "superadmin" ) {
			$("#business").prop("disabled", true);
		} else {
			$("#business").prop("disabled", false);
		}
	};
	
	$("#user-type").change(function() {
		userTypeChanged.call(this);
	});
	
	userTypeChanged.call($("#user-type").get(0));
})(jQuery);