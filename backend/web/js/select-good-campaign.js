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
/**
 * Created by ctt on 2017/5/11.
 */
$(document).ready(function(){
    $('#selectButton').click(function(){

        var keys = $('#grid').yiiGridView('getSelectedRows');
        $.post("selected", {keylist: keys}, function(result){
            $('#my-cart-content').append(result+'<br>');
            $('#my-cart-modal').modal('show');
            //var getIdFromRow = $(event.target).closest('tr').data('id'); //get the id from tr
            //$(this).find('#orderDetails').html($('<b> Order Id selected: ' + getIdFromRow + '</b>'))
            //alert(getIdFromRow);
        });
        return false;
    });

    $('#deleteButton').click(function(){

        var keys = $('#grid').yiiGridView('getSelectedRows');
        $.post("batch-delete", {keylist: keys}, function(result){
            //$('#my-cart-content').append(result+'<br>');
            //$('#my-cart-modal').modal('show');
        });
        return false;
    });

    $('#stsButton').click(function(){
        var keys = $('#grid').yiiGridView('getSelectedRows');
        var url = '/deliver/sts?keylist='+ keys;
        var form = $('#deliver-form');
        //form.attr({"action":url});
        //form.submit();
        form.attr({"action":'/deliver/create'});
        $('#mycartsearch-campaign_uuid').val(keys);
        //form.data( {keylist: keys});
        form.submit();
        return false;
    });

    $('#my-cart-modal').on('hidden.bs.modal', function (e) {
        $(this).modal('hide');
        $('#my-cart-modal').modal('hide');
        $('#my-cart-content').empty();
        return false;
    });
});
