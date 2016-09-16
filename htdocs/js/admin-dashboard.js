/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {

    $(".menu-invoke").click(function () {
        // Set Active Class
        $(".active").removeClass("active");
        $(this).addClass("active");

        var sidebar_id = $(this).attr("id");
        // Work Around for Maximum Call Stack Bug
        if (sidebar_id == 'add-lab') {
            if ($(this).hasClass("clicked")) {
                location.reload();
            } else {
                $(this).addClass("clicked");
            }
        }
        // Work Around End
        $("#dashboard-content").empty();
        $("#dashboard-content").load('dashboard/' + sidebar_id + '.html');

    });

    // Set sidebar arrow toggle
    $('[data-toggle=collapse]').click(function () {
        // toggle icon
        $(this).find(".arrowd").toggleClass("glyphicon-chevron-right glyphicon-chevron-down");
    });


    // Display default page
    var hash = window.location.hash.slice(1);
    if (hash == "") {
        $("#overview").click();
    } else {
        $("#" + hash).click();
    }
});

