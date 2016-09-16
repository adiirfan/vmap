/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
$(function () {

    fadeTime = 500;
    $.mobile.loading().hide();

    $.ajax({
        url: 'php/getLabName.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
			var tech = getUrlParameter('map');
			if(tech){
            for (i = 0; i < data.length; i++) {
                var $li = $("<li>", {id: data[i].replace(/\s+/g, "-"), class: "select-map"});
                $li.append('<a class="dropdown-lab" href="/demo/" target="_self">' + data[i] + '</a>');
                $('#map-dropdown').append($li);
            }}else{for (i = 0; i < data.length; i++) {
                var $li = $("<li>", {id: data[i].replace(/\s+/g, "-"), class: "select-map"});
			$li.append('<a class="dropdown-lab" href="#">' + data[i] + '</a>');
                $('#map-dropdown').append($li);
            }}
            displayMap();
            $("#map-dropdown>li:first-child").click(); // Trigger a click event to display default map
//       $("#" + "CloudDesk").click(); // Trigger click by Name
        }


    });

    //Initializing Doughnut Chart
    chartInit();

    // Populate Progress Bars
    populateProgress();

    // Initialized Progress Bar button click
    displayMapByBar();

    // Initialize Kiosk Mode button click
    $("#kiosk").click(function () {
        toggleFullScreen();
    });

    // Initialize Scheduling Variable
    arrayTime = [];
    $('tr').each(function(index){
        arrayTime[index] =$(this).data("schedule");
    });
    
//    scheduler.config.xml_date = "%Y-%m-%d %H:%i";
//    scheduler.config.show_loading = true;
//    scheduler.init('scheduler_here', new Date(), "day");

    // Kiosk Mode Action
    $(document).on('webkitfullscreenchange mozfullscreenchange fullscreenchange MSFullscreenChange', function () {
        toggleModeText();
        toggleSelectMap();

    });

    // Swipe Gesture
    $("#display-map").on("swipeleft", function () {
        console.log('left');
        fadeTime = 200;
        displayNextMap();

    });
    $("#display-map").on("swiperight", function () {
        console.log('right');
        fadeTime = 200;
        displayPreviousMap();

    });


});


function displayMap() {
    $(".select-map").click(function () {
        map_counter = ($("li").index(this));
//        var lab_id = $(this).attr("id").replace(/-/g, ' ');
//        $("#lab-name").text(lab_id); // Set the LabName in Main Page
		var tech = getUrlParameter('map');
		if(tech){
        var lab_id = tech;
		}
		else{
		var lab_id = $(this).find('.dropdown-lab').text();
		}
        $("#lab-name").text(lab_id);
		
        $.ajax({
            url: 'php/getLabMap.php',
            type: 'POST',
            dataType: 'html',
            data: {
                lab_id: lab_id
            },
            success: function (data) {
//                document.getElementById('display-map').innerHTML = data;
                $("#display-map").fadeOut(fadeTime, function () {
                    $("#display-map").html(data).fadeIn(fadeTime).find('.PC-icon').each(function(){
						
						var id = $(this).attr('id');
						$(this).tooltipster({
							content: "Loading ...",
							contentAsHTML:true, 
							 multiple: true,
							functionBefore: function(instance, helper) {
        
								var $origin = $(helper.origin);
								
								// we set a variable so the data is only loaded once via Ajax, not every time the tooltip opens
								if ($origin.data('loaded') !== true) {

									$.get('php/pc_name.php?pc='+id, function(data) {

										// call the 'content' method to update the content of our tooltip with the returned data
										//instance.content(data);
										
										// var content1 = instance.content(data),
											people = JSON.parse(data),
											
											
											// and use it to make a sentence
											newContent = 'PC name :'+people.pc.computer_name+'<br> IP :' + people.pc.comp_ip + ' <br>Status : '+ people.status + ' <br><br> '+
											people.lab_label.text+ people.lab.text + 
											people.lab_label.start_date+ people.lab.start_date +
											people.lab_label.end_date+ people.lab.end_date+
											people.label.student_name+ people.student.student_name + 
											people.label.start_booking+ people.student.start_booking +
											people.label.end_booking+ people.student.end_booking;
										
										// save the edited content
										instance.content(newContent);
										

										// to remember that the data has been loaded
										$origin.data('loaded', true);
									});
								}
							}
						
						});
					});;	
						
						
                    updateMap(lab_id, 0.2);
                });
                fadeTime = 500; // reset fade timer
//                $("#display-map").html(data).fadeIn(1000);
                // Map will auto-refresh every 5 min
            }


        });

    });
}

