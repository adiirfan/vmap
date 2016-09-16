(function($) {
	$(".delete-machine-group").click(function(e) {
		e.preventDefault();
		
		var machineGroupId = $(this).data("machine-group-id");
		
		$("#modal-delete").modal("show");
		$("#modal-delete").data("machine-group-id", machineGroupId);
		$("#modal-delete").data("machine-group-row", $(this).closest(".data-row"));
	});
	
	$("#btn-delete").click(function(e) {
		e.preventDefault();
		
		var machineGroupId = $("#modal-delete").data("machine-group-id");
		var dataRow = $("#modal-delete").data("machine-group-row");
		
		$("#modal-delete").modal("hide");
		$("#modal-loading").modal("show");
		
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
					$(dataRow).remove();
				}
			},
			error: function(xhr, error, message) {
				
			},
			complete: function() {
				$("#modal-loading").modal("hide");
			}
		});
	});

	$(".manage-machines").click(function(e) {
		e.preventDefault();
		
		var machineGroupId = $(this).data("machine-group-id");
		
		$("#modal-manage-machines").data("machine-group-id", machineGroupId);
		$("#modal-manage-machines").data("update-container", $(this).closest(".data-row"));
		$("#modal-manage-machines").modal("show");
	});
	
	$("#per-page").change(function(e) {
		var uriParams = $.getUriParameter();
		var perPage = $(this).val();
		
		if ( !uriParams ) {
			uriParams = {};
		}
		
		uriParams["per_page"] = perPage;
		
		var url = baseurl + "machine_group/index?" + $.encodeURI(uriParams);
		
		window.location = url;
	});
})(jQuery);