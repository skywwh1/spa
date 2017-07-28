$(document).on("click", "a[data-view=0]", function (result) {
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
    //alert(url);
    $.post(url, function(result){
        //console.log(result);
        alert(result);
    });
    return false;
});
$(document).on("click", "#selectButton", function (e) {
    var keys = $('#grid').yiiGridView('getSelectedRows');
    var form = $('#deliver-form');
    form.attr({"action":'/campaign/selected'});
    $('#campaignsearch-ids').val(keys);
    form.submit();
    return false;
});
$(document).on("click", "a[data-view=2]", function (result) {
    var url = $(this).attr('data-url');
    $.post(url, function(result){
        $('#campaign-detail-content').append(result+'<br>');
        $('#campaign-modal').modal('show');
    });
    return false;
});
$(document).on("click", "#s2s_button", function (e) {
    var keys = $('#recommend-channel-grid').yiiGridView('getSelectedRows');
    if (keys == ''){
        return;
    }
    var form = $('#recommend-form');
    $(':input[name="StsForm[campaign_uuid]"]').val(keys);
    form.submit();
    return false;
});