<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
 * @package yii2-grid
<<<<<<< HEAD
 * @version 3.1.3
=======
 * @version 3.1.1
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
 */

namespace kartik\grid;

<<<<<<< HEAD
use Closure;
use Yii;
use yii\grid\ActionColumn as YiiActionColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * The ActionColumn is a column that displays buttons for viewing and manipulating the items and extends the
 * [[YiiActionColumn]] with various enhancements.
 *
 * To add an ActionColumn to the gridview, add it to the [[GridView::columns|columns]] configuration as follows:
 *
 * ```php
 * 'columns' => [
 *     // ...
 *     [
 *         'class' => ActionColumn::className(),
 *         // you may configure additional properties here
 *     ],
 * ]
 * ```
=======
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Extends the Yii's ActionColumn for the Grid widget [[\kartik\widgets\GridView]] with various enhancements.
 * ActionColumn is a column for the [[GridView]] widget that displays buttons for viewing and manipulating the items.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
<<<<<<< HEAD
class ActionColumn extends YiiActionColumn
=======
class ActionColumn extends \yii\grid\ActionColumn
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
{
    use ColumnTrait;

    /**
     * @var boolean whether the column is hidden from display. This is different than the `visible` property, in the
<<<<<<< HEAD
     * sense, that the column is rendered, but hidden from display. This will allow you to still export the column
     * using the export function.
=======
     *     sense, that the column is rendered, but hidden from display. This will allow you to still export the column
     *     using the export function.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $hidden;

    /**
     * @var boolean|array whether the column is hidden in export output. If set to boolean `true`, it will hide the
<<<<<<< HEAD
     * column for all export formats. If set as an array, it will accept the list of GridView export `formats` and
     * hide output only for them.
=======
     *     column for all export formats. If set as an array, it will accept the list of GridView export `formats` and
     *     hide output only for them.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $hiddenFromExport = true;

    /**
<<<<<<< HEAD
     * @var boolean whether the action buttons are to be displayed as a dropdown
=======
     * @var bool whether the action buttons are to be displayed as a dropdown
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $dropdown = false;

    /**
     * @var array the HTML attributes for the Dropdown container. The class `dropdown` will be added. To align a
<<<<<<< HEAD
     * dropdown at the right edge of the page container, you set the class to `pull-right`.
=======
     *     dropdown at the right edge of the page container, you set the class to `pull-right`.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $dropdownOptions = [];

    /**
     * @var array the HTML attributes for the Dropdown menu. Applicable if `dropdown` is `true`.
     */
    public $dropdownMenu = ['class' => 'text-left'];

    /**
<<<<<<< HEAD
     * @var array the dropdown button options. This configuration will be applicable only if [[dropdown]] is `true`.
     * The following special options are recognized:
     *
     * - `label`: _string_', the button label to be displayed. Defaults to `Actions`.
     * - `caret`: _string_', the caret symbol to be appended to the dropdown button.
     *   Defaults to ` <span class="caret"></span>`.
=======
     * @var array the dropdown button options. Applicable if `dropdown` is `true`. The following special options are
     *     recognized:
     * `label`: the button label to be displayed. Defaults to `Actions`.
     * `caret`: the caret symbol to be appended to the dropdown button.
     *  Defaults to `<span class="caret"></span>`
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $dropdownButton = ['class' => 'btn btn-default'];

    /**
<<<<<<< HEAD
     * @var string the horizontal alignment of each column. Should be one of [[GridView::ALIGN_LEFT]],
     * [[GridView::ALIGN_RIGHT]], or [[GridView::ALIGN_CENTER]].
=======
     * @var string the horizontal alignment of each column. Should be one of
     * 'left', 'right', or 'center'.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $hAlign = GridView::ALIGN_CENTER;

    /**
<<<<<<< HEAD
     * @var string the vertical alignment of each column. Should be one of [[GridView::ALIGN_TOP]],
     * [[GridView::ALIGN_BOTTOM]], or [[GridView::ALIGN_MIDDLE]].
=======
     * @var string the vertical alignment of each column. Should be one of
     * 'top', 'middle', or 'bottom'.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $vAlign = GridView::ALIGN_MIDDLE;

    /**
     * @var boolean whether to force no wrapping on all table cells in the column
     * @see http://www.w3schools.com/cssref/pr_text_white-space.asp
     */
    public $noWrap = false;

    /**
     * @var string the width of each column (matches the CSS width property).
     * @see http://www.w3schools.com/cssref/pr_dim_width.asp
     */
    public $width = '80px';

    /**
     * @var array HTML attributes for the view action button. The following additional option is recognized:
<<<<<<< HEAD
     * `label`: _string_, the label for the view action button. This is not html encoded. Defaults to `View`.
=======
     * `label`: string, the label for the view action button. This is not html encoded.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $viewOptions = [];

    /**
     * @var array HTML attributes for the update action button. The following additional option is recognized:
<<<<<<< HEAD
     * - `label`: _string_, the label for the update action button. This is not html encoded. Defaults to `Update`.
=======
     * `label`: string, the label for the update action button. This is not html encoded.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $updateOptions = [];

    /**
<<<<<<< HEAD
     * @var array HTML attributes for the delete action button. The following additional options are recognized:
     * - `label`: _string_, the label for the delete action button. This is not html encoded. Defaults to `Delete`.
     * - `message`: _string_, the delete confirmation message to display when the delete button is clicked.
     *   Defaults to `Are you sure to delete this item?`.
=======
     * @var array HTML attributes for the delete action button. The following additional option is recognized:
     * `label`: string, the label for the delete action button. This is not html encoded.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $deleteOptions = [];

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
     *   - the `$summary` variable will be replaced with the calculated summary using the [[pageSummaryFunc]] setting.
     *   - the `$data` variable will contain array of the selected page rows for the column.
=======
     * @var boolean|string whether the page summary is displayed above the footer for this column. If this is set to a
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
     * @var boolean whether to just hide the page summary display but still calculate the summary based on
<<<<<<< HEAD
     * [[pageSummary]] settings
=======
     *     `pageSummary` settings
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $hidePageSummary = false;

    /**
     * @var boolean whether to merge the header title row and the filter row This will not render the filter for the
<<<<<<< HEAD
     * column and can be used when `filter` is set to `false`. Defaults to `false`. This is only applicable when
     * [[GridView::filterPosition]] for the grid is set to [[GridView::FILTER_POS_BODY]].
=======
     *     column and can be used when `filter` is set to `false`. Defaults to `false`. This is only applicable when
     *     `filterPosition` for the grid is set to FILTER_POS_BODY.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $mergeHeader = true;

    /**
     * @var array the HTML attributes for the header cell tag.
<<<<<<< HEAD
     * @see Html::renderTagAttributes() for details on how attributes are being rendered.
=======
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $headerOptions = [];

    /**
     * @var array|\Closure the HTML attributes for the data cell tag. This can either be an array of attributes or an
<<<<<<< HEAD
     * anonymous function ([[Closure]]) that returns such an array. The signature of the function should be the
     * following: `function ($model, $key, $index, $column)`. A function may be used to assign different attributes
     * to different rows based on the data in that row.
     *
     * @see Html::renderTagAttributes() for details on how attributes are being rendered.
=======
     *     anonymous function ([[Closure]]) that returns such an array. The signature of the function should be the
     *     following: `function ($model, $key, $index, $column)`. A function may be used to assign different attributes
     *     to different rows based on the data in that row.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $contentOptions = [];

    /**
<<<<<<< HEAD
     * @var boolean is the dropdown menu to be rendered?
     */
    protected $_isDropdown = false;

    /**
     * @inheritdoc
     */
=======
     * @var bool is the dropdown menu to be rendered?
     */
    protected $_isDropdown = false;

>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
    public function init()
    {
        /** @noinspection PhpUndefinedFieldInspection */
        $this->_isDropdown = ($this->grid->bootstrap && $this->dropdown);
        if (!isset($this->header)) {
            $this->header = Yii::t('kvgrid', 'Actions');
        }
        $this->parseFormat();
        $this->parseVisibility();
        parent::init();
        $this->initDefaultButtons();
        $this->setPageRows();
    }

    /**
<<<<<<< HEAD
     * @inheritdoc
     */
    public function renderDataCell($model, $key, $index)
    {
        $options = $this->fetchContentOptions($model, $key, $index);
        return Html::tag('td', $this->renderDataCellContent($model, $key, $index), $options);
    }

    /**
     * @inheritdoc
=======
     * Render default action buttons
     *
     * @return string
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url) {
                $options = $this->viewOptions;
                $title = Yii::t('kvgrid', 'View');
                $icon = '<span class="glyphicon glyphicon-eye-open"></span>';
                $label = ArrayHelper::remove($options, 'label', ($this->_isDropdown ? $icon . ' ' . $title : $icon));
                $options = array_replace_recursive(['title' => $title, 'data-pjax' => '0'], $options);
                if ($this->_isDropdown) {
                    $options['tabindex'] = '-1';
                    return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
                } else {
                    return Html::a($label, $url, $options);
                }
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url) {
                $options = $this->updateOptions;
                $title = Yii::t('kvgrid', 'Update');
                $icon = '<span class="glyphicon glyphicon-pencil"></span>';
                $label = ArrayHelper::remove($options, 'label', ($this->_isDropdown ? $icon . ' ' . $title : $icon));
                $options = array_replace_recursive(['title' => $title, 'data-pjax' => '0'], $options);
                if ($this->_isDropdown) {
                    $options['tabindex'] = '-1';
                    return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
                } else {
                    return Html::a($label, $url, $options);
                }
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url) {
                $options = $this->deleteOptions;
                $title = Yii::t('kvgrid', 'Delete');
                $icon = '<span class="glyphicon glyphicon-trash"></span>';
                $label = ArrayHelper::remove($options, 'label', ($this->_isDropdown ? $icon . ' ' . $title : $icon));
<<<<<<< HEAD
                $msg = ArrayHelper::remove($options, 'message', Yii::t('kvgrid', 'Are you sure to delete this item?'));
                $defaults = ['title' => $title, 'data-pjax' => 'false'];
                $pjax = $this->grid->pjax ? true : false;
                $pjaxContainer = $pjax ? $this->grid->pjaxSettings['options']['id'] : '';
                if ($pjax) {
                    $defaults['data-pjax-container'] = $pjaxContainer;
                }
                $options = array_replace_recursive($defaults, $options);
                $css = $this->grid->options['id'] . '-action-del';
                Html::addCssClass($options, $css);
                $view = $this->grid->getView();
                $delOpts = Json::encode(
                    [
                        'css' => $css,
                        'pjax' => $pjax,
                        'pjaxContainer' => $pjaxContainer,
                        'lib' => ArrayHelper::getValue($this->grid->krajeeDialogSettings, 'libName', 'krajeeDialog'),
                        'msg' => $msg,
                    ]
                );
                ActionColumnAsset::register($view);
                $js = "kvActionDelete({$delOpts});";
                $view->registerJs($js);
                $this->initPjax($js);
=======
                $options = array_replace_recursive(
                    [
                        'title' => $title,
                        'data-confirm' => Yii::t('kvgrid', 'Are you sure to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0'
                    ],
                    $options
                );
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
                if ($this->_isDropdown) {
                    $options['tabindex'] = '-1';
                    return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
                } else {
                    return Html::a($label, $url, $options);
                }
            };
        }
    }

    /**
     * @inheritdoc
     */
<<<<<<< HEAD
=======
    public function renderDataCell($model, $key, $index)
    {
        $options = $this->fetchContentOptions($model, $key, $index);
        return Html::tag('td', $this->renderDataCellContent($model, $key, $index), $options);
    }

    /**
     * Renders the data cell.
     *
     * @param Model $model
     * @param mixed $key
     * @param int   $index
     *
     * @return mixed|string
     */
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
    protected function renderDataCellContent($model, $key, $index)
    {
        $content = parent::renderDataCellContent($model, $key, $index);
        $options = $this->dropdownButton;
        if ($this->_isDropdown) {
            $label = ArrayHelper::remove($options, 'label', Yii::t('kvgrid', 'Actions'));
            $caret = ArrayHelper::remove($options, 'caret', ' <span class="caret"></span>');
            $options = array_replace_recursive($options, ['type' => 'button', 'data-toggle' => 'dropdown']);
            Html::addCssClass($options, 'dropdown-toggle');
            $button = Html::button($label . $caret, $options);
            Html::addCssClass($this->dropdownMenu, 'dropdown-menu');
            $dropdown = $button . PHP_EOL . Html::tag('ul', $content, $this->dropdownMenu);
            Html::addCssClass($this->dropdownOptions, 'dropdown');
            return Html::tag('div', $dropdown, $this->dropdownOptions);
        }
        return $content;
    }
}
