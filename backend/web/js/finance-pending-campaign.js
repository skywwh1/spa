/**
 * Created by iven on 2017/3/29.
 */
$(document).ready(function () {
        // alert(999);
        //
    $("#campaign-pending-all").on("change",function(){
        // alert("The paragraph was clicked.");
        // var isAll = this.val();
        console.log($(this).val());
        if($(this).val() == 1){
            $("input[name='FinancePending[channel_name]']").val("");
            $("input[name='FinancePending[channel_name]']").attr("readonly", true);
        }else{
            $("input[name='FinancePending[channel_name]']").attr("readonly", false);
        }
    });
});