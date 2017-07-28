/**
 * Created by iven on 2017/3/28.
 */
$(document).ready(function () {
    $('body').on('beforeSubmit', 'form#redirect-form', function () {
        var form = $(this);
        if (form.find('.has-error').length) {
            return false;
        }
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                if (response.success) {
                    $('#deliver-modal').modal('hide');
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