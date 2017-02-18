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
use yii\grid\CheckboxColumn as YiiCheckboxColumn;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * The CheckboxColumn displays a column of checkboxes in a grid view and extends the [[YiiCheckboxColumn]] with
 * various enhancements.
 *
 * To add a CheckboxColumn to the gridview, add it to the [[GridView::columns|columns]] configuration as follows:
 *
 * ```php
 * 'columns' => [
 *     // ...
 *     [
 *         'class' => CheckboxColumn::className(),
 *         // you may configure additional properties here
 *     ],
 * ]
 * ```
=======
use Yii;
use yii\helpers\Html;

/**
 * Extends the Yii's CheckboxColumn for the Grid widget [[\kartik\widgets\GridView]] with various enhancements.
 *
 * CheckboxColumn displays a column of checkboxes in a grid view.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
<<<<<<< HEAD
class CheckboxColumn extends YiiCheckboxColumn
=======
class CheckboxColumn extends \yii\grid\CheckboxColumn
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
     * @var boolean|array whether the column is hidden in export output. If set to boolean `true`, it will hide the
     * column for all export formats. If set as an array, it will accept the list of GridView export `formats` and
     * hide output only for them.
=======
     * @var bool|array whether the column is hidden in export output. If set to boolean `true`, it will hide the
     *     column for all export formats. If set as an array, it will accept the list of GridView export `formats` and
     *     hide output only for them.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $hiddenFromExport = true;

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

    /**
     * @var string the width of each column (matches the CSS width property).
     * @see http://www.w3schools.com/cssref/pr_dim_width.asp
     */
    public $width = '50px';

    /**
<<<<<<< HEAD
     * @var boolean highlight current row if checkbox is checked
=======
     * @var bool highlight current row if checkbox is checked
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $rowHighlight = true;

    /**
<<<<<<< HEAD
     * @var string highlight CSS class to be applied for highlighting the row. Defaults to [[GridView::TYPE_DANGER]].
=======
     * @var string highlight CSS class to be applied for highlighting the row.
     * Defaults to 'danger'.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $rowSelectedClass = GridView::TYPE_DANGER;

    /**
<<<<<<< HEAD
     * @var boolean whether to merge the header title row and the filter row This will not render the filter for the
     * column and can be used when `filter` is set to `false`. Defaults to `false`. This is only applicable when
     * [[GridView::filterPosition]] for the grid is set to [[GridView::FILTER_POS_BODY]].
     */
    public $mergeHeader = true;

    /**
     * @var string the model attribute to be used in rendering the checkbox input.
     */
    public $attribute;

    /**
     * @var string the css class that will be used to find the checkboxes.
     */
    public $cssClass = 'kv-row-checkbox';

    /**
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
     *   - the `$summary` variable will be replaced with the calculated summary using the [[pageSummaryFunc]] setting.
     *   - the `$data` variable will contain array of the selected page rows for the column.
=======
     * @var bool|string whether the page summary is displayed above the footer for this column. If this is set to a
     *     string, it will be displayed as is. If it is set to `false` the summary will not be displayed.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $pageSummary = false;

    /**
<<<<<<< HEAD
     * @var string the summary function that will be used to calculate the page summary for the column.
     */
    public $pageSummaryFunc = GridView::F_SUM;

    /**
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
     * @var bool whether to just hide the page summary display but still calculate
     * the summary based on `pageSummary` settings
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $hidePageSummary = false;

    /**
<<<<<<< HEAD
     * @var string the internally generated client script to initialize
     */
    protected $_clientScript = '';

    /**
     * @var string the internally generated column key
     */
    protected $_columnKey = '';
=======
     * @var bool whether to merge the header title row and the filter row This will not render the filter for the
     *     column and can be used when `filter` is set to `false`. Defaults to `false`. This is only applicable when
     *     `filterPosition` for the grid is set to FILTER_POS_BODY.
     */
    public $mergeHeader = true;

    /**
     * @var string the client script to initialize
     */
    protected $_clientScript = '';
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b

    /**
     * @inheritdoc
     */
    public function init()
    {
<<<<<<< HEAD
        $id = $this->grid->options['id'];
        if ($this->rowHighlight) {
            Html::addCssClass($this->headerOptions, 'kv-all-select');
            $view = $this->grid->getView();
=======
        if ($this->rowHighlight) {
            Html::addCssClass($this->headerOptions, 'kv-all-select');
            $view = $this->grid->getView();
            $id = $this->grid->options['id'];
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
            CheckboxColumnAsset::register($view);
            $this->_clientScript = "kvSelectRow('{$id}', '{$this->rowSelectedClass}');";
            $view->registerJs($this->_clientScript);
        }
        $this->parseFormat();
        $this->parseVisibility();
        parent::init();
        $this->setPageRows();
<<<<<<< HEAD
        $opts = Json::encode(
            [
                'name' => $this->name,
                'multiple' => $this->multiple,
                'checkAll' => $this->grid->showHeader ? $this->getHeaderCheckBoxName() : null,
            ]
        );
        $this->_clientScript .= "\nkvSelectColumn('{$id}', {$opts});";
=======
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
    }

    /**
     * @inheritdoc
     */
    public function renderDataCell($model, $key, $index)
    {
        $options = $this->fetchContentOptions($model, $key, $index);
        if ($this->rowHighlight) {
<<<<<<< HEAD
            Html::addCssClass($options, 'kv-row-select');
        }
        $this->initPjax($this->_clientScript);
        if ($this->attribute !== null) {
            $this->name = Html::getInputName($model, "[{$index}]{$this->attribute}");
            $this->checkboxOptions['value'] = Html::getAttributeValue($model, $this->attribute);
        }
=======
            $this->initPjax($this->_clientScript);
            Html::addCssClass($options, 'kv-row-select');
        }
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
        return Html::tag('td', $this->renderDataCellContent($model, $key, $index), $options);
    }
}
