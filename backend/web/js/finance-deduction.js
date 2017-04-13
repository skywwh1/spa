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
    $('#deduction-modal').modal('show').find('#deduction-detail-content').load($(this).attr('data-url'));
    $('#deduction-modal .modal-header').append('<h4 class="modal-title">'+$(this).attr('data-title')+'</h4>');
});

$('#deduction-modal').on('hidden.bs.modal', function () {
    $('#deduction-detail-content').empty();
    $('#deduction-modal .modal-header h4').remove();
})

$(document).on("click", "a[data-view=1]", function (e) {
    $('#deduction-update-modal').modal('show').find('#deduction-update-content').load($(this).attr('data-url'));

});

$('#deduction-update-modal').on('hidden.bs.modal', function () {
    $('#deduction-update-content').empty();
})