/**
 * Created by ctt on 2017/5/11.
 */
var keys;
$(document).ready(function(){
    $('#emailButton').click(function(){

        //keys = $('#grid').yiiGridView('getSelectedRows');
        var keys = [];
        $("#detailGrid table tbody tr").each( function() {
            //alert($(this).attr("data-key"));
            //keys.push($(this).attr("data-key"));
            keys.push($(this).children('td').eq(1).html());
        });

        $.post("export-email", {keylist: keys}, function(result){
            //console.log(result);
            alert(result);
        });
        return false;
    });
});
