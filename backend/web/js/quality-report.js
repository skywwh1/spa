/**
 * Created by iven.wu on 2/5/2017.
 */


//$(document).on("click", "a[data-view=0]", function (e) {
//    //alert($(this).attr('data-url'));
//    $('#campaign-modal').modal('show').find('#campaign-detail-content').load($(this).attr('data-url'));
//    alert($(this).attr('data-url'));
//});

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

