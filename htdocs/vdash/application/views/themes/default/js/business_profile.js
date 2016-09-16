(function($) {
	var businessId = $("#btn-picture").data("business-id");
	
	$("#btn-picture").fileupload({
		url: baseurl + "business/a_upload_picture",
		formData: {
			token: clientId,
			business_id: businessId
		},
		dataType: "json",
		autoUpload: false,
		acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
		maxFileSize: 2 * 1024 * 1024,
		disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
		previewMaxWidth: 100,
		previewMaxHeight: 100,
		previewCrop: true
	}).on("fileuploadprocessalways", function(e, data) {
		if ( data.files ) {
			var file = data.files[0];
			
			$("#image-preview").html(file.preview);
			
			$("#btn-start-upload").removeClass("hidden").click(function(e) {
				e.preventDefault();
				
				data.submit()
					.success(function(result, textStatus, xhr) {
						if ( result.error ) {
							alert(result.message);
						} else {
							var imagePath = result.image_path;
							
							$("#image-preview").empty();
							
							$("#business-picture").attr("src", imagePath);
							
							$("#btn-start-upload").addClass("hidden");
							
							$("#btn-start-upload").unbind("click");
						}
					});
			});
		}
	});
})(jQuery);