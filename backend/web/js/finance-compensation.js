/**
 * Created by iven on 2017/3/28.
 */
$(document).ready(function () {
    $('body').on('beforeSubmit', 'form#compensation-form', function () {
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
                    $('#deduction-modal').modal('hide');
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

$(document).on("click", "a[data-view=0]", function (e) {
    $('#compensation-modal').modal('show').find('#compensation-detail-content').load($(this).attr('data-url'));
    $('#compensation-modal .modal-header').append('<h4 class="modal-title">' + $(this).attr('data-title') + '</h4>');
});

$('#compensation-modal').on('hidden.bs.modal', function () {
    $('#compensation-detail-content').empty();
    $('#compensation-modal .modal-header h4').remove();
})

$(document).on("click", "a[data-delete=0]", function (e) {
    // $('#compensation-modal').modal('show').find('#compensation-detail-content').load($(this).attr('data-url'));
    // $('#compensation-modal .modal-header').append('<h4 class="modal-title">'+$(this).attr('data-title')+'</h4>');
    if (confirm('Are you sure you want to delete ' + $(this).attr('data-title') + '?')) {
        $.ajax({
            type: "POST",
            cache: false,
            url: $(this).attr('data-url'),
            dataType: "json",
            success: function (data) {
                if (!data.success) {
                    alert(data.success);
                } else {
                    $.pjax.reload({container: "#compensation-list"});  //Reload GridView
                }
            }
        });
    }
});

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
                    $('#compensation-modal').modal('hide');
                    $.pjax.reload({container: "#compensation-list"});  //Reload GridView
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