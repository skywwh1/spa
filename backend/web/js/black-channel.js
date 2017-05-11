/**
 * Created by iven.wu on 2/1/2017.
 */


$('#submit-button').on('click', function () {
    $('.black_channel_form').each(function () {
        //$(this).submit();
    });
});
$('.black_channel_form').each(function () {
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
                //console.log(JSON.stringify(response));
                //console.log(response);
                $('#black-channel-content').append(response+'<br>');
                $('#black-channel-modal').modal('show');
                //renderS2s();
                //location.href="/deliver/go-create";
            }
        });
        return false;
    }).on('submit', function (e) {
        e.preventDefault();
    });
});

$('#black-channel-modal').on('hidden.bs.modal', function (e) {
    //$(".modal-backdrop").remove();
    //$("body").removeClass('fade modal in');
    //$('#black-channel-modal').remove();
    $(this).modal('hide');
    $('#black-channel-modal').modal('hide');
    $('#black-channel-content').empty();

    renderS2s();
    //var t=setTimeout("renderS2s()",5000);
    return false;
});

function renderS2s(){
    var form = $('.black_channel_form');
    // do something...
    //$(location).attr('href', '/deliver/go-create');
    if (form.find('.has-error').length) {
        return false;
    }

    //console.log(form.serialize());
    form.attr("action", '/deliver/go-create');
    form.submit();
    //$('#black-channel-modal').modal('hide');
    //$(location).attr('href', '/deliver/go-create');
    //return false;
    //$.ajax({
    //    url: form.attr('action'),
    //    type: 'post',
    //    data: form.serialize(),
    //    success: function (response) {
    //        $(location).attr('href', '/deliver/go-create');
    //    }
    //});
}