$(document).on("click", "#weekButton", function (e) {
    var nowdate = new Date();
    var oneweekdate = new Date(nowdate-7*24*3600*1000);
    var y = oneweekdate.getFullYear();
    var m = oneweekdate.getMonth()+1;
    var d = oneweekdate.getDate();
    var formatwdate = y+'-'+m+'-'+d;
    //alert(formatwdate);

    var y1 = nowdate.getFullYear();
    var m1 = nowdate.getMonth()+1;
    var d1 = nowdate.getDate();
    var formatnowdate = y1+'-'+m1+'-'+d1;
    //alert(formatnowdate);
    $('input[name="ChannelQualityReportSearch[start]"]').val(formatwdate);
    $('input[name="ChannelQualityReportSearch[end]"]').val(formatnowdate);
    $('input[name="ChannelQualityReportSearch[type]"]').val(1);
    return false;
});

$(document).on("click", "#monthButton", function (e) {
    var nowdate0 = new Date();
    nowdate0.setMonth(nowdate0.getMonth()-1);
    var y = nowdate0.getFullYear();
    var m = nowdate0.getMonth()+1;
    var d = nowdate0.getDate();
    var formatwdate = y+'-'+m+'-'+d;
    //alert(formatwdate);


    var nowdate = new Date();
    var y = nowdate.getFullYear();
    var m = nowdate.getMonth()+1;
    var d = nowdate.getDate();
    var formatnowdate = y+'-'+m+'-'+d;

    $('input[name="ChannelQualityReportSearch[start]"]').val(formatwdate);
    $('input[name="ChannelQualityReportSearch[end]"]').val(formatnowdate);
    $('input[name="ChannelQualityReportSearch[type]"]').val(2);
    return false;
});
