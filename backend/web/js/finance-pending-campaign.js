/**
 * Created by iven on 2017/3/29.
 */
$(document).ready(function () {
    $("#campaign-pending-all").on("change", function () {
        // alert("The paragraph was clicked.");
        // var isAll = this.val();
        console.log($(this).val());
        if ($(this).val() == 1) {
            $("input[name='FinancePending[channel_name]']").val("");
            $("input[name='FinancePending[channel_name]']").attr("readonly", true);
        } else {
            $("input[name='FinancePending[channel_name]']").attr("readonly", false);
        }
    });
});

$(document).on("click", "a[data-view=0]", function (e) {
    $('#pending-modal').modal('show').find('#pending-detail-content').load($(this).attr('data-url'));
    $('#pending-modal .modal-header').append('<h4 class="modal-title">' + $(this).attr('data-title') + '</h4>');
});

$('#pending-modal').on('hidden.bs.modal', function () {
    $('#pending-detail-content').empty();
    $('#pending-modal .modal-header h4').remove();
})

$(document).ready(function () {
    $('body').on('beforeSubmit', 'form#update-form', function () {
        var form = $(this);
        // return false if form still have some validation errors
        if (form.find('.has-error').length) {
            return false;
        }
        // submit form
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                if (response.success) {
                    $('#pending-modal').modal('hide');
                    $.pjax.reload({container: "#pending-list"});  //Reload GridView
                } else {
                    alert(response);
                }
            },
            error: function () {
                console.log('internal server error');
            }
        });
        return false;
    });
});

$(document).ready(function () {
    $('body').on('beforeSubmit', 'form#add-cost-form', function () {
        var form = $(this);
        // return false if form still have some validation errors
        if (form.find('.has-error').length) {
            return false;
        }
        // submit form
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                if (response.success) {
                    $('#pending-modal').modal('hide');
                    // $.pjax.reload({container: "#pending-list"});  //Reload GridView
                } else {
                    alert(response);
                }
            },
            error: function () {
                console.log('internal server error');
            }
        });
        return false;
    });
});

$(document).ready(function () {
    $('body').on('beforeSubmit', 'form#apply-prepayment-form', function () {
        var form = $(this);
        // return false if form still have some validation errors
        if (form.find('.has-error').length) {
            return false;
        }
        // submit form
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                if (response.success) {
                    $('#pending-modal').modal('hide');
                    //  $.pjax.reload({container: "#pending-list"});  //Reload GridView
                } else {
                    alert(response);
                }
            },
            error: function () {
                console.log('internal server error');
            }
        });
        return false;
    });
});

$(document).ready(function () {
    $('body').on('beforeSubmit', '#finance-channel-bill-term-form', function () {
        var form = $(this);
        // return false if form still have some validation errors
        if (form.find('.has-error').length) {
            return false;
        }
        // submit form
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                if (response.success) {
                    //$('#pending-modal').modal('hide');
                    krajeeDialog.alert("Success");
                    //  $.pjax.reload({container: "#pending-list"});  //Reload GridView
                } else {
                    alert(response);
                }
            },
            error: function () {
                console.log('internal server error');
            }
        });
        return false;
    });
});

$(document).on("click", "a[data-retreat=0]", function (e) {
    // $('#pending-modal').modal('show').find('#pending-detail-content').load($(this).attr('data-url'));
    // $('#pending-modal .modal-header').append('<h4 class="modal-title">' + $(this).attr('data-title') + '</h4>');
    var url = $(this).attr('data-url');
    var title = $(this).attr('data-title');
    // alert(url);
    // $.pjax.reload({container: "#channel-payable-list"});  //Reload GridView
    // return false;
    krajeeDialog.confirm("Are you really sure you want retreat "+title+"?", function (result) {
        if (result) { // ok button was pressed
            // execute your code for confirmation
            // alert(99);
            $.ajax({
                url: url,
                type: 'post',
                success: function (response) {
                    if (response.success) {
                        //$('#pending-modal').modal('hide');
                        krajeeDialog.alert("Success");
                        $.pjax.reload({container: "#channel-payable-list"});  //Reload GridView
                    } else {
                        krajeeDialog.alert(response);
                    }
                },
                error: function () {
                    console.log('internal server error');
                }
            });

        } else { // confirmation was cancelled
            // execute your code for cancellation
        }
    });

});

$(document).ready(function () {
    $('body').on('beforeSubmit', 'form#sub-cost-form', function () {
        var form = $(this);
        // return false if form still have some validation errors
        if (form.find('.has-error').length) {
            return false;
        }
        // submit form
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                if (response.success) {
                    $('#pending-modal').modal('hide');
                    $.pjax.reload({container: "#data-list"});  //Reload GridView
                } else {
                    alert(response);
                }
            },
            error: function () {
                console.log('internal server error');
            }
        });
        return false;
    });
});