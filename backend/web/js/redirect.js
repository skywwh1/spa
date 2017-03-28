/**
 * Created by iven on 2017/3/28.
 */
$(document).ready(function () {
    $('body').on('beforeSubmit', 'form#redirect-form', function () {
        var form = $(this);
        // return false if form still have some validation errors
        if (form.find('.has-error').length) {
            return false;
        }
        // submit form
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                // var getupdatedata = $(response).find('#filter_id_test');
                // $.pjax.reload('#note_update_id'); for pjax update
                //$('#yiiikap').html(getupdatedata);
                if (response.success) {
                    $('#deliver-modal').modal('hide');
                    console.log($('#deliver-modal'));
                    console.log(response);
                } else {
                    alert(response);
                }
            },
            error: function () {
                console.log('internal server error');
            }
        });
        return false;
    });
});