function populateProgress() {
    $.ajax({
        url: 'php/progress-bars.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data.lab_group);

            for (i = 0; i < data.lab_group.length; i++) {
                $("#hidden-bar-level1>.list-group-item").clone(true).appendTo('#list-progress');
                var elem = $('#list-progress>li').last();
                $(elem).attr('id', 'progress-group-' + data.lab_group[i].replace(/\s+/g, "-"));
                $(elem).find(".lab-name-text").text(data.lab_group[i]);
                $(elem).find(".progress-group").attr('href', '#collapse' + i);
                $(elem).find(".progress-group").attr('aria-controls', 'collapse' + i);

                $(elem).append('<div class="collapse" id="collapse' + i + '"> <ul class="list-group"> </ul> </div>')

                // Populate 2nd Level of Progress Bar
                $.ajax({
                    url: 'php/progress-bars-level2.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        lab_group: data.lab_group[i],
                        index: i
                    },
                    success: function (data) {
                        console.log(data);
                        var selector = "#collapse" + data.index + ">ul";

                        for (j = 0; j < data.lab_name.length; j++) {
                            $("#hidden-bar-level2>.list-group-item").clone(true).appendTo(selector);
                            var elem2 = $(selector + '>li').last();
                            $(elem2).attr('id', 'progress-lab-' + data.lab_name[j].replace(/\s+/g, "-"));
                            $(elem2).find(".lab-name-text").text(data.lab_name[j]);
                        }
                    }
                });

            }
        }

    });
}

function chartInit() {
    Chart.defaults.global.responsive = true;

    Chart.defaults.Doughnut = {
        // Boolean - Whether to animate the chart
        animation: true,
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke: true,
        //String - The colour of each segment stroke
        segmentStrokeColor: "#fff",
        //Number - The width of each segment stroke
        segmentStrokeWidth: 2,
        //Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 0, // This is 0 for Pie charts

        //Number - Amount of animation steps
        animationSteps: 50,
        //String - Animation easing effect
        animationEasing: "easeOutBounce",
        //Boolean - Whether we animate the rotation of the Doughnut
        animateRotate: true,
        //Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale: true,
        //String - A legend template
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
    };

    var idall = document.getElementById("doughnut-all").getContext("2d");
    var idcurrent = document.getElementById("doughnut-current").getContext("2d");
    var pieData = [
        {
            value: 1,
           // color: "#C8C8C8",
			color: "#3b3a49",
            label: 'Off'
        },
        {
            value: 1,
           // color: "#f39c12",
			color: "#f3ec63",
            label: 'Booked'
        },
        {
            value: 1,
           // color: "#dd4b39", 
			color: "#ef4949",
            label: 'Busy'
        },
        {
            value: 1,
            //color: "#00a65a",
			color: "#69c296",
            label: 'Free'
        }
    ];

    allChart = new Chart(idall).Doughnut(pieData);
    currentChart = new Chart(idcurrent).Doughnut(pieData);
}

function toggleFullScreen() {
    if ((document.fullScreenElement && document.fullScreenElement !== null) ||
            (!document.mozFullScreen && !document.webkitIsFullScreen)) {
        if ($("#kiosk").hasClass("kiosk-on")) {

        } else {
            $("#kiosk").toggleClass("kiosk-on kiosk-off");
        }
        if (document.documentElement.requestFullScreen) {
            document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
            document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if ($("#kiosk").hasClass("kiosk-off")) {

        } else {
            $("#kiosk").toggleClass("kiosk-on kiosk-off");
        }
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }

}

function toggleModeText() {
    if ($('#kiosk').hasClass("kiosk-on")) {
        $('#kiosk').text("Browser Mode");
    } else {
        $('#kiosk').text("Kiosk Mode");
    }
}
;

function toggleSelectMap() {
    if ($('#kiosk').hasClass("kiosk-on")) {
        $('#dropdown-select-map').hide();
        intervalhandler = setInterval(displayNextMap, 5000);
    } else {
        $('#dropdown-select-map').show();
        clearInterval(intervalhandler);
    }
}

function displayNextMap() {
    var num_map = $("#map-dropdown>li").size();
    var map2click = [];
    if (map_counter % num_map) {
        map2click = map_counter + 1;
    } else {
        map2click = 1;
    }

    var clickstr = '#map-dropdown>li:nth-child(' + map2click + ')';
    $(clickstr).click();
}

function displayPreviousMap() {
    var num_map = $("#map-dropdown>li").size();
    var map2click = [];
    if (map_counter != 1) {
        map2click = map_counter - 1;
    } else {
        map2click = num_map;
    }

    var clickstr = '#map-dropdown>li:nth-child(' + map2click + ')';
    $(clickstr).click();
}
//function displayMapBySwipe(direction) {
//    var num_map = $("#map-dropdown>li").size();
//    var map2click = [];
//
//    if (direction == 'left') {
//        map2click = map_counter + 1;
//        if (map2click == 0){
//            map2click = num_map;
//        }
//
//    } else if (direction == 'right') {
//        
//    }
//}
function displayMapByBar() {
    $(".list-level2").click(function () {
        var labname_dashed = $(this).find(".lab-name-text").text().replace(/\s+/g, "-");
        $("#" + labname_dashed).click();
    });
}