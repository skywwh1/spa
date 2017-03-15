<?php

use kartik\date\DatePicker;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\MyCampaignLogDailySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Daily report';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="daily"></div>
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><?= Html::encode($this->title) ?></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php $form = ActiveForm::begin([
                                'action' => ['daily'],
                                'method' => 'get',
                            ]); ?>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label class="control-label">Timezone:</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $form->field($searchModel, 'timezone')->dropDownList(ModelsUtil::timezone, ['value' => !empty($searchModel->timezone) ? $searchModel->timezone : 'Etc/GMT-8'])->label(false) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">

                                    <div class="col-lg-3">
                                        <label class="control-label">Time:</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <?php
                                        echo DatePicker::widget([
                                            'name' => 'MyCampaignLogDailySearch[start]',
                                            'value' => isset($searchModel->start) ? $searchModel->start : Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
                                            'type' => DatePicker::TYPE_RANGE,
                                            'name2' => 'MyCampaignLogDailySearch[end]',
                                            'value2' => isset($searchModel->end) ? $searchModel->end : Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'format' => 'yyyy-mm-dd'
                                            ]
                                        ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-1"></div>

                                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                                    <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
                                </div>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
if (!empty($dataProvider)) {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                //'filterModel' => $searchModel,
                                'pjax' => true, // pjax is set to always true for this demo
                                'responsive' => true,
                                'hover' => true,
                                'showPageSummary' => true,
                                'layout' => '{toolbar}{summary} {items} {pager}',
                                'toolbar' => [
                                    '{toggleData}',
                                ],
                                'columns' => [
                                    [
                                        'label' => 'Time(UTC)',
                                        'attribute' => 'time',
                                        'value' => function ($model) use ($searchModel) {
                                            $format = 'Y-m-d H:i';
                                            $date = new DateTime();
                                            $date->setTimezone(new DateTimeZone($searchModel->timezone));
                                            $date->setTimestamp($model->time);
                                            return $date->format($format);
                                        },
                                        'filter' => false,
                                        'pageSummary' => 'Page Total',
                                        'width' => '150px',
                                    ],
                                    'campaign_id',
                                    [
                                        'class' => '\kartik\grid\DataColumn',
                                        'attribute' => 'campaign_name',
                                        'value' => function ($data) {
                                            if (isset($data->campaign_name)) {
                                                return Html::tag('div', $data->campaign->name, ['data-toggle' => 'tooltip', 'data-placement' => 'left', 'title' => $data->campaign_name, 'style' => 'cursor:default;']);
                                            } else {
                                                return '';
                                            }
                                        },
                                        'width' => '200px',
                                        'format' => 'raw',
                                    ],
                                    [
                                        'attribute' => 'clicks',
                                        'pageSummary' => true,
                                    ],
                                    [
                                        'attribute' => 'unique_clicks',
                                        'pageSummary' => true,
                                    ],
                                    [
                                        'attribute' => 'installs',
                                        'pageSummary' => true,
                                    ],
                                    [
                                        'attribute' => 'cvr(100%)',
                                        'value' => function ($model) {
                                            if ($model->clicks > 0) {

                                                return round($model->installs / $model->clicks, 4) * 100;
                                            }
                                            return 0;
                                        },
                                        'filter' => false,
                                    ],
//                                'pricing_mode',
                                    [
                                        'attribute' => 'pay_out',
                                        'label' => 'pay_out(AVG)',
                                    ],

                                    [
                                        'attribute' => 'revenue',
                                        'value' => function ($model) {
                                            return $model->installs * $model->pay_out;
                                        },
                                        'filter' => false,
                                        'pageSummary' => true,
                                    ],

                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>