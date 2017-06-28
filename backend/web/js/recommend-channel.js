

$(document).on("click", "#s2s_button", function (e) {
    var keys = $('#recommend-list').yiiGridView('getSelectedRows');
    if (keys == ''){
        return;
    }
    var form = $('#recommend-form');
    $(':input[name="StsForm[channel]"]').val(keys);
    form.submit();
    return false;
});
