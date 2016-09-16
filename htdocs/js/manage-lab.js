/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    $.ajax({
        url: 'php/get-overview.php',
        type: 'GET',
        dataType: 'json',
        //data: "parameter=some_parameter",
        success: function (data)
        {
            //alert('content of the executed page: ' + data);
            //var decode_data = jQuery.parseJSON(data);
            console.log(data);
            for (i = 0; i < data.lab_name.length; i++) {
                var table = document.getElementById("table-lab-body");
                var row = table.insertRow(i);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                cell1.className = "column-delete-checkbox";
                cell2.className = "column-delete-action";
                cell3.className = "column-delete-name";
                cell4.className = "column-delete-group";
                cell5.className = "column-delete-available";
                cell6.className = "column-delete-description";
                row.id = data.lab_name[i];
                var checktext = '<div class="checkbox"><label><input class="chk-delete" type="checkbox"></label></div>'

                // evaluating text for progress bar

                cell1.innerHTML = checktext;
                $("div>.button-edit-lab").clone(true).appendTo($(cell2));
                cell3.innerHTML = data.lab_name[i];
                cell4.innerHTML = data.lab_group[i];
                cell5.innerHTML = data.pc_avail[i] + '/' + data.pc_total[i];
                cell6.innerHTML = data.description[i];


            }

            // Populate Lab Grouping Select Tab
            for (j = 0; j < data.lab_group_distinct.length; j++) {
                $('#select-existing-lab').append('<option>' + data.lab_group_distinct[j] + '</option');
            }

            // toggle class of selected element
            $('.chk-delete').click(function () {
                $(this).closest('tr').toggleClass("highlight", this.checked);
                if ($('input:checkbox:checked').length > 0) {
                    $('#button-delete-map').removeAttr('disabled');
                } else {
                    $('#button-delete-map').attr('disabled', 'disabled');
                }
            });
        }
    });

    // Checking Box Initialization
    $("#button-check-all").click(function () {
        $("input:checkbox:not(:checked)").click();
    });
    // Unchecking Box Initialization
    $("#button-uncheck-all").click(function () {
        $("input:checkbox:checked").click();
    });

    /***Buttons to toggle Modal***/

    // Update Model Text for Edit Lab
    $(".button-edit-lab").click(function () {
        var $obj = $(this).closest('tr');
        var lab_name_old = $obj.find('.column-delete-name').text();
        var lab_group = $obj.find('.column-delete-group').text();
        var lab_description = $obj.find('.column-delete-description').text();

        // Append Texts To Modal
        $("#input-lab-name").val(lab_name_old);
        $("#input-lab-name").attr("data-old-name", lab_name_old);
        $("#input-lab-group").val(lab_group);
        $("#input-description").val(lab_description);

        $("#modal-edit-lab").modal('show');
    });

    // Update Model Text for Delete Lab
    $("#button-delete-map").click(function () {

        for (var i = 0; i < getChecked().length; i++) {
            $('#map-to-delete').append('<li>' + getChecked()[i] + '</li>');
        }
    });

    // Update Model Text for Grouping Lab
    $("#button-group-lab").click(function () {

        for (var i = 0; i < getChecked().length; i++) {
            $('#map-to-group').append('<li>' + getChecked()[i] + '</li>');
        }

    });

    /******************************/
    /***Buttons in Modal Confirm***/
    $("#button-confirm-edit-lab").click(function () {
        var lab_name_old = $("#input-lab-name").attr("data-old-name");
        var lab_name_new = $("#input-lab-name").val();
        var description = $("#input-description").val();

        $.ajax({
            url: 'php/edit-lab.php',
            type: 'POST',
            data: {
                lab_name_old: lab_name_old,
                lab_name_new: lab_name_new,
                description: description
            },
            //data: "parameter=some_parameter",
            success: function (data)
            {
                $('#modal-edit-lab').modal('hide');
                window.setTimeout(function () {
                    $("#manage-lab").click();
                }, 1000);
            }
        });

    });

    $("#button-confirm-group-lab").click(function () {
        var labToGroup = getChecked();
        var labGroup = [];

        var choice = $("#modal-body-group-lab input:radio:checked").val();
        if (choice == 'existing') {
            labGroup = $("#select-existing-lab option:selected").text();
        } else if (choice == 'new') {
            labGroup = $("#text-new-lab").val();
        }
        console.log(labGroup);
        console.log(labToGroup);

        $.ajax({
            url: 'php/group-lab.php',
            type: 'POST',
            data: {
                labGroup: labGroup,
                labToGroup: labToGroup
            },
            //data: "parameter=some_parameter",
            success: function (data)
            {
                $('#modal-group-lab').modal('hide');
                window.setTimeout(function () {
                    $("#manage-lab").click();
                }, 1000);
            }
        });
    });

    $("#button-confirm-delete").click(function () {
        var mapToDelete = getChecked();
        $.ajax({
            url: 'php/delete-map.php',
            type: 'POST',
            data: {
                mapToDelete: mapToDelete
            },
            //data: "parameter=some_parameter",
            success: function (data)
            {
//                alert(data);
                $('#modal-delete').modal('hide');
                window.setTimeout(function () {
                    $("#manage-lab").click();
                }, 1000);
            }
        });
    });
    /******************************/
    /***Modal Close Post Processing***/
    $('#modal-delete').on('hidden.bs.modal', function () {
        $("#map-to-delete>li").remove();
    });

    $('#modal-group-lab').on('hidden.bs.modal', function () {
        $("#map-to-group>li").remove();
    });
    /******************************/
});

function getChecked() {
    var idSelector = function () {
        return this.id;
    };
    var mapToDelete = $(":checkbox:checked").closest('tr').map(idSelector).get();
    return mapToDelete;
}



