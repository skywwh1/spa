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

use Yii;
use Closure;

/**
<<<<<<< HEAD
 * A BooleanColumn will convert true/false values as user friendly indicators with an automated drop down filter for the
 * [[GridView]] widget.
 *
 * To add a BooleanColumn to the gridview, add it to the [[GridView::columns|columns]] configuration as follows:
 *
 * ```php
 * 'columns' => [
 *     // ...
 *     [
 *         'class' => BooleanColumn::className(),
 *         // you may configure additional properties here
 *     ],
 * ]
 * ```
=======
 * A BooleanColumn to convert true/false values as user friendly indicators with an automated drop down filter for the
 * Grid widget [[\kartik\widgets\GridView]]
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class BooleanColumn extends DataColumn
{
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
     * @var string the width of each column (matches the CSS width property). Defaults to `90px`.
     * @see http://www.w3schools.com/cssref/pr_dim_width.asp
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $width = '90px';

    /**
<<<<<<< HEAD
     * @inheritdoc
=======
     * @var string|array in which format should the value of each data model be displayed. Defaults to `raw`.
     * [[\yii\base\Formatter::format()]] or [[\yii\i18n\Formatter::format()]] is used.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $format = 'raw';

    /**
<<<<<<< HEAD
=======
     * @var boolean|string|Closure the page summary that is displayed above the footer. Defaults to false.
     */
    public $pageSummary = false;

    /**
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     * @var string label for the true value. Defaults to `Active`.
     */
    public $trueLabel;

    /**
     * @var string label for the false value. Defaults to `Inactive`.
     */
    public $falseLabel;

    /**
     * @var string icon/indicator for the true value. If this is not set, it will use the value from `trueLabel`. If
<<<<<<< HEAD
     * GridView `bootstrap` property is set to true - it will default to [[GridView::ICON_ACTIVE]].
=======
     *     GridView `bootstrap` property is set to true - it will default to [[GridView::ICON_ACTIVE]] `<span
     *     class="glyphicon glyphicon-ok text-success"></span>`
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $trueIcon;

    /**
     * @var string icon/indicator for the false value. If this is null, it will use the value from `falseLabel`. If
<<<<<<< HEAD
     * GridView `bootstrap` property is set to true - it will default to [[GridView::ICON_INACTIVE]].
=======
     *     GridView `bootstrap` property is set to true - it will default to [[GridView::ICON_INACTIVE]] `<span
     *     class="glyphicon glyphicon-remove text-danger"></span>`
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $falseIcon;

    /**
<<<<<<< HEAD
     * @var boolean whether to show null value as a false icon.
=======
     * @var bool whether to show null value as a false icon.
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
     */
    public $showNullAsFalse = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->trueLabel)) {
            $this->trueLabel = Yii::t('kvgrid', 'Active');
        }
        if (empty($this->falseLabel)) {
            $this->falseLabel = Yii::t('kvgrid', 'Inactive');
        }
        $this->filter = [true => $this->trueLabel, false => $this->falseLabel];

        if (empty($this->trueIcon)) {
            /** @noinspection PhpUndefinedFieldInspection */
            $this->trueIcon = ($this->grid->bootstrap) ? GridView::ICON_ACTIVE : $this->trueLabel;
        }

        if (empty($this->falseIcon)) {
            /** @noinspection PhpUndefinedFieldInspection */
            $this->falseIcon = ($this->grid->bootstrap) ? GridView::ICON_INACTIVE : $this->falseLabel;
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getDataCellValue($model, $key, $index)
    {
        $value = parent::getDataCellValue($model, $key, $index);
        if ($value !== null) {
            return $value ? $this->trueIcon : $this->falseIcon;
        }
        return $this->showNullAsFalse ? $this->falseIcon : $value;
    }
}
