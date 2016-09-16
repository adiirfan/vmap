(function($) {
	$("#machine-blaklist").change(function(e) {
		var checked = $(this).is(":checked");
		var visible = !checked;
		var machineId = $(this).data("machine-id");
		
		$("#modal-loading").modal("show");
		
		$.ajax({
			url: baseurl + "machine/a_set_visibility",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				machine_id: machineId,
				visibility: (visible ? 1 : 0)
			},
			context: this,
			success: function(data) {
				
			},
			error: function(xhr, error, message) {
				alert("error");
			},
			complete: function() {
				$("#modal-loading").modal("hide");
			}
		});
	});
})(jQuery);