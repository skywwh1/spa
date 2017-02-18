<?php

/**
 * @package   yii2-grid
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
<<<<<<< HEAD
 * @version   3.1.3
=======
 * @version   3.1.1
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
 */

namespace kartik\grid;

<<<<<<< HEAD
use Closure;
use Yii;
use yii\grid\SerialColumn as YiiSerialColumn;
use yii\helpers\Html;

/**
 * A SerialColumn displays a column of row numbers (1-based) and extends the [[YiiSerialColumn]] with various
 * enhancements.
 *
 * To add a SerialColumn to the gridview, add it to the [[GridView::columns|columns]] configuration as follows:
 *
 * ```php
 * 'columns' => [
 *     // ...
 *     [
 *         'class' => SerialColumn::className(),
 *         // you may configure additional properties here
 *     ],
 * ]
 * ```
=======
use Yii;
use yii\helpers\Html;

/**
 * Extends the Yii's SerialColumn for the Grid widget [[\kartik\widgets\GridView]] with various enhancements.
 *
 * SerialColumn displays a column of row numbers (1-based).
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
<<<<<<< HEAD
class SerialColumn extends YiiSerialColumn
=======
class SerialColumn extends \yii\grid\SerialColumn
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
{
    use ColumnTrait;

    /**
<<<<<<< HEAD
     * @var boolean whether the column is hidden from display. This is different than the `visible` property, in the
     * sense, that the column is rendered, but hidden from display. This will allow you to still export the column
     * using the export function.
=======
     * @var bool whether the column is hidden from display. This is different than the `visible` property, in the
     *     sense, that the column is rendered, but hidden from display. This will allow you to still export the column
     *     using the export function.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $hidden;

    /**
<<<<<<< HEAD
     * @var boolean|array whether the column is hidden in export output. If set to boolean `true`, it will hide the column
     * for all export formats. If set as an array, it will accept the list of GridView export `formats` and hide
     * output only for them.
=======
     * @var bool|array whether the column is hidden in export output. If set to boolean `true`, it will hide the column
     *     for all export formats. If set as an array, it will accept the list of GridView export `formats` and hide
     *     output only for them.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $hiddenFromExport = false;

    /**
<<<<<<< HEAD
     * @var string the horizontal alignment of each column. Should be one of [[GridView::ALIGN_LEFT]], 
     * [[GridView::ALIGN_RIGHT]], or [[GridView::ALIGN_CENTER]].
=======
     * @var string the horizontal alignment of each column. Should be one of 'left', 'right', or 'center'.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $hAlign = GridView::ALIGN_CENTER;

    /**
<<<<<<< HEAD
     * @var string the vertical alignment of each column. Should be one of [[GridView::ALIGN_TOP]], 
     * [[GridView::ALIGN_BOTTOM]], or [[GridView::ALIGN_MIDDLE]].
=======
     * @var string the vertical alignment of each column. Should be one of 'top', 'middle', or 'bottom'.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $vAlign = GridView::ALIGN_MIDDLE;

    /**
<<<<<<< HEAD
     * @var boolean whether to force no wrapping on all table cells in the column
=======
     * @var bool whether to force no wrapping on all table cells in the column
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     * @see http://www.w3schools.com/cssref/pr_text_white-space.asp
     */
    public $noWrap = false;

<<<<<<< HEAD
=======

