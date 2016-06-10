$(function () {
    $("#route_loader_btn").on("click", function (e) {
        e.preventDefault();
        alert("The btn was clicked.");
    });

    

        $('#side_slider').click(function () {
        if ($(this).hasClass('show')) {
            $("#side_slider, #side_bar").animate({
                right: "+=285"
            }, 300, function () {
                // Animation complete.
            });
            $(this).removeClass('show').addClass('hide');
            $('.slider-array').html('&raquo;');
        }
        else {
            $("#side_slider, #side_bar").animate({
                right: "-=285"
            }, 300, function () {
                // Animation complete.
            });
            $(this).removeClass('hide').addClass('show');
            $('.slider-array').html('&laquo;');
        }
    });
});