(function($) {
	$(".clear-info").click(function(e) {
		e.preventDefault();
		
		if ( !confirm("Are you sure to clear the application info?") ) {
			return false;
		}
		
		var url = $(this).attr("href");
		
		$("#modal-loading").modal("show");
		
		$.ajax({
			url: url,
			type: "get",
			dataType: "json",
			data: {
				token: clientId
			},
			context: this,
			success: function(data) {
				if ( !data.error ) {
					var row = $(this).closest(".row");
					var isFirst = true;
					
					$(row).find(".cell:not(:last-child)").each(function() {
						if ( isFirst ) {
							isFirst = false;
							
							var appName = $(this).find(".small").html();
							$(this).find(".column-data strong:first").html(appName);
						} else {
							$(this).find(".column-data").html("n/a");
						}
					});
				} else if ( data.message ) {
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
		
		var url = baseurl + "app/inventory?" + $.encodeURI(uriParams);
		
		window.location = url;
	});
	
	/* File Upload Code */
	$("#btn-browse").fileupload({
		url: baseurl + "app/a_inventory_upload",
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