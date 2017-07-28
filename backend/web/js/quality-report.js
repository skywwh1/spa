/**
 * Created by iven.wu on 2/5/2017.
 */
$(document).on("click", "a[data-view=1]", function (e) {
    $('#campaign-update-modal').modal('show').find('#campaign-update-content').load($(this).attr('data-url'));
});
$('#campaign-update-modal').on('hidden.bs.modal', function () {
    $('#campaign-update-content').empty();
});
$('#campaign-modal').on('hidden.bs.modal', function () {
    $('#campaign-detail-content').empty();
});
$(document).on("click", "a[data-view=0]", function (e) {
    var url = $(this).attr('data-url');
    $.post(url, function(result){
        $('#campaign-detail-content').append(result);
        $('#campaign-modal').modal('show');
    });
    return false;
});
$(document).on("click", "#weekButton", function (e) {
    var nowdate = new Date();
    var oneweekdate = new Date(nowdate-7*24*3600*1000);
    var y = oneweekdate.getFullYear();
    var m = oneweekdate.getMonth()+1;
    var d = oneweekdate.getDate();
    var formatwdate = y+'-'+m+'-'+d;

    var y1 = nowdate.getFullYear();
    var m1 = nowdate.getMonth()+1;
    var d1 = nowdate.getDate();
    var formatnowdate = y1+'-'+m1+'-'+d1;
    $('input[name="ChannelQualityReportSearch[start]"]').val(formatwdate);
    $('input[name="ChannelQualityReportSearch[end]"]').val(formatnowdate);
    $('input[name="ChannelQualityReportSearch[type]"]').val(1);
    return false;
});

$(document).on("click", "#monthButton", function (e) {
    var nowdate0 = new Date();
    nowdate0.setMonth(nowdate0.getMonth()-1);
    var y = nowdate0.getFullYear();
    var m = nowdate0.getMonth()+1;
    var d = nowdate0.getDate();
    var formatwdate = y+'-'+m+'-'+d;

    var nowdate = new Date();
    var y = nowdate.getFullYear();
    var m = nowdate.getMonth()+1;
    var d = nowdate.getDate();
    var formatnowdate = y+'-'+m+'-'+d;

    $('input[name="ChannelQualityReportSearch[start]"]').val(formatwdate);
    $('input[name="ChannelQualityReportSearch[end]"]').val(formatnowdate);
    $('input[name="ChannelQualityReportSearch[type]"]').val(2);
    return false;
});
$('#submit-button').on('click', function () {
    $('.kv-editable-form').each(function () {
        $(this).submit();
    });
});
$('.kv-editable-form').each(function () {
    var form = $(this);
    $('body').on('beforeSubmit', 'form#' + form.attr('id'), function () {
        if (form.find('.has-error').length) {
            return false;
        }
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                $('#campaign-detail-content').append('save success!');
                $('#campaign-detail-modal').modal('show');
            }
        });
        return false;
    }).on('submit', function (e) {
        //e.preventDefault();
    });
});
$('#notice-button').on('click', function () {
    $.ajax({
        url: 'channel-quality-report/notice?',
        type: 'post',
        data: form.serialize(),
        success: function (response) {
            $('#campaign-detail-content').append('save success!');
            $('#campaign-detail-modal').modal('show');
        }
    });
    return false;
});