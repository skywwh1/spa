/**
 * Created by ctt on 2017/5/11.
 */
$(document).ready(function(){
    $('#selectButton').click(function(){
        var keys = $('#grid').yiiGridView('getSelectedRows');
        $.post("selected", {keylist: keys}, function(result){
            $('#my-cart-content').append(result+'<br>');
            $('#my-cart-modal').modal('show');
        });
        return false;
    });
    $('#deleteButton').click(function(){
        var keys = $('#grid').yiiGridView('getSelectedRows');
        $.post("batch-delete", {keylist: keys}, function(result){
        });
        return false;
    });
    $('#stsButton').click(function(){
        var keys = $('#grid').yiiGridView('getSelectedRows');
        var url = '/deliver/sts?keylist='+ keys;
        var form = $('#deliver-form');
        form.attr({"action":'/deliver/create'});
        $('#mycartsearch-ids').val(keys);
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
