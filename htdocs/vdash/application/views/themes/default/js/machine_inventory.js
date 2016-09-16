(function($) {
	$(".clear-info").click(function(e) {
		e.preventDefault();
		
		if ( !confirm("Are you sure to remove the user data of this machine?") ) {
			return ;
		}
		
		var machineId = $(this).data("machine-id");
		
		$("#modal-loading").modal("show");
		
		$.ajax({
			url: baseurl + "machine/a_clear_inv",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				machine_id: machineId
			},
			context: this,
			success: function(data) {
				if ( !data.error ) {
					var dataRow = $(this).closest(".data-row");
					var machineDefaultName = data.machine_default_name;
					
					console.log($(dataRow).find(".reset-field"));
					
					$(dataRow).find(".reset-field").html("n/a");
					$(dataRow).find(".machine-default-name").html(machineDefaultName);
				} else {
					alert(data.message);
				}
			},
			error: function(xhr, error, message) {
				alert(message);
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
		
		var url = baseurl + "machine/inventory?" + $.encodeURI(uriParams);
		
		window.location = url;
	});
	
	/* File Upload Code */
	$("#btn-browse").fileupload({
		url: baseurl + "machine/a_inventory_upload",
		formData: {
			token: clientId
		},
		dataType: "json",
		autoUpload: false,
		acceptFileTypes: /(\.|\/)csv$/i,
		maxFileSize: 4 * 1024 * 1024,
		disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent)
	}).on("fileuploadprocessalways", function(e, data) {
		// Unbind the upload button.
		$("#btn-upload").unbind("click");
		
		if ( data.files ) {
			var file = data.files[0];
			
			if ( file.error ) {
				alert(file.error);
			} else {
				$("#file-container .file-name").html(file.name);
				$("#file-container .file-size").html(file.size);
				$("#file-container").removeClass("hidden");
				
				$("#btn-upload").removeClass("hidden");
				$("#btn-browse").closest(".btn").addClass("hidden");
				
				$("#btn-upload").one("click", function(e) {
					data.submit()
					.success(function(result, textStatus, xhr) {
						window.location.reload(true);
					})
					.error(function(xhr, error, message) {
						alert("Unable to upload your selected file.");
					});
				});
			}
		}
	}).on("fileuploadsubmit", function(e, data) {
		var dropdownBusiness = $("#dropdown-business-import");
		
		if ( dropdownBusiness.length ) {
			var businessId = $(dropdownBusiness).val();
			
			data.formData["business"] = businessId;
		}
	});
	
	$("#modal-import").on("hidden.modal.bs", function(e) {
		$("#file-container").addClass("hidden");
		$("#btn-upload").addClass("hidden");
		$("#btn-browse").closest(".btn").removeClass("hidden");
	});
})(jQuery);