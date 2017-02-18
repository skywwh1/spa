/*!
 * @package   yii2-grid
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
<<<<<<< HEAD
 * @version   3.1.3
=======
 * @version   3.1.1
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
 *
 * Client actions for yii2-grid EditableColumn
 * 
 * Author: Kartik Visweswaran
 * Copyright: 2015, Kartik Visweswaran, Krajee.com
 * For more JQuery plugins visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */
var kvRefreshEC;
(function ($) {
    "use strict";
    kvRefreshEC = function (gridId, css) {
        var $grid = $('#' + gridId);
        $grid.find('.' + css).each(function () {
            $(this).on('editableSuccess', function () {
                $grid.yiiGridView("applyFilter");
            });
        });
    };
})(window.jQuery);