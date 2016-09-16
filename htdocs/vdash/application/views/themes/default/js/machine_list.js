(function($) {
	// This array used to keep track the inputs which is currently modified by script itself.
	var ignoreInputs = [];
	
	$(document).on("change", ".machine-blacklist", function(e) {
		$("#modal-loading").modal("show");
		
		var checked = $(this).prop("checked");
		var machineId = $(this).data("machine-id");
		var checkbox = this;
		var inputIndex = $.inArray(checkbox, ignoreInputs);
		
		if ( inputIndex != -1 ) {
			ignoreInputs.splice(inputIndex);
			return ;
		}
		
		$.ajax({
			url: baseurl + "machine/a_set_visibility",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				machine_id: machineId,
				visibility: (checked ? 0 : 1)
			},
			context: checkbox,
			success: function(data) {
				
			},
			error: function(xhr, error, message) {
				ignoreInputs.push(this);
				
				$(this).bootstrapToggle("toggle");
			},
			complete: function() {
				$("#modal-loading").modal("hide");
			}
		});
	});
	
	$("#per-page").change(function(e) {
		var uriParams = $.getUriParameter();
		var perPage = $(this).val();
		
		if ( !uriParams ) {
			uriParams = {};
		}
		
		uriParams["per_page"] = perPage;
		
		var url = baseurl + "machine/index?" + $.encodeURI(uriParams);
		
		window.location = url;
	});
})(jQuery);