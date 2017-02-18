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
use yii\base\InvalidConfigException;
use yii\base\Model;
=======
use Yii;
use Closure;
use yii\base\InvalidConfigException;
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

/**
 * An ExpandRowColumn can be used to expand a row and add content in a new row below it either directly or via ajax.
 *
<<<<<<< HEAD
 * To add an ExpandRowColumn to the gridview, add it to the [[GridView::columns|columns]] configuration as follows:
 *
 * ```php
 * 'columns' => [
 *     // ...
 *     [
 *         'class' => ExpandRowColumn::className(),
 *         // you may configure additional properties here
 *     ],
 * ]
 * ```
 *
=======
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ExpandRowColumn extends DataColumn
{
    /**
<<<<<<< HEAD
     * @var integer|Closure the value of this attribute will identify the state of the current row. The following values
     * are supported:
     * - [[GridView::ROW_EXPANDED]] or 0: the row will be expanded by default and will display the collapse indicator.
     * - [[GridView::ROW_COLLAPSED]] or 1: the row will be collapsed by default and will display the expand indicator.
     * - [[GridView::ROW_NONE]] or -1: no indicator will be displayed for the row.
     *
     * If this is not set, `$model[$attribute]` will be used to obtain the value. If this value is evaluated as empty
     * or null, it is treated as [[GridView::ROW_NONE]]. This can also be an anonymous function that returns one of
     * the values above. The anonymous function should have the signature `function ($model, $key, $index, $column)`,
     * where:
     * - `$model`: _\yii\base\Model_, is the data model.
     * - `$key`: _string|object_, is the primary key value associated with the data model.
     * - `$index`: _integer_, is the zero-based index of the data model among the model array returned by [[dataProvider]].
     * - `$column`: _ExpandRowColumn_, is the column object instance.
=======
     * @var int|Closure the value of this attribute will identify the state of the current row. The following values
     *     are supported:
     * - [[GridView::ROW_EXPANDED]] or 0: the row will be expanded by default and will display the collapse indicator.
     * - [[GridView::ROW_COLLAPSED]] or 1: the row will be collapsed by default and will display the expand indicator.
     * - [[GridView::ROW_NONE]] or -1: no indicator will be displayed for the row.
     * If this is not set, `$model[$attribute]` will be used to obtain the value. If this value is evaluated as empty
     *     or null, it is treated as [[GridView::ROW_NONE]]. This can also be an anonymous function that returns one of
     *     the values above. The anonymous function should have the signature:
     * `function ($model, $key, $index, $column)`, where:
     * - $model mixed is the data model
     * - $key mixed is the key associated with the data model
     * - $index integer is the zero-based index of the data model among the models array returned by
     *     [[GridView::dataProvider]].
     * - $column ExpandRowColumn is the column object instance
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $value = GridView::ROW_NONE;

    /**
     * @var boolean whether to toggle the expansion/collapse by clicking on the table row. To disable row click for
<<<<<<< HEAD
     * specific elements within the row you can add the CSS class `kv-disable-click` to tags/elements to disable
     * the toggle functionality.
=======
     *     specific elements within the row you can add the CSS class `kv-disable-click` to tags/elements to disable
     *     the toggle functionality.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $enableRowClick = false;

    /**
     * @var array list of tags in the row on which row click will be disabled.
     */
    public $rowClickExcludedTags = ['a', 'button', 'input'];

    /**
     * @var array additional data that will be passed to the ajax load function as key value pairs
     */
    public $extraData = [];

    /**
     * @var string icon for the expand indicator. If this is not set, it will derive values automatically using the
<<<<<<< HEAD
     * following rules:
=======
     *     following rules:
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     * - If GridView `bootstrap` property is set to `true`, it will default to [[GridView::ICON_EXPAND]]
     *   or `<span class="glyphicon glyphicon-expand"></span>`
     * - If GridView `bootstrap` property is set to `false`, then it will default to `+`.
     */
    public $expandIcon;

    /**
     * @var string icon for the collapse indicator. If this is not set, it will derive values automatically using the
<<<<<<< HEAD
     * following rules:
=======
     *     following rules:
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     * - If GridView `bootstrap` property is set to `true`, it will default to [[GridView::ICON_COLLAPSE]]
     *   or `<span class="glyphicon glyphicon-collapse-down"></span>`
     * - If GridView `bootstrap` property is set to `false`, then it will default to `-`.
     */
    public $collapseIcon;

    /**
<<<<<<< HEAD
     * @var string title to display on hover of expand indicator for each row.
=======
     * @var string title to display on hover of expand indicator for each row
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $expandTitle;

    /**
<<<<<<< HEAD
     * @var string title to display on hover of collapse indicator for each row.
=======
     * @var string title to display on hover of collapse indicator for each row
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $collapseTitle;

    /**
<<<<<<< HEAD
     * @var string title to display on hover of expand indicator at header.
=======
     * @var string title to display on hover of expand indicator at header
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $expandAllTitle;

    /**
<<<<<<< HEAD
     * @var string title to display on hover of collapse indicator at header.
=======
     * @var string title to display on hover of collapse indicator at header
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $collapseAllTitle;

    /**
<<<<<<< HEAD
     * @var integer default state of the header. The following values can be set:
     * - [[GridView::ROW_COLLAPSED]]: Will set all rows to collapsed and display the [[expandIcon]].
     * - [[GridView::ROW_EXPANDED]]: Will set all rows to expanded and display the [[collapseIcon]].
=======
     * @var int default state of the header.
     * - GridView::ROW_COLLAPSED: Will set all rows to collapsed and display the `expandIcon`
     * - GridView::ROW_EXPANDED : Will set all rows to expanded and display the `collapseIcon`
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $defaultHeaderState = GridView::ROW_COLLAPSED;

    /**
     * @var boolean whether to enable caching of expanded row content while expanding the row using ajax triggered
<<<<<<< HEAD
     * action (applicable when `detailUrl` is set). Defaults to `true`.
=======
     *     action (applicable when `detailUrl` is set). Defaults to `true`.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $enableCache = true;

    /**
     * @var boolean whether to allow only one row to be expanded at a time and auto collapse other expanded rows
<<<<<<< HEAD
     * whenever a row is expanded. Defaults to `false`.
=======
     *     whenever a row is expanded. Defaults to `false`.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $expandOneOnly = false;

    /**
     * @var boolean allow batch expansion or batch collapse of all rows by clicking the header indicator. Defaults to
<<<<<<< HEAD
     * `true`.
=======
     *     `true`.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $allowBatchToggle = true;

    /**
     * @var boolean|Closure whether the expand icon indicator is disabled. Defaults to `false`. If set to `true`, one
<<<<<<< HEAD
     * cannot collapse or expand the sections. This can be setup as an anonymous function having the signature:
     * `function ($model, $key, $index, $column)`, where:
     * - `$model`: _\yii\base\Model_, is the data model.
     * - `$key`: _string|object_, is the primary key value associated with the data model.
     * - `$index`: _integer_, is the zero-based index of the data model among the model array returned by [[dataProvider]].
     * - `$column`: _ExpandRowColumn_, is the column object instance.
=======
     *     cannot collapse or expand the sections. This can be setup as an anonymous function having the signature:
     * `function ($model, $key, $index, $column)`, where:
     * - $model mixed is the data model
     * - $key mixed is the key associated with the data model
     * - $index integer is the zero-based index of the data model among the models array returned by
     *     [[GridView::dataProvider]].
     * - $column ExpandRowColumn is the column object instance
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $disabled = false;

    /**
<<<<<<< HEAD
     * @var string|Closure the detail content (html markup) to be displayed in the expanded row. Either [[detail]]
     * or [[detailUrl]] must be entered. This can be a normal html markup or an anonymous function that returns the
     * markup. The anonymous function should have the signature:
     * `function ($model, $key, $index, $column)`, where:
     * - `$model`: _\yii\base\Model_, is the data model.
     * - `$key`: _string|object_, is the primary key value associated with the data model.
     * - `$index`: _integer_, is the zero-based index of the data model among the model array returned by [[dataProvider]].
     * - `$column`: _ExpandRowColumn_, is the column object instance.
=======
     * @var string|Closure the detail content (html markup) to be displayed in the expanded row. Either `detail` OR
     *     `detailUrl` must be entered. This can be a normal html markup or an anonymous function that returns the
     *     markup. The anonymous function should have the signature:
     * `function ($model, $key, $index, $column)`, where:
     * - $model mixed is the data model
     * - $key mixed is the key associated with the data model
     * - $index integer is the zero-based index of the data model among the models array returned by
     *     [[GridView::dataProvider]].
     * - $column ExpandRowColumn is the column object instance
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $detail = '';

    /**
     * @var string the url/action that would render the detail content via ajax. Either `detail` OR `detailUrl` must be
<<<<<<< HEAD
     * entered. The ajax response must return the content/markup to render. The extension automatically passes the
     * following data parameters to the server URL as POST data:
     * - `expandRowKey` the key associated with the data model
     * - `expandRowIndex` the zero-based index of the data model among the models array returned by
     *   [[GridView::dataProvider]].
=======
     *     entered. The ajax response must return the content/markup to render. The extension automatically passes the
     *     following data parameters to the server URL as POST data:
     * - `expandRowKey` the key associated with the data model
     * - `expandRowIndex` the zero-based index of the data model among the models array returned by
     *     [[GridView::dataProvider]].
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     * @see http://api.jquery.com/jquery.load/
     */
    public $detailUrl;

    /**
     * @var string|JsExpression the javascript callback to execute after loading the content via ajax. Only applicable
<<<<<<< HEAD
     * when detailUrl is provided.
=======
     *     when detailUrl is provided.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $onDetailLoaded = '';

    /**
     * @var array|Closure the HTML attributes for the expanded table row. This can be an array or an anonymous function
<<<<<<< HEAD
     * of the signature:
     * `function ($model, $key, $index, $column)`, where:
     * - `$model`: _\yii\base\Model_, is the data model.
     * - `$key`: _string|object_, is the primary key value associated with the data model.
     * - `$index`: _integer_, is the zero-based index of the data model among the model array returned by [[dataProvider]].
     * - `$column`: _ExpandRowColumn_, is the column object instance.
=======
     *     of the signature:
     * `function ($model, $key, $index, $column)`, where:
     * - $model mixed is the data model
     * - $key mixed is the key associated with the data model
     * - $index integer is the zero-based index of the data model among the models array returned by
     *     [[GridView::dataProvider]].
     * - $column ExpandRowColumn is the column object instance
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $detailOptions = [];

    /**
<<<<<<< HEAD
     * @var string the CSS class for the detail content table row.
=======
     * @var string the CSS class for the detail content table row
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $detailRowCssClass = GridView::TYPE_INFO;

    /**
<<<<<<< HEAD
     * @var string|integer the animation duration to slide up/down the detail row.
=======
     * @var string|integer the animation duration to slide up/down the detail row
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     * @see http://api.jquery.com/slidedown/
     */
    public $detailAnimationDuration = 'slow';

    /**
<<<<<<< HEAD
     * @inheritdoc
=======
     * @var boolean|array whether the column is hidden in export output. If set to boolean `true`, it will hide the
     *     column for all export formats. If set as an array, it will accept the list of GridView export `formats` and
     *     hide output only for them.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $hiddenFromExport = true;

    /**
<<<<<<< HEAD
     * @inheritdoc
     */
    public $hAlign = GridView::ALIGN_CENTER;

    /**
     * @inheritdoc
=======
     * @var string the horizontal alignment of each column. Should be one of 'left', 'right', or 'center'. Defaults to
     *     `center`.
     */
    public $hAlign = 'center';

    /**
     * @var string the width of each column (matches the CSS width property). Defaults to `50px`.
     * @see http://www.w3schools.com/cssref/pr_dim_width.asp
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $width = '50px';

    /**
<<<<<<< HEAD
     * @inheritdoc
=======
     * @var boolean whether to merge the header title row and the filter row This will not render the filter for the
     *     column and can be used when `filter` is set to `false`. Defaults to `false`. This is only applicable when
     *     `filterPosition` for the grid is set to FILTER_POS_BODY.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $mergeHeader = true;

    /**
<<<<<<< HEAD
     * @var string hashed javascript variable to store grid expand row options
     */
    protected $_hashVar;

    /**
     * Parses data for Closure and returns accordingly
     *
     * @param string|Closure $data the data to parse.
     * @param Model $model the data model.
     * @param string|object $key the key associated with the data model.
     * @param integer $index the zero-based index of the data model among the models array returned by
     * [[GridView::dataProvider]].
     * @param ExpandRowColumn $column the column object instance.
     *
     * @return string
     */
    protected static function parseData($data, $model, $key, $index, $column)
    {
        if ($data instanceof Closure) {
            $data = call_user_func($data, $model, $key, $index, $column);
        }
        return $data;
    }
