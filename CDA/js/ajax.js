$(function () {

    //On change employee Id button click
    $("#employee_id_form").submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var inputs = form.find("input, select, button, textarea");
        var serializedData = form.serialize();

       

            //Disable form input fields during the ajax p.s. disabled fields are not serializable
            inputs.prop("disabled", true);

            request = $.ajax({
                url: "ajax/set-employee-id",
                type: "post",
                data: serializedData
            });
            request.done(function (response, textStatus, jqXHR) {
                $('#employee_id').text(response);
            });
            request.fail(function (jqXHR, textStatus, errorThrown) {
                //todo: handle an error
            });
            request.always(function () {
                // Re-enable the inputs
                inputs.prop("disabled", false);
            });
        
    });


});
