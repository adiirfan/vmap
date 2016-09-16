/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$.ajax({
    url: 'php/get-overview.php',
    type: 'GET',
    dataType: 'json',
    //data: "parameter=some_parameter",
    success: function (data)
    {
	if (data.expiry == 1){
		
			
	

				$(function () {
					
					global = 0;
					

					// Enable tooltip CSS
					$('[data-toggle="tooltip"]').tooltip();

					$('#button-erase-map').click(function () {
						// Erase the MAP
						$("#frame .PC-icon").remove();
						$("#frame .mapObject").remove();
						$("#frame").css("background-image", "");
						// Reset Object Counter
						counter = 0;
						PC_counter = 0;
						obj_counter = 0;
					});

					// Load Map Modal
					$('#button-load-map').click(function () {

						$.ajax({
							url: 'php/getLabName.php',
							type: 'GET',
							dataType: 'json',
							success: function (data) {
								for (i = 0; i < data.length; i++) {
									$("#select-load-map").append('<option>' + data[i] + '</option>');
								}

								$('#modal-load-map').modal('show');
							}
						});
					});

					$('#modal-load-map').on('hidden.bs.modal', function () {
						$("#select-load-map option").remove();
					});

					$('#button-confirm-load-map').click(function () {
						$("#button-erase-map").click();
						var labname = $("#select-load-map option:selected").text();
						$("#labTextBox").val(labname);
						$.ajax({
							url: 'php/load-map.php',
							type: 'GET',
							data: {
								labname: labname
							},
							dataType: 'json',
							success: function (data)
							{
								console.log(data);

								var $element = $(data);

								$('#dummy').append($element.html());
								$("#dummy .ui-resizable-handle").remove();
								$("#dummy div").each(function () {
									$(this).addClass("loaded-icon");
								});
								$("#frame").append($("#dummy").html());
								$("#frame .loaded-icon").each(function () {
									existDraggable(this);
									showID(this);
									counter++;
									if ($(this).hasClass("PC-icon")) {
										PC_counter++;
									} else if ($(this).hasClass("mapObject"))
										obj_counter++;
								});
								$("#frame").css("background-image", $element.css("background-image"));
								$("#dummy").empty();
								$('#modal-load-map').modal('hide');

							}
						});
					});
				//################### DRAG AND DROP MODULE ######################/?
					//Counter

					rev_flag = 0;
					PC_counter = 0;
					obj_counter = 0;
					testing = 0;
					$.ajax({
					url: 'php/get-overview.php',
					type: 'GET',
					dataType: 'json',
					//data: "parameter=some_parameter",
					success: function (data)
					{
						 PC_counter = 0 + data.count;
						counter = data.count;
						//alert('content of the executed page: ' + data);
						//var decode_data = jQuery.parseJSON(data);
						console.log(data);
						if (data.count > data.max){
							
						window.alert("Anda Mencapai Limit");
							
						}else{

					//Make element draggable
					$(".drag").draggable({
						helper: function () {
							var helper = $(this).clone();
				//            helper.css("z-index",100);
							return helper;
						},
						containment: 'frame',
						cursor: "move",
						stack: ".drag",
						zIndex: 100,
						revert: function (is_valid_drop) {
							if (!is_valid_drop) {
								console.log("revert triggered");
								rev_flag = 1;
								return true;
							} else {
								rev_flag = 0;
							}
						}
						,
						//When first dragged
						stop: function (ev, ui) {
							if (!rev_flag) {
								var pos = $(ui.helper).offset();
								objName = ".clonediv" + counter;

								// Adjusting offset because of the VMAP formatting
								// Container is relative and icons are absolute
								var offsets = $('#frame').offset();
								var off_top = offsets.top;
								var off_left = offsets.left;


								$(objName).css({"left": pos.left - off_left, "top": pos.top - off_top});

								// Convert Px to %
								$(objName).css("left", parseInt($(objName).css("left")) / ($("#frame").width() / 100) + "%");
								$(objName).css("top", parseInt($(objName).css("top")) / ($("#frame").height() / 100) + "%");
								$(objName).css("width", parseInt($(objName).css("width")) / ($("#frame").width() / 100) + "%");
								$(objName).css("height", parseInt($(objName).css("height")) / ($("#frame").height() / 100) + "%");
								$(objName).removeClass("drag");
				//
								//var pc_name = prompt("Enter computer name", "PC" + counter);
								//Open the dialog box when the button is clicked.
								if ($(ui.helper).hasClass("PC-icon")) {
									$("#pcDialog").dialog("open");
									$(objName).addClass("PC-icon");
									$(objName).css("z-index", 1000);
									// Check draggable is PC or MAC icon
									if ($(ui.helper).hasClass("PC")) {
										$(objName).addClass("PC");
									} else if ($(ui.helper).hasClass("MAC")) {
										$(objName).addClass("MAC");
									}
									showID(objName);
								} else {
									$(objName).attr("id", "mapObject" + obj_counter);
									$(objName).addClass("mapObject");
								}

								//When an existing object is dragged               
								existDraggable(objName);
							}
						}
					});
					};
					

					//Make element droppable
					$("#frame").droppable({
						drop: function (ev, ui) {
							
							try {// Prevent dialog box from prompting error
								
								if (ui.helper.attr('id').search(/drag[0-9]+/) != -1) {
									counter++;
									if ($(ui.helper).hasClass("PC-icon")) {
										PC_counter++;
									} else {
										obj_counter++;
										
									}
									if (PC_counter > data.max){
							
									
									window.alert("Anda Telah Mencapai Limit Account anda");
									testing++;
									document.getElementById("pcDialog").setAttribute("id", "pcDialog2");
									
									}else{
									
									var element = $(ui.draggable).clone();
									element.addClass("tempclass");
									$(this).append(element);
									$(".tempclass").attr("class", "clonediv" + counter)

									$(".clonediv" + counter).removeClass("tempclass");

									//Get the dynamically item id
									draggedNumber = ui.helper.attr('id').search(/drag([0-9])+/);
									itemDragged = "dragged" + ui.helper.attr('id').replace("drag", '');
									console.log(itemDragged);
									$(".clonediv" + counter).addClass(itemDragged);
									$(".clonediv" + counter).removeAttr('id'); // Remove Original ID
									if (ui.helper.hasClass('PC')) {
										$(".clonediv" + counter).addClass('PC-status-off');
									} else if (ui.helper.hasClass('MAC')) {
										$(".clonediv" + counter).addClass('MAC-status-off');
									}
								}
								}
							} catch (err) {
								console.log(err);
							}
						}
					});

					$("#bin").droppable({
						accept: function (d) {
							console.log();
							if (d.attr('class').search(/clonediv[0-9]+/) != -1) {
								return true;
							}
						},
						activeClass: "bin-highlight",
						drop: function (ev, ui) {
							$(ui.draggable).remove();
						}

					});
					}
					});
					
				//######################## DRAG AND DROP MODULE END ##########################//
					
					$("#frame").resizable({
						aspectRatio: true
					});

					
					$("#pcDialog").dialog({
						autoOpen: false,
						modal: true,
						closeOnEscape: false,
						title: "Computer Name",
						open: function (ev, ui) {
							$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
							$('#pcTextBox').val("PC" + PC_counter);
							$("#pcTextBox").trigger("keypress");
						},
						buttons: {
							'OK': {
								text : 'OK',
								id: "confirm-pc-name",
								click: function () {
									if ($('#pcTextBox').val()) { //if textbox not empty
										$(".clonediv" + counter).attr("id", $('#pcTextBox').val());
									} else { // if textbox is empty
										$(".clonediv" + counter).attr("id", "PC" + PC_counter);
									}


									$(this).dialog('close');

								}
							}

						}
					});
					
					
					
					// Check ID availability for Each PC
					$("#pcTextBox").bind('input keypress', function () {
						var idToCheck = $("#pcTextBox").val();
						$.ajax({
							url: 'php/check-id-availability.php',
							type: 'GET',
							data: {
								idToCheck: idToCheck
							},
							success: function (data) {
								console.log(data);
								if (data == 0) {
									// Not available
									$("#confirm-pc-name").attr("disabled", true);
									$('#id-availability').text("ID is unavailable, Duplicate ID not allowed");
								} else {
									// Available
									$( "#confirm-pc-name" ).attr("disabled", false);
									$('#id-availability').text("ID is available");

								}


							}
						});
					});
					

					//Set up the lab name dialog box
					$("#labDialog").dialog({
						autoOpen: false,
						modal: true,
						title: "Lab Name",
						open: function (ev, ui) {
							if (!($('#labTextBox').val())) {
								$('#labTextBox').val("My_Virtual_Map");
							}
						},
						buttons: {
							'OK': function () {
								if (!($('#labTextBox').val())) { //if textbox is empty
									$('#labTextBox').val("My_Virtual_Map_" + Math.floor((Math.random() * 100) + 1)); // Get a random number between 1-100
								}
								saveMap();
								$(this).dialog('close');

							}
						}
					});

					// Select menu in dialog box
					// initialize select menu after dialog so selecetmenu has higher z-index
					$("#lab-group").selectmenu({
						create: function (event, ui) {
							$('.ui-selectmenu-menu').css({'overflow': 'auto'});
						}
					});
					$.ajax({
						url: 'php/get-overview.php',
						type: 'GET',
						dataType: 'json',
						//data: "parameter=some_parameter",
						success: function (data)
						{
							// Populate Lab Grouping Select Tab
							for (j = 0; j < data.lab_group_distinct.length; j++) {
								$('#lab-group').append('<option>' + data.lab_group_distinct[j] + '</option');
							}
							$("#lab-group").selectmenu("refresh");

						}
					});



				});

				// Custom functions
				function existDraggable(objName) {
					console.log(objName)
					$(objName).draggable({
						containment: '#frame #bin',
						revert: 'invalid',
						cursor: "move",
						stop: function (ev, ui) {
							var pos = $(ui.helper).offset();
							console.log($(this).attr("class"));
							console.log(pos.left);
							console.log(pos.top);

							// Convert Px to %
							$(this).css("left", parseInt($(this).css("left")) / ($("#frame").width() / 100) + "%");
							$(this).css("top", parseInt($(this).css("top")) / ($("#frame").height() / 100) + "%");
						}
					});
				}
	}else{
		
	

						$(function () {
							
							global = 0;
							

							// Enable tooltip CSS
							$('[data-toggle="tooltip"]').tooltip();

							$('#button-erase-map').click(function () {
								// Erase the MAP
								$("#frame .PC-icon").remove();
								$("#frame .mapObject").remove();
								$("#frame").css("background-image", "");
								// Reset Object Counter
								counter = 0;
								PC_counter = 0;
								obj_counter = 0;
							});

							// Load Map Modal
							$('#button-load-map').click(function () {

								$.ajax({
									url: 'php/getLabName.php',
									type: 'GET',
									dataType: 'json',
									success: function (data) {
										for (i = 0; i < data.length; i++) {
											$("#select-load-map").append('<option>' + data[i] + '</option>');
										}

										$('#modal-load-map').modal('show');
									}
								});
							});

							$('#modal-load-map').on('hidden.bs.modal', function () {
								$("#select-load-map option").remove();
							});

							$('#button-confirm-load-map').click(function () {
								$("#button-erase-map").click();
								var labname = $("#select-load-map option:selected").text();
								$("#labTextBox").val(labname);
								$.ajax({
									url: 'php/load-map.php',
									type: 'GET',
									data: {
										labname: labname
									},
									dataType: 'json',
									success: function (data)
									{
										console.log(data);

										var $element = $(data);

										$('#dummy').append($element.html());
										$("#dummy .ui-resizable-handle").remove();
										$("#dummy div").each(function () {
											$(this).addClass("loaded-icon");
										});
										$("#frame").append($("#dummy").html());
										$("#frame .loaded-icon").each(function () {
											existDraggable(this);
											showID(this);
											counter++;
											if ($(this).hasClass("PC-icon")) {
												PC_counter++;
											} else if ($(this).hasClass("mapObject"))
												obj_counter++;
										});
										$("#frame").css("background-image", $element.css("background-image"));
										$("#dummy").empty();
										$('#modal-load-map').modal('hide');

									}
								});
							});
						//################### DRAG AND DROP MODULE ######################/?
							//Counter

							rev_flag = 0;
							PC_counter = 0;
							obj_counter = 0;
							testing = 0;
							$.ajax({
							url: 'php/get-overview.php',
							type: 'GET',
							dataType: 'json',
							//data: "parameter=some_parameter",
							success: function (data)
							{
								 PC_counter = 0 + data.count;
								counter = data.count;
								//alert('content of the executed page: ' + data);
								//var decode_data = jQuery.parseJSON(data);
								console.log(data);
								if (data.count > 30){
									
								window.alert('anda telah mencapai limit');
									
								}else{

							//Make element draggable
							$(".drag").draggable({
								helper: function () {
									var helper = $(this).clone();
						//            helper.css("z-index",100);
									return helper;
								},
								containment: 'frame',
								cursor: "move",
								stack: ".drag",
								zIndex: 100,
								revert: function (is_valid_drop) {
									if (!is_valid_drop) {
										console.log("revert triggered");
										rev_flag = 1;
										return true;
									} else {
										rev_flag = 0;
									}
								}
								,
								//When first dragged
								stop: function (ev, ui) {
									if (!rev_flag) {
										var pos = $(ui.helper).offset();
										objName = ".clonediv" + counter;

										// Adjusting offset because of the VMAP formatting
										// Container is relative and icons are absolute
										var offsets = $('#frame').offset();
										var off_top = offsets.top;
										var off_left = offsets.left;


										$(objName).css({"left": pos.left - off_left, "top": pos.top - off_top});

										// Convert Px to %
										$(objName).css("left", parseInt($(objName).css("left")) / ($("#frame").width() / 100) + "%");
										$(objName).css("top", parseInt($(objName).css("top")) / ($("#frame").height() / 100) + "%");
										$(objName).css("width", parseInt($(objName).css("width")) / ($("#frame").width() / 100) + "%");
										$(objName).css("height", parseInt($(objName).css("height")) / ($("#frame").height() / 100) + "%");
										$(objName).removeClass("drag");
						//
										//var pc_name = prompt("Enter computer name", "PC" + counter);
										//Open the dialog box when the button is clicked.
										if ($(ui.helper).hasClass("PC-icon")) {
											$("#pcDialog").dialog("open");
											$(objName).addClass("PC-icon");
											$(objName).css("z-index", 1000);
											// Check draggable is PC or MAC icon
											if ($(ui.helper).hasClass("PC")) {
												$(objName).addClass("PC");
											} else if ($(ui.helper).hasClass("MAC")) {
												$(objName).addClass("MAC");
											}
											showID(objName);
										} else {
											$(objName).attr("id", "mapObject" + obj_counter);
											$(objName).addClass("mapObject");
										}

										//When an existing object is dragged               
										existDraggable(objName);
									}
								}
							});
							};
							

							//Make element droppable
							$("#frame").droppable({
								drop: function (ev, ui) {
									
									try {// Prevent dialog box from prompting error
										
										if (ui.helper.attr('id').search(/drag[0-9]+/) != -1) {
											counter++;
											if ($(ui.helper).hasClass("PC-icon")) {
												PC_counter++;
											} else {
												obj_counter++;
												
											}
											if (PC_counter > 30){
									
											
											window.alert("Anda Telah Mencapai Limit Account anda");
											testing++;
											document.getElementById("pcDialog").setAttribute("id", "pcDialog2");
											
											}else{
											
											var element = $(ui.draggable).clone();
											element.addClass("tempclass");
											$(this).append(element);
											$(".tempclass").attr("class", "clonediv" + counter)

											$(".clonediv" + counter).removeClass("tempclass");

											//Get the dynamically item id
											draggedNumber = ui.helper.attr('id').search(/drag([0-9])+/);
											itemDragged = "dragged" + ui.helper.attr('id').replace("drag", '');
											console.log(itemDragged);
											$(".clonediv" + counter).addClass(itemDragged);
											$(".clonediv" + counter).removeAttr('id'); // Remove Original ID
											if (ui.helper.hasClass('PC')) {
												$(".clonediv" + counter).addClass('PC-status-off');
											} else if (ui.helper.hasClass('MAC')) {
												$(".clonediv" + counter).addClass('MAC-status-off');
											}
										}
										}
									} catch (err) {
										console.log(err);
									}
								}
							});

							$("#bin").droppable({
								accept: function (d) {
									console.log();
									if (d.attr('class').search(/clonediv[0-9]+/) != -1) {
										return true;
									}
								},
								activeClass: "bin-highlight",
								drop: function (ev, ui) {
									$(ui.draggable).remove();
									PC_counter--;
								}

							});
							}
							});
							
						//######################## DRAG AND DROP MODULE END ##########################//
							
							$("#frame").resizable({
								aspectRatio: true
							});

							
							$("#pcDialog").dialog({
								autoOpen: false,
								modal: true,
								closeOnEscape: false,
								title: "Computer Name",
								open: function (ev, ui) {
									$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
									$('#pcTextBox').val("PC" + PC_counter);
									$("#pcTextBox").trigger("keypress");
								},
								buttons: {
									'OK': {
										text : 'OK',
										id: "confirm-pc-name",
										click: function () {
											if ($('#pcTextBox').val()) { //if textbox not empty
												$(".clonediv" + counter).attr("id", $('#pcTextBox').val());
											} else { // if textbox is empty
												$(".clonediv" + counter).attr("id", "PC" + PC_counter);
											}


											$(this).dialog('close');

										}
									}

								}
							});
							
							
							
							// Check ID availability for Each PC
							$("#pcTextBox").bind('input keypress', function () {
								var idToCheck = $("#pcTextBox").val();
								$.ajax({
									url: 'php/check-id-availability.php',
									type: 'GET',
									data: {
										idToCheck: idToCheck
									},
									success: function (data) {
										console.log(data);
										if (data == 0) {
											// Not available
											$("#confirm-pc-name").attr("disabled", true);
											$('#id-availability').text("ID is unavailable, Duplicate ID not allowed");
										} else {
											// Available
											$( "#confirm-pc-name" ).attr("disabled", false);
											$('#id-availability').text("ID is available");

										}


									}
								});
							});
							

							//Set up the lab name dialog box
							$("#labDialog").dialog({
								autoOpen: false,
								modal: true,
								title: "Lab Name",
								open: function (ev, ui) {
									if (!($('#labTextBox').val())) {
										$('#labTextBox').val("My_Virtual_Map");
									}
								},
								buttons: {
									'OK': function () {
										if (!($('#labTextBox').val())) { //if textbox is empty
											$('#labTextBox').val("My_Virtual_Map_" + Math.floor((Math.random() * 100) + 1)); // Get a random number between 1-100
										}
										saveMap();
										$(this).dialog('close');

									}
								}
							});

							// Select menu in dialog box
							// initialize select menu after dialog so selecetmenu has higher z-index
							$("#lab-group").selectmenu({
								create: function (event, ui) {
									$('.ui-selectmenu-menu').css({'overflow': 'auto'});
								}
							});
							$.ajax({
								url: 'php/get-overview.php',
								type: 'GET',
								dataType: 'json',
								//data: "parameter=some_parameter",
								success: function (data)
								{
									// Populate Lab Grouping Select Tab
									for (j = 0; j < data.lab_group_distinct.length; j++) {
										$('#lab-group').append('<option>' + data.lab_group_distinct[j] + '</option');
									}
									$("#lab-group").selectmenu("refresh");

								}
							});



						});

						// Custom functions
						function existDraggable(objName) {
							console.log(objName)
							$(objName).draggable({
								containment: '#frame #bin',
								revert: 'invalid',
								cursor: "move",
								stop: function (ev, ui) {
									var pos = $(ui.helper).offset();
									console.log($(this).attr("class"));
									console.log(pos.left);
									console.log(pos.top);

									// Convert Px to %
									$(this).css("left", parseInt($(this).css("left")) / ($("#frame").width() / 100) + "%");
									$(this).css("top", parseInt($(this).css("top")) / ($("#frame").height() / 100) + "%");
								}
							});
						}
	}
	}
	 });
