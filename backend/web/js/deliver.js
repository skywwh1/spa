/**
 * Created by Iven.Wu on 2017-02-17.
 */
$(document).on("click", "a[data-view=0]", function (e) {
    //alert('aaa');
    //console.log($(this));
    //var type = $(this).attr('data-type');
    //if(type==2){
    //    $('#deliver-modal').find('.modal-header').append('aaaaaa00');
    //}
    $('#deliver-modal').modal('show').find('#deliver-detail-content').load($(this).attr('data-url'));
});

$('#deliver-modal').on('hidden.bs.modal', function () {
    // do something…
    //  $.pjax.reload({container: "#applying_list"});  //Reload GridView
    $('#deliver-detail-content').empty();
});

$(document).on('beforeSubmit', 'form#CampaignStsUpdate', function () {
    var form = $(this);
    // return false if form still have some validation errors
    if (form.find('.has-error').length) {
        return false;
    }
    // submit form
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