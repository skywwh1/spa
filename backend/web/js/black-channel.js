/**
 * Created by iven.wu on 2/1/2017.
 */
$('#submit-button').on('click', function () {
    $('.black_channel_form').each(function () {
        $(this).submit();
    });
});
$('.black_channel_form').each(function () {
    var form = $(this);
    $('body').on('beforeSubmit', 'form#' + form.attr('id'), function () {
        if (form.find('.has-error').length) {
            return false;
        }
        // submit form
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                $('#black-channel-content').append(response+'<br>');
                $('#black-channel-modal').modal('show');
            }
        });
        return false;
    }).on('submit', function (e) {
        e.preventDefault();
    });
});
$('#black-channel-modal').on('hidden.bs.modal', function (e) {
    $(this).modal('hide');
    $('#black-channel-modal').modal('hide');
    $('#black-channel-content').empty();
    renderS2s();
    return false;
});
function renderS2s(){
    var form = $('.black_channel_form');
    if (form.find('.has-error').length) {
        return false;
    }
    form.attr("class","black_form");
    //console.log(form.serialize());
    form.attr("action", '/deliver/go-create');
    form.submit();
}
