/**
 * Created by ASUS on 2017/4/26.
 */
$(document).on('click', 'a[data-view=0]', function () {
    var channelId = $(this).attr("data-pjax").split("?")[1];
    console.log(channelId);

   if (confirm('Are you sure?')) {
        $.ajax({
            async: true,
            url: '/channel/om-edit?' + channelId,
            type: 'post',
            data:channelId,
            success: function (response) {
                if (response == 'success') {
                    alert("sucess!")
                } else {
                    alert(response);
                }
            }
        });
    }
});