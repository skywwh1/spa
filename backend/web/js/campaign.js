/**
 * Created by iven.wu on 2/5/2017.
 */

// console.log();

if (isNaN($('input[name="Campaign[daily_cap]"]').val())) {
    // alert(000);
    $('select[name="open_cap"]').val('1');
    $('input[name="Campaign[daily_cap]"]').val('open').attr("readonly", "readonly");
}
$('select[name="open_cap"]').change(function () {
    if ($('select[name="open_cap"]').val() == 1) {
        $('input[name="Campaign[daily_cap]"]').val('open').attr("readonly", "readonly");
    } else if ($('select[name="open_cap"]').val() == 0) {
        $('input[name="Campaign[daily_cap]"]').attr("readonly", false);
        $('input[name="Campaign[daily_cap]"]').val('');
    }
});

$(document).on("click", "a[data-view=0]", function (e) {
    $('#campaign-modal').modal('show').find('#campaign-detail-content').load($(this).attr('data-url'));

});

$('#campaign-modal').on('hidden.bs.modal', function () {
    $('#campaign-detail-content').empty();
});

$(document).on("click", "a[data-view=1]", function (e) {
    $('#campaign-update-modal').modal('show').find('#campaign-update-content').load($(this).attr('data-url'));

});

$('#campaign-update-modal').on('hidden.bs.modal', function () {
    $('#campaign-update-content').empty();
});

$('#recommend-channel-btn').on('click', function () {
    var keys = $('#recommend-channel-grid').yiiGridView('getSelectedRows');
    console.log(keys);
    if (keys.length == 0) {
        return;
    }
    var url = $(this).attr('data-url') + '&cams=' + keys;
    $('#campaign-modal').modal('show').find('#campaign-detail-content').load(url);

});

$(document).on("click", "#finish-recommend-channel-btn", function (e) {
    var url = $(this).attr('data-url');
    alert(url);
});


