/*
 * Machine Group Chooser Scripts.
 * 
 * Dependencies.
 * - jquery.slimscroll.min.js
 * - jquery.typewatch.js
 */
var loadMachineResult = function(params, callback) {
	var paramEnsure = function(name, defValue) {
		if ( params !== undefined && params[name] !== undefined ) {
			return params[name];
		} else {
			return defValue;
		}
	};
	
	var httpData = {};
	httpData["machine_group_id"] = paramEnsure("machineGroupId", 0);
	httpData["result_type"] = paramEnsure("resultType", "");
	httpData["filter_keyword"] = paramEnsure("keyword", "");
	httpData["page"] = paramEnsure("page", 1);
	httpData["token"] = clientId;
	var context = paramEnsure("context", window.document);
	var result = null;
	
	$.ajax({
		url: baseurl + "machine_group/a_machine_chooser",
		type: "get",
		dataType: "json",
		data: httpData,
		success: function(data) {
			if ( data.error ) {
				alert(data.message);
			} else {
				result = data;
			}
		},
		error: function(xhr, error, message) {
			alert(message);
		},
		complete: function() {
			if ( typeof callback === "function" ) {
				callback.call(context, result);
			}
		}
	});
};

var renderListResult = function(type, data) {
	var modal = $("#modal-manage-machines");
	var updateData = $("#modal-manage-machines").data("update-data");
	
	$(modal).find(".content-" + type + " .result-blocks").html($(modal).find(".content-" + type + " .result-blocks").html() + data.html_list);
	
	$(modal).find(".content-" + type + " .result-blocks").data("more-records", data.more_records);
	
	$(modal).find(".content-" + type + " .result-blocks").data("next-page", data.next_page);
	
	if ( updateData !== undefined && updateData[type] !== undefined ) {
		var selectedItems = updateData[type];
		
		for ( var i = 0; i < selectedItems.length; i ++ ) {
			var machineId = selectedItems[i];
			
			$("#modal-manage-machines .content-" + type + " .block[data-machine-id='" + machineId + "']").addClass("active");
		}
	}
};

$("#modal-manage-machines").on("shown.bs.modal", function(e) {
	$(this).find(".loading-box").removeClass("hidden");
	$(this).find(".result-body").addClass("hidden");
	$(this).data("update-data", {
		available: new Array(),
		selected: new Array()
	});
	
	var result = {};
	var machineGroupId = $(this).data("machine-group-id");
	
	var onSuccess = function() {
		$(this).find(".loading-box").addClass("hidden");
		$(this).find(".result-body").removeClass("hidden");
		
		$(this).find(".available-count").html(result.available.total_result);
		$(this).find(".selected-count").html(result.selected.total_result);
		
		renderListResult("available", result.available);
		renderListResult("selected", result.selected);
	};
	
	loadMachineResult({
		machineGroupId: machineGroupId,
		resultType: "available",
		context: this
	}, function(data) {
		result["available"] = data;
		
		loadMachineResult({
			machineGroupId: machineGroupId,
			resultType: "selected",
			context: this
		}, function(data) {
			result["selected"] = data;
			
			onSuccess.call(this);
		});
	});
});

$("#modal-manage-machines").on("hide.bs.modal", function() {
	$(this).find(".loading-box").removeClass("hidden");
	$(this).find(".result-body").addClass("hidden");
	$(this).removeData("update-data");
	$(this).removeData("machine-group-id");
	$(this).removeData("update-container");
	$(this).find(".available-count").html("");
	$(this).find(".selected-count").html("");
	$(this).find(".content-available .result-blocks").html("");
	$(this).find(".content-selected .result-blocks").html("");
});

$("#modal-manage-machines .tab-content").on("click", ".result-blocks .block", function(e) {
	$(this).toggleClass("active");
	
	var content = $(this).closest(".content");
	var type = ($(content).hasClass("content-available") ? "available" : "selected");
	var machineId = $(this).data("machine-id");
	var updateData = $("#modal-manage-machines").data("update-data");
	var updateType = ($(this).hasClass("active") ? "add" : "remove");
	
	if ( updateData === undefined ) {
		updateData = {
			available: new Array(),
			selected: new Array()
		};
	}
	
	if ( updateType == "add" ) {
		updateData[type].push(machineId);
	} else {
		var index = $.inArray(machineId, updateData[type]);
		
		if ( index != -1 ) {
			updateData[type].splice(index, 1);
		}
	}
	
	$("#modal-manage-machines").data("update-data", updateData);
});

$("#modal-manage-machines .update-button").click(function(e) {
	var machineGroupId = $("#modal-manage-machines").data("machine-group-id");
	var updateData = $("#modal-manage-machines").data("update-data");
	var updateContainer = $("#modal-manage-machines").data("update-container");
	
	if ( updateData !== undefined && updateData["available"] !== undefined && updateData["selected"] !== undefined ) {
		$("#modal-manage-machines").modal("hide");
		$("#modal-loading").modal("show");
		
		$.ajax({
			url: baseurl + "machine_group/a_update_machines",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				update: JSON.stringify(updateData),
				machine_group_id: machineGroupId
			},
			success: function(data) {
				if ( !data.error ) {
					if ( updateContainer !== undefined ) {
						$(updateContainer).find(".total-machines").html(data.total_machines);
						$(updateContainer).find(".online-count").html(data.online_machines);
						$(updateContainer).find(".offline-count").html(data.offline_machines);
					}
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
	}
});

// Initialize the search textbox.
$("#modal-manage-machines input.search").typeWatch({
	wait: 500,
	highlight: true,
	captureLength: 2,
	callback: function(value) {
		var activeTab = $("#modal-manage-machines .nav-tabs li.active");
		
		if ( activeTab.length ) {
			var type = $(activeTab).data("type");
			var machineGroupId = $("#modal-manage-machines").data("machine-group-id");
			$("#modal-manage-machines .search-input .fa-search").addClass("hidden");
			$("#modal-manage-machines .search-input .fa-spinner").removeClass("hidden");
			
			loadMachineResult({
				machineGroupId: machineGroupId,
				resultType: type,
				keyword: value,
				context: $("#modal-manage-machines")
			}, function(data) {
				// Empty it.
				$(this).find(".content-" + type + " .result-blocks").empty();
				
				$("#modal-manage-machines .search-input .fa-search").removeClass("hidden");
				$("#modal-manage-machines .search-input .fa-spinner").addClass("hidden");
				
				renderListResult(type, data);
			});
		}
	}
});

// Initialize the slimscroll.
$("#modal-manage-machines [data-toggle='slimscroll']").each(function() {
	var options = $(this).data();
	
	$(this).slimScroll(options).bind("slimscroll", function(e, pos) {
		var moreRecords = $(this).data("more-records");
		
		if ( pos == "bottom" && moreRecords ) {
			// Load more result.
			var nextPage = $(this).data("next-page");
			var content = $(this).closest(".content");
			var contentType = ($(content).hasClass("content-available") ? "available" : "selected");
			var machineGroupId = $("#modal-manage-machines").data("machine-group-id");
			
			loadMachineResult({
				machineGroupId: machineGroupId,
				resultType: contentType,
				page: nextPage,
				context: $("#modal-manage-machines")
			}, function(data) {
				renderListResult(contentType, data);
			});
		}
	});
});