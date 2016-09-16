
jQuery(document).ready(function () {

    /*
     Fullscreen background
     */
    $.backstretch("assets/img/backgrounds/1.jpg");

    /*
     Modals
     */
    $('.launch-modal').on('click', function (e) {
        e.preventDefault();
        $('#' + $(this).data('modal-id')).modal();
    });

    /*
     Form validation
     */
    $('.registration-form input[type="text"], .registration-form textarea').on('focus', function () {
        $(this).removeClass('input-error');
    });

    $('.registration-form').on('submit', function (e) {

        $(this).find('input[type="text"], textarea').each(function () {
            if ($(this).val() == "") {
                e.preventDefault();
                $(this).addClass('input-error');
            } else {
                $(this).removeClass('input-error');
            }
        });

    });


    $('.registration-form').on('submit', function (e) {

        $(this).find('input[type="password"], textarea').each(function () {
            if ($(this).val() == "") {
                e.preventDefault();
                $(this).addClass('input-error');
            } else {
                $(this).removeClass('input-error');
            }
        });

    });

    $(function () {

        $(".dropdown-menu li a").click(function () {

            $(".btn.btn-default:first-child").text($(this).text());
            $(".btn.btn-default:first-child").val($(this).text());

        });

    });

    // Disable form submitting, using ajax instead
    $('.registration-form').submit(false);

});

$("#admin-login").click(function () {
    if ($("#form-password1").val() == "") {
        return;
    }
    if ($("#form-username1").val() == "") {
        return;
    }
    $.ajax({
        type: "POST",
        url: "assets/php/process.php",
        data: {
            username: $("#form-username1").val(),
            password: $("#form-password1").val()
        },
        success: function (data) {
            console.log(data);
            if (data == 1) {
                $("#login-failed").css("display", "none");
                location.href = "../admin-dashboard.php";
            } else {
                $("#login-failed").css("display", "block");
            }
        }
    });
});
