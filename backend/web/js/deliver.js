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
    //$.pjax.reload({container:"#countries"});  //Reload GridView

});

$('#deliver-modal').on('hidden.bs.modal', function () {
    // do something…
    //  $.pjax.reload({container: "#applying_list"});  //Reload GridView
    $('#deliver-detail-content').empty();
})