function saveMap() {
    var element = $('#frame').clone();
    element = element.removeClass(); // remove class styling in frame\

    // Removing absolute value for height and width. Preserve aspect ratio\
    // We use frame here because clone do not have CSS styles
    var asp_ratio = $('#frame').height() / $('#frame').width() * 100;
    console.log('height is ' + $('#frame').height());
    console.log('width is ' + $('#frame').width());
    console.log('Aspect ratio is ' + asp_ratio + '%');
    element.css("padding-bottom", asp_ratio + '%');
    element.css("height", "");
    element.css("width", "");


    var maptext = element[0].outerHTML; //use .html() for content inside division
    var labname = $('#labTextBox').val(); // Get lab name
    var labgroup = $('#lab-group option:selected').text(); //Get Lab Group
    var pc_ids = getIDwithClass("PC-status-off", "#frame > div"); // Get PC ids
    var mac_ids = getIDwithClass("MAC-status-off", "#frame > div"); // Get PC ids
    $.ajax({
        url: 'php/savemap.php',
        type: 'POST',
        data: {
            maptext: maptext,
            labname: labname,
            labgroup: labgroup,
            pc_ids: pc_ids,
            mac_ids: mac_ids
        },
        success: function (data) {
            $("#text-save-map").html(data);
            $("#modal-save-map").modal('show');

        }
    });
}

function getIDwithClass(className, selectorObject) {
    // className : class to get ID
    // selectorObject : selector to search className
    var i = 0;
    var ids = [];
    $(selectorObject).each(function () {
        if ($(this).hasClass(className)) {
            ids[i++] = $(this).attr("id");
            console.log($(this).attr("id"));
        }

    });
    return ids;
}

// Prompt Object to show id when hover
function showID(object) {
    $(object).hover(
            function () {
                var pc_name = $(this).attr('id');
                $(this).append($("<span class = \"pc-name\">" + pc_name + "</span>"));
            },
            function () {
                $(this).find("span:last").remove();
            }
    );

}

