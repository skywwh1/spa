/**
 * Created by Iven.Wu on 2017-01-25.
 */


$(function () {
    // if (!$.cookie('tr-body-class')) {
    //     $('body').addClass('sidebar-collapse');
    // }
    // $('#a-sidebar-toggle').click(function () {
    //     var body_class = $('body').attr('class');
    //     if (body_class.search('sidebar-collapse') != -1) {
    //         $.cookie('tr-body-class', 1);
    //     }else{
    //         $.removeCookie('tr-body-class');
    //     }
    // });
    var body_menu = $('#nav-menu').data('menu');
    var element = $('ul li a').filter(function () {
        if (body_menu != undefined && this.dataset.menu == body_menu) {
            return true;
        }
    }).addClass('active').parent();
    while (true) {
        if (element.is('li')) {
            element.addClass('active');
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }
});
$(document).ready(function () {
    $('.dropdown-toggle').dropdown();
});
$(document).on("pjax:end", function() {
    $('.dropdown-toggle').dropdown();
});
$('body').tooltip({
    selector: '[data-toggle="tooltip"]',
});