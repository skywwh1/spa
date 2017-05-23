/**
 * Created by ASUS on 2017/5/19.
 */
$(document).ready(function(){
    $('#apply-btn').click(function(){
        var url = $(this).attr('data-url');
        $.post(url, function(result){
            //console.log(result);
            alert(result);
        });
        return false;
    });
});