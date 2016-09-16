(function($) {
	$("#dropdown-machine-group").change(function(e) {
		var value = $(this).val();
		
		var url = baseurl + "user/overview?machine_group=" + encodeURIComponent(value);
		
		window.location = url;
	});
	
	$(document).on("chart.initialized", function(e, charts) {
		$("#user-session-weekly .list-group-item").click(function(e) {
			e.preventDefault();
			
			var chart = charts["user_sessions_statistic_weekly"];
			var machineGroup = $(this).data("machine-group");
			
			$(this).parent().find(".list-group-item").removeClass("active");
			$(this).addClass("active");
			
			$("#modal-loading").modal("show");
			
			$.ajax({
				url: baseurl + "user/a_user_sessions_weekly",
				type: "get",
				dataType: "json",
				data: {
					token: clientId,
					machine_group: machineGroup
				},
				success: function(data) {
					$("#top-active-profile-weekly .item-list").empty();
					
					// Redraw the google chart.
					var chartData = data["chart_data"];
					var d = new google.visualization.DataTable();
					var columns = $(".chart[data-name=user_sessions_statistic_weekly]").data("columns");
					var options = $(".chart[data-name=user_sessions_statistic_weekly]").data("options");
					
					if ( !chartData || !chartData.length ) {
						chartData = [];
					}
					
					if ( columns ) {
						for ( var i = 0; i < columns.length; i ++ ) {
							var col = columns[i];
							d.addColumn(col[0], col[1]);
						}
						
						d.addRows(chartData);
						
						chart.draw(d, options);
					}
					
					// Initialize the top active profile list.
					if ( data.top_user_list && data.top_user_list.length ) {
						for ( var i = 0; i < data.top_user_list.length; i ++ ) {
							var userData = data.top_user_list[i];
							var userName = userData["name"];
							var lastConnectedMachine = userData["last_connected_machine"];
							var li = $("<li></li>");
							var itemTitle = $("<span></span>").addClass("item-title").html(userName);
							var itemInfo = $("<span></span>").addClass("sub-line").html(lastConnectedMachine);
							$(li).append(itemTitle).append(itemInfo);
							
							$("#top-active-profile-weekly .item-list").append(li);
						}
						
						$("#top-active-profile-weekly .no-result").addClass("hidden");
					} else {
						$("#top-active-profile-weekly .no-result").removeClass("hidden");
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
		
		$("#user-session-monthly .list-group-item").click(function(e) {
			e.preventDefault();
			
			var chart = charts["user_sessions_statistic_monthly"];
			var machineGroup = $(this).data("machine-group");
			
			$(this).parent().find(".list-group-item").removeClass("active");
			$(this).addClass("active");
			
			$("#modal-loading").modal("show");
			
			$.ajax({
				url: baseurl + "user/a_user_sessions_monthly",
				type: "get",
				dataType: "json",
				data: {
					token: clientId,
					machine_group: machineGroup
				},
				success: function(data) {
					$("#top-active-profile-monthly .item-list").empty();
					
					// Redraw the google chart.
					var chartData = data["chart_data"];
					var d = new google.visualization.DataTable();
					var columns = $(".chart[data-name=user_sessions_statistic_monthly]").data("columns");
					var options = $(".chart[data-name=user_sessions_statistic_monthly]").data("options");
					
					if ( !chartData || !chartData.length ) {
						chartData = [];
					}
					
					if ( columns ) {
						for ( var i = 0; i < columns.length; i ++ ) {
							var col = columns[i];
							d.addColumn(col[0], col[1]);
						}
						
						d.addRows(chartData);
						
						chart.draw(d, options);
					}
					
					// Initialize the top active profile list.
					if ( data.top_user_list && data.top_user_list.length ) {
						for ( var i = 0; i < data.top_user_list.length; i ++ ) {
							var userData = data.top_user_list[i];
							var userName = userData["name"];
							var lastConnectedMachine = userData["last_connected_machine"];
							var li = $("<li></li>");
							var itemTitle = $("<span></span>").addClass("item-title").html(userName);
							var itemInfo = $("<span></span>").addClass("sub-line").html(lastConnectedMachine);
							$(li).append(itemTitle).append(itemInfo);
							
							$("#top-active-profile-monthly .item-list").append(li);
						}
						
						$("#top-active-profile-monthly .no-result").addClass("hidden");
					} else {
						$("#top-active-profile-monthly .no-result").removeClass("hidden");
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
	});
})(jQuery);