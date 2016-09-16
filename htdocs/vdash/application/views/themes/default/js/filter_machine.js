(function($) {
	var businessDropdown = $("#dropdown-business");
	
	if ( businessDropdown.length ) {
		$(businessDropdown).change(function() {
			var businessId = $(this).val();
			
			window.location = baseurl + "filter/machine?business=" + businessId;
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
				url: baseurl + "filter/a_machine_reorder",
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
	
	// On pattern modify clicked.
	$("#filter-list").on("click", ".filter-pattern-modify", function(e) {
		e.preventDefault();
		
		var modal = $("#modal-change-pattern");
		var filterId = $(this).data("filter-id");
		var filterName = $(this).data("filter-name");
		var filterPattern = $(this).data("filter-pattern");
		var filterColumnName = $(this).data("filter-pattern-name");
		
		if ( filterColumnName == "machine_name" ) {
			$(modal).find(".txt-machine-name").removeClass("hidden");
		} else if ( filterColumnName == "ip_address" ) {
			$(modal).find(".txt-ip-address").removeClass("hidden");
		} else {
			$(modal).find(".txt-mac-address").removeClass("hidden");
		}
		
		$("#filter-new-pattern").val(filterPattern);
		$(modal).find(".filter-name").html(filterName);
		
		// Assign data.
		$(modal).data("filter-id", filterId);
		$(modal).data("filter-column-name", filterColumnName);
		
		$(modal).modal("show");
	});
	
	// On pattern change modal hide.
	$("#modal-change-pattern").on("hide.bs.modal", function() {
		$(this).find(".txt-machine-name").addClass("hidden");
		$(this).find(".txt-ip-address").addClass("hidden");
		$(this).find(".txt-mac-address").addClass("hidden");
	});
	
	// On pattern save changed clicked.
	$("#btn-modify-pattern").click(function(e) {
		var modal = $("#modal-change-pattern");
		var filterId = $(modal).data("filter-id");
		var filterColumnName = $(modal).data("filter-column-name");
		var newFilterPattern = $("#filter-new-pattern").val()
		
		$.ajax({
			url: baseurl + "filter/a_machine_modify_pattern",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				filter_id: filterId,
				column_name: filterColumnName,
				pattern: newFilterPattern
			},
			context: modal,
			success: function(data) {
				if ( !data.error ) {
					var modifyButton = $("[data-filter-pattern-name='" + filterColumnName + "']");
					
					if ( modifyButton.length ) {
						var detailInfo = $(modifyButton).closest(".detail-info");
						var label = ($.trim(newFilterPattern) == "" ? "n/a" : newFilterPattern);
						
						$(detailInfo).find(".filter-pattern").html(label);
						
						$(modifyButton).data("filter-pattern", newFilterPattern);
					}
					
					$(this).modal("hide");
				} else {
					alert(data.message);
				}
			},
			error: function(xhr, error, message) {
				alert(message);
			}
		});
	});
	
	// On bootstrap toggle button switched.
	$("#filter-list").on("change", "[data-toggle='toggle']", function(e) {
		var option = $(this).data("filter-option");
		var filterId = $(this).data("filter-id");
		var value = ($(this).is(":checked") ? 1 : 0);
		
		if ( $.trim(option) != "" && filterId > 0 ) {
			$.ajax({
				url: baseurl + "filter/a_machine_set_option",
				type: "get",
				dataType: "json",
				data: {
					token: clientId,
					filter_id: filterId,
					option: option,
					value: value
				},
				success: function(data) {
					if ( data.error ) {
						alert(data.error_message);
					}
				},
				error: function(xhr, error, message) {
					alert(message);
				}
			});
		}
	});
	
	// Initialize the machine group dropdown box.
	$("#filter-list .machine-group-list").each(function() {
		var machineGroupId = $(this).data("machine-group-id");
		
		if ( machineGroupId > 0 && !$(this).is(":disabled") ) {
			$(this).val(machineGroupId);
		}
	});
	
	// On action changed.
	$("#filter-list").on("change", ".filter-actions", function(e) {
		var info = $(this).closest(".detail-info");
		var value = $(this).val();
		var filterId = $(this).data("filter-id");
		
		if ( value == "allow" || value == "block" ) {
			$(info).find(".machine-group-list").prop("disabled", true);
			$(info).find(".machine-group-list option[value='']").prop("selected", true);
			
			$.ajax({
				url: baseurl + "filter/a_machine_set_action",
				type: "get",
				dataType: "json",
				data: {
					token: clientId,
					filter_id: filterId,
					action: value
				},
				success: function(data) {
					if ( data.error ) {
						alert(data.message);
					}
				}
			});
		} else if ( value == "group" ) {
			$(info).find(".machine-group-list").prop("disabled", false);
		}
	});
	
	// On machine group list changed.
	$("#filter-list").on("change", ".machine-group-list", function(e) {
		var machineGroupId = $(this).val();
		var filterId = $(this).data("filter-id");
		
		if ( machineGroupId ) {
			$.ajax({
				url: baseurl + "filter/a_machine_set_action",
				type: "get",
				dataType: "json",
				data: {
					token: clientId,
					filter_id: filterId,
					action: "group",
					machine_group_id: machineGroupId
				},
				success: function(data) {
					if ( data.error ) {
						alert(data.message);
					}
				}
			});
		}
	});
	
	// On delete button clicked.
	$("#filter-list").on("click", ".filter-delete", function(e) {
		var filterId = $(this).data("filter-id");
		var filterName = $(this).data("filter-name");
		
		$("#modal-delete .filter-name").html(filterName);
		
		$("#modal-delete").data("filter-id", filterId);
		
		$("#modal-delete").modal("show");
	});
	
	// On delete confirm button clicked.
	$("#btn-delete").click(function(e) {
		var modal = $("#modal-delete");
		var filterId = $(modal).data("filter-id");
		
		if ( filterId ) {
			$.ajax({
				url: baseurl + "filter/a_machine_delete",
				type: "get",
				dataType: "json",
				data: {
					token: clientId,
					filter_id: filterId,
				},
				context: modal,
				success: function(data) {
					if ( !data.error ) {
						$("#filter-list .panel[data-filter-id='" + filterId + "']").remove();
						
						$(modal).modal("hide");
					} else {
						alert(data.message);
					}
				}
			});
		}
	});
	
	// On rename button clicked.
	$("#filter-list").on("click", ".filter-rename", function(e) {
		e.preventDefault();
		
		var modal = $("#modal-rename");
		var filterId = $(this).data("filter-id");
		var filterName = $(this).data("filter-name");
		
		$("#filter-new-name").val(filterName);
		$(modal).data("filter-id", filterId);
		$(modal).modal("show");
	});
	
	// On rename confirm button clicked.
	$("#btn-rename").click(function(e) {
		e.preventDefault();
		
		var modal = $("#modal-rename");
		var newFilterName = $("#filter-new-name").val();
		var filterId = $(modal).data("filter-id");
		
		if ( filterId > 0 && $.trim(newFilterName) != "" ) {
			$.ajax({
				url: baseurl + "filter/a_machine_change_name",
				type: "get",
				dataType: "json",
				data: {
					token: clientId,
					filter_id: filterId,
					name: newFilterName
				},
				context: modal,
				success: function(data) {
					if ( !data.error ) {
						$(this).modal("hide");
						var panel = $("#filter-list .panel[data-filter-id='" + filterId + "']");
						
						if ( panel.length ) {
							$(panel).find(".filter-name").html(newFilterName);
							$(panel).find("[data-filter-name]").data("filter-name", newFilterName);
						}
					}
				}
			});
		}
	});
	
	// On test button clicked.
	$("#filter-list").on("click", ".filter-test", function(e) {
		e.preventDefault();
		
		var filterId = $(this).data("filter-id");
		var filterName = $(this).data("filter-name");
		
		$("#modal-test").data("filter-id", filterId);
		$("#modal-test").modal("show");
		$("#modal-test").find(".filter-name").html(filterName);
	});
	
	$("#modal-test").on("hide.bs.modal", function(e) {
		$(this).find(".test-result-match").addClass("hidden");
		$(this).find(".test-result-not-match").addClass("hidden");
	});
	
	$("#btn-test-filter").click(function(e) {
		var modal = $("#modal-test");
		var filterId = $(modal).data("filter-id");
		var machineName = $("#txt-test-machine-name").val();
		var ipAddress = $("#txt-test-machine-ip-address").val();
		var macAddress = $("#txt-test-machine-mac-address").val();
		
		$.ajax({
			url: baseurl + "filter/a_machine_test",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				filter_id: filterId,
				machine_name: machineName,
				ip_address: ipAddress,
				mac_address: macAddress
			},
			context: modal,
			success: function(data) {
				if ( !data.error ) {
					var matched = data.matched;
					
					if ( matched ) {
						$(this).find(".test-result-match").removeClass("hidden");
						$(this).find(".test-result-not-match").addClass("hidden");
					} else {
						$(this).find(".test-result-not-match").removeClass("hidden");
						$(this).find(".test-result-match").addClass("hidden");
					}
				}
			}
		});
	});
	
	$("#btn-create").click(function(e) {
		e.preventDefault();
		
		$("#modal-new-filter").modal("show");
	});
	
	var resetNewFilterForm = function() {
		var form = $("#new-filter-form");
		
		if ( form.length ) {
			$(form).find("input[type='text']").val("");
			$(form).find("select").each(function() {
				$(this).find("option:first").prop("selected", true);
			});
			$(form).find("#filter-assigned-group").prop("disabled", true);
		}
	};
	
	$("#modal-new-filter").on("hide.bs.modal", function(e) {
		resetNewFilterForm();
	});
	
	$("#filter-action").change(function() {
		var value = $(this).val();
		
		if ( value == "group" ) {
			$("#filter-assigned-group").prop("disabled", false);
		} else {
			$("#filter-assigned-group").prop("disabled", true);
			$("#filter-assigned-group option:first").prop("selected", true);
		}
	});
	
	$("#btn-create-filter").click(function(e) {
		var filterName = $("#filter-name").val();
		var form = $("#new-filter-form");
		var nonEmptyTextGroup = ["filter_machine_name", "filter_machine_ip_address", "filter_machine_mac_address"];
		
		if ( form.length ) {
			if ( $.trim(filterName) == "" ) {
				alert("Please enter a name for this filter.");
				$("#filter-anem").focus();
			} else {
				var empty = true;
				
				for ( var i = 0; i < nonEmptyTextGroup.length; i ++ ) {
					var fieldName = nonEmptyTextGroup[i];
					var field = $(form).find("[name='" + fieldName + "']");
					
					if ( field.length ) {
						var fieldValue = $(field).val();
						
						if ( $.trim(fieldValue) != "" ) {
							empty = false;
							
							break ;
						}
					}
				}
				
				if ( empty ) {
					alert("You need to enter at least one filter criteria.");
				} else {
					// Proceed on saving.
					var actionUrl = $(form).attr("action");
					
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
			}
		}
	});
	
	$("#btn-simulate").click(function(e) {
		$("#modal-simulate").modal("show");
	});
	
	$("#btn-start-simulate").click(function(e) {
		var machineName = $("#sim-machine-name").val();
		var ipAddress = $("#sim-machine-ip-address").val();
		var macAddress = $("#sim-machine-mac-address").val();
		var businessId = $("#dropdown-business").val();
		
		$.ajax({
			url: baseurl + "filter/a_machine_simulate",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				business_id: businessId,
				machine_name: machineName,
				ip_address: ipAddress,
				mac_address: macAddress
			},
			success: function(data) {
				if ( !data.error ) {
					var html = data.html;
					
					$("#modal-simulate .test-result").html(html);
				}
			},
			error: function(xhr, error, message) {
				alert(message);
			}
		});
	});
	
	$("#btn-process").click(function(e) {
		$("#modal-process").modal("show");
	});
	
	$("#btn-process-evaluate").click(function() {
		var businessId = $("#dropdown-business").val();
		
		$.ajax({
			url: baseurl + "filter/a_machine_evaluate",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				business_id: businessId
			},
			success: function(data) {
				if ( !data.error && data.html ) {
					var token = data.token;
					
					$("#modal-process .result").html(data.html);
					$("#modal-process").data("token", token);
					
					$("#btn-process-evaluate").addClass("hidden");
					$("#btn-process-go").removeClass("hidden");
				}
			}
		});
	});
	
	$("#btn-process-go").click(function(e) {
		e.preventDefault();
		
		var token = $("#modal-process").data("token");
		var businessId = $("#dropdown-business").val();
		
		$.ajax({
			url: baseurl + "filter/a_machine_process",
			type: "get",
			dataType: "json",
			data: {
				token: token,
				business_id: businessId
			},
			context: $("#modal-process"),
			success: function() {
				$(this).modal("hide");
			}
		});
	});
	
	$("#modal-process").on("hide.bs.modal", function() {
		$("#btn-process-evaluate").removeClass("hidden");
		$("#btn-process-go").addClass("hidden");
	});
	
	$("#evaluate-result .scrolling-area").slimScroll({
		height: 200
	});
})(jQuery);