(function($) {
	$("#dropdown-machine-group").change(function(e) {
		var value = $(this).val();
		
		var url = baseurl + "machine/overview?machine_group=" + encodeURIComponent(value);
		
		window.location = url;
	});
	
	$(".period .btn").click(function(e) {
		var parent = $(this).parent();
		var period = $(this).data("period");
		var machineGroup = $("#dropdown-machine-group").val();
		
		$(parent).find(".btn").removeClass("active");
		$(this).addClass("active");
		
		$("#modal-loading").modal("show");
		
		$.ajax({
			url: baseurl + "machine/a_load_machine_usage_data",
			type: "get",
			dataType: "json",
			data: {
				token: clientId,
				machine_group: machineGroup,
				period: period
			},
			success: function(data) {
				if ( data.error ) {
					alert(data.message);
				} else if ( data.data === undefined || data.data.data === undefined ) {
					$("#no-machine-usage-data").removeClass("hidden");
				} else {
					drawMachineUsage({
						data: data.data.data,
						columns: data.data.columns
					});
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
	
	var drawMachineUsage = function(machineUsageData) {
		// Hide the empty message first.
		$("#no-machine-usage-data").addClass("hidden");
		
		if ( machineUsageData && machineUsageData.data && machineUsageData.columns ) {
			var data = new google.visualization.DataTable();
			
			for ( var i in machineUsageData.columns ) {
				var columnData = machineUsageData.columns[i];
				data.addColumn(columnData[0], columnData[1]);
			}
			
			data.addRows(machineUsageData.data);
			
			var chart = new google.visualization.LineChart($("#chart-machine-usage").get(0));
			var options = {
				width: "100%",
				height: 244,
				pointSize: 5,
				legend: {
					position: "none"
				},
				chartArea: {
					width: "90%",
					height: "70%"
				}
			};
			
			chart.draw(data, options);
		} else {
			$("#no-machine-usage-data").removeClass("hidden");
		}
	};
	
	// Initialize the machine usage (top5) chart.
	$(document).on("chart.initialized", function(e, charts) {
		if ( window["machineUsageData"] !== undefined ) {
			drawMachineUsage(machineUsageData);
		} else {
			$("#no-machine-usage-data").removeClass("hidden");
		}
	});
})(jQuery);