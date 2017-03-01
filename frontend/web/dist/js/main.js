/**
 * Created by iven.wu on 1/30/2017.
 */
$(function () {

    $(document).on("click", "button[data-view=0]", function(e) {
        // alert('aaa');
        $('#campaign-detail-modal').modal('show').find('#campaign-detail-content').load($(this).attr('value'));
        //$.pjax.reload({container:"#countries"});  //Reload GridView

    });
    $('#campaign-detail-modal').on('hidden.bs.modal', function () {
        // do something…
        $.pjax.reload({container:"#countries"});  //Reload GridView
    })


});
$(document).ready(function () {
    $('.dropdown-toggle').dropdown();
});