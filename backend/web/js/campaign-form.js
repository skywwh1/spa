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
