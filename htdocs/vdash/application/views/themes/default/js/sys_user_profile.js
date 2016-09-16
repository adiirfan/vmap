(function($) {
	$("#btn-change-password").click(function(e) {
		e.preventDefault();
		
		var password = $("#txt-password").val();
		var url = $(this).data("url");
		
		if ( $.trim(password) != "" ) {
			$.ajax({
				url: url,
				type: "get",
				dataType: "json",
				data: {
					password: password,
					code: clientId
				},
				success: function(data) {
					alert(data.message);
					
					if ( !data.error ) {
						$("#modal-password").modal("hide");
					}
				},
				error: function(xhr, error, message) {
					alert(message);
				}
			});
		}
	});
})(jQuery);