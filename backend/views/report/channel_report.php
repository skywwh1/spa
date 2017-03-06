<?php


/* @var $this yii\web\View */
use kartik\grid\GridView;

/* @var $searchModel common\models\ReportChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Channel Report';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="report-channel"></div>
<?php echo $this->render('_search', ['model' => $searchModel]);
if (!empty($dataProvider)) {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <div class="campaign-log-hourly-index">


                        <?php echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'showPageSummary' => true,
                            'layout' => '{toolbar}{summary} {items} {pager}',
                            'toolbar' => [
                                '{toggleData}',
                            ],
                            'columns' => [
                                [
                                    'label' => 'Time(UTC)',
                                    'attribute' => 'time',
//                                 'value' => 'time:datetime',
                                    'format'=>['DateTime','php:Y-m-d H:i'],
                                    'filter' => false,
                                    'pageSummary' => 'Page Total',
                                ],
//                                [
//                                    'label' => 'Time(UTC+8)',
//                                    'attribute' => 'time_format',
//                                    // 'value' => 'time_format',
//                                    'filter' => false,
//                                    'pageSummary' => 'Page Total',
//                                ],
                                [
                                    'label' => 'Channel',
                                    'attribute' => 'channel_name',
                                    'value' => 'channel_name',
                                    'filter' => false,
                                ],
                                [
                                    // 'label' => 'campaign_id',
                                    'attribute' => 'campaign_name',
                                    'value' => 'campaign.name',
                                ],


                                [
                                    // 'label' => 'clicks',
                                    'attribute' => 'clicks',
                                    // 'value' => 'clicks',
                                    'filter' => false,
                                    'pageSummary' => true,
                                ],
                                [
                                    'attribute' => 'unique_clicks',
                                    'value' => 'unique_clicks',
                                    'filter' => false,
                                    'pageSummary' => true,
                                ],
                                [
                                    'attribute' => 'installs',
                                    'value' => 'installs',
                                    'filter' => false,
                                    'pageSummary' => true,
                                ],
                                [
                                    'attribute' => 'cvr',
                                    'value' => function ($model) {
                                        if ($model->clicks > 0) {

                                            return round($model->installs / $model->clicks, 4);
                                        }
                                        return 0;
                                    },
                                    'filter' => false,
                                ],

                                [
                                    'label' => 'Payout(avg)',
                                    'attribute' => 'pay_out',
                                    'value' => 'pay_out',
                                    'filter' => false,
                                ],
                                [
                                    'attribute' => 'cost',
                                    'value' => function ($model) {
                                        return $model->installs * $model->pay_out;
                                    },
                                    'filter' => false,
                                    'pageSummary' => true,
                                ],
                                [
                                    'attribute' => 'match_installs',
                                    'value' => 'match_installs',
                                    'filter' => false,
                                    'pageSummary' => true,
                                ],
                                [
                                    'attribute' => 'match_cvr',
                                    'value' => function ($model) {
                                        if ($model->clicks > 0) {

                                            return round($model->match_installs / $model->clicks, 4);

                                        }
                                        return 0;
                                    },
                                    'filter' => false,
                                ],
                                [
                                    'label' => 'ADV Price(avg)',
                                    'attribute' => 'adv_price',
                                    'value' => 'adv_price',
                                    'filter' => false,
                                ],

                                [
                                    'attribute' => 'revenue',
                                    'value' => function ($model) {
                                        return $model->match_installs * $model->adv_price;
                                    },
                                    'filter' => false,
                                    'pageSummary' => true,
                                ],

                                [
                                    'attribute' => 'def',
                                    'value' => function ($model) {
                                        return $model->match_installs - $model->installs;
                                    },
                                    'filter' => false,
                                    'pageSummary' => true,
                                ],

                                [
                                    'attribute' => 'deduction_percent',
                                    'value' => function ($model) {
                                        if ($model->match_installs > 0) {
                                            return round((($model->match_installs - $model->installs) / $model->match_installs), 4);
                                        }
                                        return 0;
                                    },
                                    'filter' => false,
                                ],

                                [
                                    'attribute' => 'profit',
                                    'value' => function ($model) {
                                        $revenue = $model->match_installs * $model->adv_price;
                                        $cost = $model->installs * $model->pay_out;
                                        return $revenue - $cost;
                                    },
                                    'filter' => false,
                                    'pageSummary' => true,
                                ],
                                [
                                    'attribute' => 'margin',
                                    'value' => function ($model) {
                                        $revenue = $model->match_installs * $model->adv_price;
                                        $cost = $model->installs * $model->pay_out;
                                        $profit = $revenue - $cost;
                                        $margin = $revenue > 0 ? round(($profit / $revenue), 4) : 0;
                                        return $margin;
                                    },
                                    'filter' => false,
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>