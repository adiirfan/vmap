/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    // Populate lab side bar
    $.ajax({
        url: 'php/getLabName.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            for (i = 0; i < data.length; i++) {
                var button = $("<button>", {id: data[i].replace(/\s+/g, "-"), class: "list-group-item", type: "button"});
                button.text(data[i]);
                $('#scheduling-lab-list').append(button);
            }

            dp = 0;



            $("button.list-group-item").click(function () {
                scheduler.clearAll();
                var lab_id = $(this).text();
                lab_id = encodeURI(lab_id); // to encode special character
                console.log(lab_id);
                scheduler.load("php/connector.php?lab_id=" + lab_id);

                if (!dp) {
                    dp = new dataProcessor("php/connector.php?lab_id=" + lab_id);
                    dp.init(scheduler);
                    console.log('1');
                } else {
                    dp.serverProcessor = "php/connector.php?lab_id=" + lab_id;
                    console.log('2');
                }

                // Toggle Class
                $(".list-group-item-active").toggleClass("list-group-item-active");
                $(this).toggleClass("list-group-item-active");

            });
        }


    });

    scheduler.config.xml_date = "%Y-%m-%d %H:%i";
    scheduler.config.show_loading = true;

//    scheduler.config.lightbox.sections = [
//        {name: "description", height: 200, map_to: "text", type: "textarea", focus: true},
//        {name: "Booked", height: 50, map_to: "booked", type: "textarea", focus: true},
//        {name: "time", height: 72, type: "time", map_to: "auto"}
//    ];
    
    scheduler.init('scheduler_here', new Date(), "month");

//    scheduler.load("php/connector.php");
//
//    var dp = new dataProcessor("php/connector.php");
//    dp.init(scheduler);

//    
//        var events = [
//        {id: 1, text: "Meeting", start_date: "2016-01-20 14:00", end_date: "2016-01-20 19:00"},
//        {id: 2, text: "Conference", start_date: "2016-01-22 14:00", end_date: "2016-01-22 17:00"},
//        {id: 3, text: "Interview", start_date: "2016-01-24 14:00", end_date: "2016-01-24 16:00"}
//    ];
//
//    scheduler.parse(events, "json");//takes the name and format of the data source
});