>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
    /**
     * @var string the width of each column (matches the CSS width property).
     * @see http://www.w3schools.com/cssref/pr_dim_width.asp
     */
    public $width = '50px';

    /**
<<<<<<< HEAD
     * @var boolean|string|Closure the page summary that is displayed above the footer. You can set it to one of the
     * following:
     * - `false`: the summary will not be displayed.
     * - `true`: the page summary for the column will be calculated and displayed using the
     *   [[pageSummaryFunc]] setting.
     * - `string`: will be displayed as is.
     * - `Closure`: you can set it to an anonymous function with the following signature:
     *
     *   ```php
     *   // example 1
     *   function ($summary, $data, $widget) { return 'Count is ' . $summary; }
     *   // example 2
     *   function ($summary, $data, $widget) { return 'Range ' . min($data) . ' to ' . max($data); }
     *   ```
     *
     *   where:
     *
     *   - the `$summary` variable will be replaced with the calculated summary using the `summaryFunc` setting.
     *   - the `$data` variable will contain array of the selected page rows for the column.
=======
     * @var bool|string whether the page summary is displayed above the footer for this column. If this is set to a
     *     string, it will be displayed as is. If it is set to `false` the summary will not be calculated and
     *     displayed.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $pageSummary = false;

    /**
<<<<<<< HEAD
     * @var string the summary function that will be used to calculate the page summary for the column.
=======
     * @var string the summary function to call for the column
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $pageSummaryFunc = GridView::F_SUM;

    /**
<<<<<<< HEAD
     * @var array HTML attributes for the page summary cell. The following special attributes are available:
     * - `prepend`: _string_, a prefix string that will be prepended before the pageSummary content
     * - `append`: _string_, a suffix string that will be appended after the pageSummary content
=======
     * @var array HTML attributes for the page summary cell
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $pageSummaryOptions = [];

    /**
<<<<<<< HEAD
     * @var boolean whether to just hide the page summary display but still calculate the summary based on
     * [[pageSummary]] settings
=======
     * @var bool whether to just hide the page summary display but still calculate the summary based on `pageSummary`
     *     settings
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $hidePageSummary = false;

    /**
<<<<<<< HEAD
     * @var boolean whether to merge the header title row and the filter row This will not render the filter for the
     * column and can be used when `filter` is set to `false`. Defaults to `false`. This is only applicable when
     * [[GridView::filterPosition]] for the grid is set to [[GridView::FILTER_POS_BODY]].
=======
     * @var bool whether to merge the header title row and the filter row This will not render the filter for the
     *     column and can be used when `filter` is set to `false`. Defaults to `false`. This is only applicable when
     *     `filterPosition` for the grid is set to FILTER_POS_BODY.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $mergeHeader = true;

    /**
     * @var string|array in which format should the value of each data model be displayed as (e.g. `"raw"`, `"text"`,
<<<<<<< HEAD
     * `"html"`, `['date', 'php:Y-m-d']`). Supported formats are determined by the
     * [[GridView::formatter|formatter]] used by the [[GridView]]. Default format is "text" which will format the
     * value as an HTML-encoded plain text when [[\yii\i18n\Formatter]] is used as the
     * [[GridView::$formatter|formatter]] of the GridView.
=======
     *     `"html"`, `['date', 'php:Y-m-d']`). Supported formats are determined by the
     *     [[GridView::formatter|formatter]] used by the [[GridView]]. Default format is "text" which will format the
     *     value as an HTML-encoded plain text when [[\yii\i18n\Formatter]] is used as the
     *     [[GridView::$formatter|formatter]] of the GridView.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $format = 'text';

    /**
     * @var string the cell format for EXCEL exported content.
     * @see http://cosicimiento.blogspot.in/2008/11/styling-excel-cells-with-mso-number.html
     */
    public $xlFormat;

    /**
<<<<<<< HEAD
     * @var array collection of row data for the column for the current page
=======
     * @var array of row data for the column for the current page
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    protected $_rows = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->parseFormat();
        $this->parseVisibility();
        parent::init();
        $this->setPageRows();
    }

    /**
     * @inheritdoc
     */
    public function renderDataCell($model, $key, $index)
    {
        $options = $this->fetchContentOptions($model, $key, $index);
        $this->parseExcelFormats($options, $model, $key, $index);
        $out = $this->grid->formatter->format($this->renderDataCellContent($model, $key, $index), $this->format);
        return Html::tag('td', $out, $options);
    }
}
