/**
 * Created by iven.wu on 2/1/2017.
 */


$('#submit-button').on('click', function () {
    $('.sts_form').each(function () {
        $(this).submit();
    });
});
$('.sts_form').each(function () {
    var form = $(this);
    $('body').on('beforeSubmit', 'form#' + form.attr('id'), function () {
        // form = $(this);
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
                $('#campaign-detail-content').append(response.Success+'<br>');
                $('#campaign-detail-modal').modal('show');
            }
        });
        return false;
    }).on('submit', function (e) {
        e.preventDefault();
    });
});

$('#campaign-detail-modal').on('hidden.bs.modal', function (e) {
    // do something...
    $(location).attr('href', '/deliver/create');
})

//$(document).ready(function($returnMsg){
//    $('#black-channel-content').append($returnMsg+'<br>');
//    $('#black-channel-modal').modal('show');
//});