/**
 * Created by ctt on 2017/5/11.
 */
var keys;
$(document).ready(function(){
    $('#emailButton').click(function(){
        var keys = [];
        $("#detailGrid table tbody tr").each( function() {
            keys.push($(this).children('td').eq(1).html());
        });
        $.post("export-email", {keylist: keys}, function(result){
            alert(result);
        });
        return false;
    });

    $('#stsButton').click(function(){
        var keys = [];
        $("#detailGrid table tbody tr").each( function() {
            keys.push($(this).children('td').eq(1).html());
        });
        var url = '/deliver/sts?keylist='+ keys;
        var form = $('#deliver-form');
        form.attr({"action":'/deliver/create'});
        $('#campaignsearch-campaign_uuid').val(keys);
        form.submit();
        return false;
    });

    $('#cartButton').click(function(){
        var keys = [];
        $("#detailGrid table tbody tr").each( function() {
            keys.push($(this).children('td').eq(1).html());
        });
        $.post("add-cart-batch", {keylist: keys}, function(result){
            alert(result);
        });
        return false;
    });

});
