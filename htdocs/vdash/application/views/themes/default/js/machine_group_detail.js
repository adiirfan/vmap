(function($) {
	$("#btn-manage-machines").click(function(e) {
		e.preventDefault();
		
		var machineGroupId = $(this).data("machine-group-id");
		
		$("#modal-manage-machines").data("machine-group-id", machineGroupId);
		$("#modal-manage-machines").data("update-container", $(this).closest(".box"));
		$("#modal-manage-machines").modal("show");
	});
	
	$("#btn-delete").click(function(e) {
		$("#modal-delete").modal("show");
	});
	
	$("#btn-delete-confirm").click(function(e) {
		var machineGroupId = $(this).data("machine-group-id");
		
		$.ajax({
			url: baseurl + "machine_group/a_delete",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				machine_group_id: machineGroupId
			},
			success: function(data) {
				if ( !data.error ) {
					window.location = baseurl + "machine_group/index";
				}
			}
		});
	});
})(jQuery);