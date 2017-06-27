/**
 * Created by iven.wu on 2/3/2017.
 */

$(document).on("click", "a[data-view=0]", function (e) {
    //alert('aaa');
    var params = $(this).attr('data-url').split("?")[1];
    $.ajax({
        async: true,
        url:'/apply-campaign/check-black-channel?' + params,
        type: 'get',
        success: function (result) {
            if(result.indexOf("Cannot")>=0) {
                //console.log(result);
                alert(result);
            }else if(result.indexOf("Are you sure S2S?")>=0){
                console.log(result);
                if (confirm(result)) {
                    $('#campaign-detail-modal').modal('show').find('#campaign-detail-content').load('/apply-campaign/deliver-create?'+params);
                }else{
                    window.location.reload();
                }
            }else{
                $('#campaign-detail-modal').modal('show').find('#campaign-detail-content').load('/apply-campaign/deliver-create?'+params);
            }
        }
    });
    //$.pjax.reload({container:"#countries"});  //Reload GridView
});
$('#campaign-detail-modal').on('hidden.bs.modal', function () {
    // do something…
    $.pjax.reload({container: "#applying_list"});  //Reload GridView
})

$(document).on('beforeSubmit', 'form#approve-form', function () {
    // $('#campaign-detail-modal').modal('hide');
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
            if (response == 'success') {
                $('#campaign-detail-modal').modal('hide');
            } else {
                alert(response);
            }
        }
    });
    return false;
}).on('submit', function (e) {
    e.preventDefault();
});

$(document).on('click', '#campaignRejectButton', function () {
    if (confirm('Are you sure?')) {
        $.ajax({
            async: true,
            url: '/apply-campaign/reject?campaign_id=' + $('#deliver-campaign_id').val() + '&channel_id=' + $('#deliver-channel_id').val(),
            type: 'post',
            // data: 'campaign_id=99&channel_id=00',
            success: function (response) {
                if (response == 'success') {
                    $('#campaign-detail-modal').modal('hide');
                } else {
                    alert(response);
                }
            }
        });
    }
});
$.extend({
    StandardPost:function(url,args){
        var form = $("<form method='post'></form>"),
            input;
        form.attr({"action":url});
        $.each(args,function(key,value){
            input = $("<input type='hidden'>");
            input.attr({"name":key});
            input.val(value);
            form.append(input);
        });
        form.submit();
    }
});
$(document).ready(function(){
    $('#stsButton').click(function(e){
        var keys = $('#applying_list').yiiGridView('getSelectedRows');
        var form = $("<form method='post'></form>"),input;
        form.attr({"action":'/deliver/create'});
        input = $("<input type='hidden'>");
        input.attr({"name":"ids"});
        input.val(JSON.stringify(keys));
        form.append(input);
        $(document).append(form);
        form.submit();
        return false;
    });
});
