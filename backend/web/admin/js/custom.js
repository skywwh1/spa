/**
 * Created by Iven.Wu on 2017-01-25.
 */


$(function () {
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

    $(document).ready(function () {
        $('.dropdown-toggle').dropdown();
    });

    $('body').tooltip({
        selector: '[data-toggle="tooltip"]',
    });
});