=======
     * @var boolean|string|Closure the page summary that is displayed above the footer.
     * Defaults to false.
     */
    public $pageSummary = false;

    /**
     * @var string hashed javascript variable to store grid expand row options
     */
    protected $_hashVar;
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (empty($this->detail) && empty($this->detailUrl)) {
            throw new InvalidConfigException("Either the 'detail' or 'detailUrl' must be entered");
        }
        $this->format = 'raw';
        $this->expandIcon = $this->getIcon('expand');
        $this->collapseIcon = $this->getIcon('collapse');
        $this->setProp('expandTitle', Yii::t('kvgrid', 'Expand'));
        $this->setProp('collapseTitle', Yii::t('kvgrid', 'Collapse'));
        $this->setProp('expandAllTitle', Yii::t('kvgrid', 'Expand All'));
        $this->setProp('collapseAllTitle', Yii::t('kvgrid', 'Collapse All'));
        $onDetailLoaded = $this->onDetailLoaded;
        if (!empty($onDetailLoaded) && !$onDetailLoaded instanceof JsExpression) {
            $onDetailLoaded = new JsExpression($onDetailLoaded);
        }
        if ($this->allowBatchToggle) {
            $this->headerOptions['title'] = $this->expandAllTitle;
        }
        if ($this->allowBatchToggle && $this->defaultHeaderState === GridView::ROW_EXPANDED) {
            $this->headerOptions['title'] = $this->collapseTitle;
        }
        $class = 'kv-expand-header-cell';
        $class .= $this->allowBatchToggle ? ' kv-batch-toggle' : ' text-muted';
        Html::addCssClass($this->headerOptions, $class);
        $view = $this->grid->getView();
        ExpandRowColumnAsset::register($view);
        $clientOptions = Json::encode(
            [
                'gridId' => $this->grid->options['id'],
                'hiddenFromExport' => $this->hiddenFromExport,
                'detailUrl' => empty($this->detailUrl) ? '' : $this->detailUrl,
                'onDetailLoaded' => $onDetailLoaded,
                'expandIcon' => $this->expandIcon,
                'collapseIcon' => $this->collapseIcon,
                'expandTitle' => $this->expandTitle,
                'collapseTitle' => $this->collapseTitle,
                'expandAllTitle' => $this->expandAllTitle,
                'collapseAllTitle' => $this->collapseAllTitle,
                'rowCssClass' => $this->detailRowCssClass,
                'animationDuration' => $this->detailAnimationDuration,
                'expandOneOnly' => $this->expandOneOnly,
                'enableRowClick' => $this->enableRowClick,
                'enableCache' => $this->enableCache,
                'rowClickExcludedTags' => array_map('strtoupper', $this->rowClickExcludedTags),
                'collapseAll' => false,
                'expandAll' => false,
<<<<<<< HEAD
                'extraData' => $this->extraData,
=======
                'extraData' => $this->extraData
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
            ]
        );
        $this->_hashVar = 'kvExpandRow_' . hash('crc32', $clientOptions);
        $view->registerJs("var {$this->_hashVar} = {$clientOptions};\n", View::POS_HEAD);
        $view->registerJs("kvExpandRow({$this->_hashVar});");
    }

    /**
<<<<<<< HEAD
=======
     * Get icon indicator
     *
     * @param string $type one of `expand` or `collapse`
     *
     * @return string the icon indicator markup
     */
    protected function getIcon($type)
    {
        $setting = "{$type}Icon";
        if (!empty($this->$setting)) {
            return $this->$setting;
        }
        $bs = $this->grid->bootstrap;
        if ($type === 'expand') {
            return $bs ? GridView::ICON_EXPAND : '+';
        }
        if ($type === 'collapse') {
            return $bs ? GridView::ICON_COLLAPSE : '-';
        }
        return null;
    }

    /**
     * Sets property for the object instance if not set
     *
     * @param string $prop the property name
     * @param string $val the property value
     */
    protected function setProp($prop, $val)
    {
        if (!isset($this->$prop)) {
            $this->$prop = $val;
        }
    }

    /**
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     * @inheritdoc
     */
    public function getDataCellValue($model, $key, $index)
    {
        $value = parent::getDataCellValue($model, $key, $index);
        /** @noinspection PhpUnusedLocalVariableInspection */
        $icon = '';
        if ($value === GridView::ROW_EXPANDED) {
            $type = 'collapsed';
            $icon = $this->collapseIcon;
        } elseif ($value === GridView::ROW_COLLAPSED) {
            $type = 'expanded';
            $icon = $this->expandIcon;
        } else {
            return $value;
        }
        $detail = static::parseData($this->detail, $model, $key, $index, $this);
        $detailOptions = static::parseData($this->detailOptions, $model, $key, $index, $this);
        $disabled = static::parseData($this->disabled, $model, $key, $index, $this) ? ' kv-state-disabled' : '';
        if ($this->hiddenFromExport) {
            Html::addCssClass($detailOptions, 'skip-export');
        }
        $detailOptions['data-index'] = $index;
        $detailOptions['data-key'] = !is_string($key) && !is_numeric($key) ?
            (is_array($key) ? Json::encode($key) : (string)$key) : $key;
<<<<<<< HEAD
        $id = $this->grid->options['id'];
        Html::addCssClass($detailOptions, ['kv-expanded-row', $id]);
        $content = Html::tag('div', $detail, $detailOptions);
        return <<< HTML
        <div class="kv-expand-row {$id}{$disabled}">
            <div class="kv-expand-icon kv-state-{$type}{$disabled} {$id}">{$icon}</div>
            <div class="kv-expand-detail skip-export {$id}" style="display:none;">
=======
        Html::addCssClass($detailOptions, 'kv-expanded-row');
        $content = Html::tag('div', $detail, $detailOptions);
        return <<< HTML
        <div class="kv-expand-row{$disabled}">
            <div class="kv-expand-icon kv-state-{$type}{$disabled}">{$icon}</div>
            <div class="kv-expand-detail skip-export" style="display:none;">
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
                {$content}
            </div>
        </div>
HTML;
    }

    /**
<<<<<<< HEAD
=======
     * Parses data for Closure and returns accordingly
     *
     * @param mixed           $data the data to parse
     * @param mixed           $model is the data model
     * @param mixed           $key is the key associated with the data model
     * @param integer         $index is the zero-based index of the data model among the models array returned by
     *     [[GridView::dataProvider]].
     * @param ExpandRowColumn $column is the column object instance
     *
     * @return mixed
     */
    protected static function parseData($data, $model, $key, $index, $column)
    {
        if ($data instanceof \Closure) {
            $data = call_user_func($data, $model, $key, $index, $column);
        }
        return $data;
    }

    /**
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     * @inheritdoc
     */
    public function renderDataCell($model, $key, $index)
    {
        $options = $this->fetchContentOptions($model, $key, $index);
        $css = 'kv-expand-icon-cell';
        $options['title'] = $this->expandTitle;
        if ($this->value === GridView::ROW_EXPANDED) {
            $options['title'] = $this->collapseTitle;
        }
        if (static::parseData($this->disabled, $model, $key, $index, $this)) {
            $css .= ' kv-state-disabled';
        }
        Html::addCssClass($options, $css);
        $this->initPjax("kvExpandRow({$this->_hashVar});");
        return Html::tag('td', $this->renderDataCellContent($model, $key, $index), $options);
    }

    /**
<<<<<<< HEAD
     * Get icon indicator
     *
     * @param string $type one of `expand` or `collapse`
     *
     * @return string the icon indicator markup
     */
    protected function getIcon($type)
    {
        $setting = "{$type}Icon";
        if (!empty($this->$setting)) {
            return $this->$setting;
        }
        $bs = $this->grid->bootstrap;
        if ($type === 'expand') {
            return $bs ? GridView::ICON_EXPAND : '+';
        }
        if ($type === 'collapse') {
            return $bs ? GridView::ICON_COLLAPSE : '-';
        }
        return null;
    }

    /**
     * Sets property for the object instance if not set
     *
     * @param string $prop the property name
     * @param string $val the property value
     */
    protected function setProp($prop, $val)
    {
        if (!isset($this->$prop)) {
            $this->$prop = $val;
        }
    }

    /**
     * @inheritdoc
=======
     * Renders the header cell content. The default implementation simply renders [[header]]. This method may be
     * overridden to customize the rendering of the header cell.
     *
     * @return string the rendering result
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    protected function renderHeaderCellContent()
    {
        if ($this->header !== null) {
            return parent::renderHeaderCellContent();
        }
        $icon = $this->expandIcon;
        $css = 'kv-expand-header-icon kv-state-collapsed';
        if ($this->defaultHeaderState === GridView::ROW_EXPANDED) {
            $icon = $this->collapseIcon;
            $css = 'kv-expand-header-icon kv-state-expanded';
        }
        return "<div class='{$css}'>{$icon}</div>";
    }
}
