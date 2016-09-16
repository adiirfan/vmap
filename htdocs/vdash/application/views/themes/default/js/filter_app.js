(function($) {
	var businessDropdown = $("#dropdown-business");
	
	if ( businessDropdown.length ) {
		$(businessDropdown).change(function() {
			var businessId = $(this).val();
			
			window.location = baseurl + "filter/app?business=" + businessId;
		});
	}
	
	// Initialize the sortable collapse content.
	$("#filter-list").sortable({
		handle: ".sort-handle",
		axis: "y",
		update: function(e, ui) {
			var filterIds = new Array();
			var businessId = $("#dropdown-business").val();
			
			$("#filter-list > .panel").each(function() {
				var id = $(this).data("filter-id");
				
				filterIds.push(id);
			});
			
			// Update database.
			$.ajax({
				url: baseurl + "filter/a_app_reorder",
				type: "get",
				dataType: "json",
				data: {
					token: clientId,
					business: businessId,
					filter_ids: filterIds
				}
			});
		}
	});
	
	// On rename clicked.
	$("#filter-list").on("click", ".filter-rename", function(e) {
		var filterId = $(this).data("filter-id");
		var filterName = $(this).data("filter-name");
		
		$("#modal-rename").data("filter-id", filterId);
		$("#modal-rename").data("filter-name", filterName);
		
		$("#modal-rename").modal("show");
	});
	
	// On rename filter modal open.
	$("#modal-rename").on("show.bs.modal", function(e) {
		var name = $(this).data("filter-name");
		
		$("#filter-new-name").attr("placeholder", name);
	});
	
	$("#modal-rename").on("hide.bs.modal", function(e) {
		$("#filter-new-name").val("");
	});
	
	// On rename confirmed.
	$("#btn-rename").click(function(e) {
		var filterId = $("#modal-rename").data("filter-id");
		var filterName = $("#filter-new-name").val();
		
		$.ajax({
			url: baseurl + "filter/a_app_rename",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				id: filterId,
				name: filterName
			},
			success: function(data) {
				if ( !data.error ) {
					var panel = $("#filter-list .panel[data-filter-id='" + filterId + "']");
					
					if ( panel.length ) {
						$(panel).find(".panel-title > a").html(filterName);
						$(panel).find("[data-filter-name]").data("filter-name", filterName);
					}
				}
			},
			complete: function() {
				$("#modal-rename").modal("hide");
			}
		});
	});
	
	// On delete clicked.
	$("#filter-list").on("click", ".filter-delete", function(e) {
		var filterId = $(this).data("filter-id");
		var filterName = $(this).data("filter-name");
		
		$("#modal-delete").data("filter-id", filterId);
		$("#modal-delete").data("filter-name", filterName);
		
		$("#modal-delete").modal("show");
	});
	
	// On delete filter modal open.
	$("#modal-delete").on("show.bs.modal", function(e) {
		var name = $(this).data("filter-name");
		
		$(this).find(".filter-name").html(name);
	});
	
	// On filter delete confirmed.
	$("#btn-delete").click(function(e) {
		var filterId = $("#modal-delete").data("filter-id");
		
		$.ajax({
			url: baseurl + "filter/a_app_delete",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				id: filterId
			},
			success: function(data) {
				if ( !data.error ) {
					var panel = $("#filter-list .panel[data-filter-id='" + filterId + "']");
					
					if ( panel.length ) {
						$(panel).remove();
					}
				}
			},
			complete: function() {
				$("#modal-delete").modal("hide");
			}
		});
	});
	
	// On test button clicked.
	$("#filter-list").on("click", ".filter-test", function(e) {
		var filterId = $(this).data("filter-id");
		var filterName = $(this).data("filter-name");
		
		$("#modal-test").data("filter-id", filterId);
		$("#modal-test").data("filter-name", filterName);
		
		$("#modal-test").modal("show");
	});
	
	// On test modal show
	$("#modal-test").on("show.bs.modal", function() {
		var filterName = $(this).data("filter-name");
		
		$(this).find(".filter-name").html(filterName);
	});
	
	// On test modal hide
	$("#modal-test").on("hide.bs.modal", function() {
		$(this).find(".icon").addClass("hidden");
		$(this).find(".icon-test").removeClass("hidden");
		$(this).find(".form-group").removeClass("has-success").removeClass("has-error");
		$("#txt-test-app-name").val("");
	});
	
	// On test button clicked.
	$("#btn-test-filter").click(function(e) {
		var filterId = $("#modal-test").data("filter-id");
		var appName = $("#txt-test-app-name").val();
		$("#modal-test .icon").addClass("hidden");
		$("#modal-test .icon-loading").removeClass("hidden");
		
		$.ajax({
			url: baseurl + "filter/a_app_test",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				id: filterId,
				name: appName
			},
			context: $("#modal-test"),
			success: function(data) {
				if ( !data.error ) {
					$(this).find(".form-group").removeClass("has-success").removeClass("has-error");
					
					if ( data.matched ) {
						$("#modal-test .form-group").addClass("has-success");
						$("#modal-test .icon-success").removeClass("hidden");
					} else {
						$("#modal-test .form-group").addClass("has-error");
						$("#modal-test .icon-fail").removeClass("hidden");
					}
				}
			},
			complete: function() {
				$("#modal-test .icon-loading").addClass("hidden");
			}
		});
	});
	
	// On pattern modify clicked.
	$("#filter-list").on("click", ".filter-pattern-modify", function(e) {
		var filterId = $(this).data("filter-id");
		var filterName = $(this).data("filter-name");
		var filterPattern = $(this).data("filter-pattern");
		
		$("#modal-modify-pattern").data({
			"filter-id": filterId,
			"filter-name": filterName,
			"filter-pattern": filterPattern
		});
		
		$("#modal-modify-pattern").modal("show");
	});
	
	// On pattern modal show.
	$("#modal-modify-pattern").on("show.bs.modal", function() {
		var filterId = $(this).data("filter-id");
		var filterName = $(this).data("filter-name");
		var filterPattern = $(this).data("filter-pattern");
		
		$(this).find(".filter-name").html(filterName);
		$("#filter-new-pattern").val(filterPattern);
	});
	
	// On pattern confirmed.
	$("#btn-modify-pattern").click(function(e) {
		var filterId = $("#modal-modify-pattern").data("filter-id");
		var filterPattern = $("#filter-new-pattern").val();
		
		$.ajax({
			url: baseurl + "filter/a_app_modify_pattern",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				id: filterId,
				pattern: filterPattern
			},
			success: function(data) {
				if ( !data.error ) {
					var panel = $("#filter-list .panel[data-filter-id='" + filterId + "']");
					
					if ( panel.length ) {
						$(panel).find(".filter-pattern").html(filterPattern);
						$(panel).find("[data-filter-pattern]").data("filter-pattern", filterPattern);
					}
				}
			},
			complete: function() {
				$("#modal-modify-pattern").modal("hide");
			}
		});
	});
	
	// Negate changed.
	$("#filter-list").on("change", ".filter-negate", function(e) {
		var filterId = $(this).data("filter-id");
		var checked = $(this).is(":checked");
		
		$.ajax({
			url: baseurl + "filter/a_app_set_negate",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				id: filterId,
				negate: (checked ? 1 : 0)
			},
			success: function(data) {
				
			},
		});
	});
	
	// Action changed.
	$("#filter-list").on("change", ".filter-action", function(e) {
		var filterId = $(this).data("filter-id");
		var checked = $(this).is(":checked");
		
		$.ajax({
			url: baseurl + "filter/a_app_set_action",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				id: filterId,
				action: (checked ? "allow" : "block")
			},
			success: function(data) {
				
			},
		});
	});
	
	// Success changed.
	$("#filter-list").on("change", ".filter-success", function(e) {
		var filterId = $(this).data("filter-id");
		var checked = $(this).is(":checked");
		
		$.ajax({
			url: baseurl + "filter/a_app_set_success",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				id: filterId,
				action: (checked ? "pass" : "stop")
			},
			success: function(data) {
				
			},
		});
	});
	
	// Fail changed.
	$("#filter-list").on("change", ".filter-fail", function(e) {
		var filterId = $(this).data("filter-id");
		var checked = $(this).is(":checked");
		
		$.ajax({
			url: baseurl + "filter/a_app_set_fail",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				id: filterId,
				action: (checked ? "pass" : "stop")
			},
			success: function(data) {
				
			},
		});
	});
	
	// Simulate clicked.
	$("#btn-simulate").click(function(e) {
		$("#modal-simulate").modal("show");
		
		// $("#txt-simulate-app-name").val("");
	});
	
	$("#btn-simulate-filter").click(function(e) {
		var testAppName = $("#txt-simulate-app-name").val();
		var businessId = $("#modal-simulate").data("business-id");
		
		if ( !businessId ) {
			return ;
		}
		
		$.ajax({
			url: baseurl + "filter/a_app_simulate",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				business: businessId,
				app_name: testAppName
			},
			success: function(data) {
				if ( !data.error ) {
					var html = data.html;
					
					$("#modal-simulate .test-result").html(html);
				}
			}
		});
	});
	
	$("#btn-create").click(function(e) {
		$("#modal-new-filter").modal("show");
	});
	
	$("#btn-create-filter").click(function(e) {
		var form = $("#new-filter-form");
		var businessId = $("#modal-simulate").data("business-id");
		
		if ( !businessId || !form.length ) {
			return ;
		}
		
		var actionUrl = $(form).attr("action");
		var filterName = $("#filter-name").val();
		var filterPattern = $("#filter-pattern").val();
		
		if ( $.trim(filterName) == "" ) {
			alert("Please enter a value for the filter name.");
		} else if ( $.trim(filterPattern) == "" ) {
			alert("Please enter a value for the filter pattern.");
		} else {
			$.ajax({
				url: actionUrl,
				type: "post",
				dataType: "json",
				data: $(form).serialize(),
				success: function(data) {
					if ( data.error ) {
						alert(data.message);
					} else {
						window.location.reload(true);
					}
				},
				error: function(xhr, error, message) {
					alert(message);
				}
			});
		}
	});
	
	$("#btn-process").click(function(e) {
		$("#modal-process").modal("show");
	});
	
	$("#modal-process").on("hide.bs.modal", function() {
		$(this).find(".icon-loading").addClass("hidden");
		$("#btn-process-go").addClass("hidden");
		$("#btn-process-go").prop("disabled", false);
		$("#btn-process-evaluate").prop("disabled", false);
		$("#btn-process-evaluate").removeClass("hidden");
		$("#evaluate-result .scrolling-area").empty();
		$(this).data("token", "");
	});
	
	$("#btn-process-evaluate").click(function(e) {
		var businessId = $("#dropdown-business").val();
		
		if ( businessId ) {
			$(this).prop("disabled", true);
			$(this).find(".icon-loading").removeClass("hidden");
			
			$.ajax({
				url: baseurl + "filter/a_app_evaluate",
				type: "get",
				dataType: "json",
				data: {
					business_id: businessId,
					token: clientId
				},
				context: this,
				success: function(data) {
					if ( !data.error ) {
						$("#evaluate-result .scrolling-area").html(data.html);
						
						$(this).addClass("hidden");
						$("#btn-process-go").removeClass("hidden");
						
						$("#modal-process").data("token", data.token);
					} else {
						alert(data.message);
					}
				},
				error: function(xhr, error, message) {
					alert(message);
				},
				complete: function() {
					$("#btn-process-evaluate").prop("disabled", false);
					$(this).find(".icon-loading").addClass("hidden");
				}
			});
		}
	});
	
	$("#btn-process-go").click(function(e) {
		var token = $("#modal-process").data("token");
		var businessId = $("#dropdown-business").val();
		
		if ( token && businessId ) {
			$(this).prop("disabled", true);
			$(this).find(".icon-loading").removeClass("hidden");
			
			$.ajax({
				url: baseurl + "filter/a_app_process",
				type: "get",
				dataType: "json",
				data: {
					business_id: businessId,
					token: token
				},
				context: this,
				success: function(data) {
					if ( data.error ) {
						alert(data.message);
					} else {
						alert("Completed!");
						$("#modal-process").modal("hide");
					}
				},
				error: function(xhr, error, message) {
					alert(message);
				},
				complete: function() {
					$(this).prop("disabled", false);
					$(this).find(".icon-loading").addClass("hidden");
				}
			});
		}
	});
	
	$("#evaluate-result .scrolling-area").slimScroll({
		height: 200
	});
})(jQuery);