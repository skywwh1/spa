/**
 * Created by Iven.Wu on 2017-02-17.
 */
$(document).on("click", "a[data-view=0]", function (e) {
    $('#deliver-modal').modal('show').find('#deliver-detail-content').load($(this).attr('data-url'));
});
$('#deliver-modal').on('hidden.bs.modal', function () {
    $('#deliver-detail-content').empty();
});
$(document).on('beforeSubmit', 'form#CampaignStsUpdate', function () {
    var form = $(this);
    if (form.find('.has-error').length) {
        return false;
    }
    $.ajax({
        async: true,
        url: form.attr('action'),
        type: 'post',
        data: form.serialize(),
        success: function (response) {
            $('#deliver-modal').modal('hide');
            $.pjax.reload({container: "#kv-unique-id-report"});  //Reload GridView
        }
    });
    return false;
}).on('submit', function (e) {
    //e.preventDefault();
});