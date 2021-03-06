<?php


/* @var $this yii\web\View */
use common\models\Campaign;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;

/* @var $searchModel common\models\ReportChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $summary yii\data\ActiveDataProvider */
$this->title = 'Channel Report';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="report-channel"></div>
<?php echo $this->render('report_channel_search', ['model' => $searchModel]);
if ($searchModel->type == 2) {
    $layout = '{summary} {items} {pager}';
} else {
    $layout = '{toolbar}{summary} {items} {pager}';
}
$time_row = [];
if (!empty($searchModel->type)) {
    $format = 'php:Y-m-d H:i';
    if ($searchModel->type == 2) {
        $format = 'php:Y-m-d';
    }
    $time_row = [
        'label' => 'Time(UTC)',
        'attribute' => 'timestamp',
        'value' => function ($model) use ($searchModel) {
            $model = (object)$model;
            $format = 'Y-m-d H:i';
            if ($searchModel->type == 2) {
                $format = 'Y-m-d';
            }
            $date = new DateTime();
            $date->setTimezone(new DateTimeZone($searchModel->time_zone));
            $date->setTimestamp($model->timestamp);
            return $date->format($format);
        },
        'filter' => false,

    ];
}
$columns = [
//    [
//        'label' => 'Time(UTC)',
//        'attribute' => 'timestamp',
//        'value' => function ($model) use ($searchModel) {
//            $model = (object)$model;
//            $format = 'Y-m-d H:i';
//            if ($searchModel->type == 2) {
//                $format = 'Y-m-d';
//            }
//            $date = new DateTime();
//            $date->setTimezone(new DateTimeZone($searchModel->time_zone));
//            $date->setTimestamp($model->timestamp);
//            return $date->format($format);
//        },
//        'filter' => false,
//        'pageSummary' => 'Page Total',
//    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{all}',
        'header' => 'Action',
        'buttons' => [
            'all' => function ($url, $model, $key) use ($searchModel){
                $model = (object)$model;
                return '<div class="dropdown">
              <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Actions
              <span class="caret"></span></button>
              <ul class="dropdown-menu">
              <li><a data-view="0"  href="/channel-quality-report/quality?campaign=' . $model->campaign_id . '&channel='.$model->channel_id.'&timeZone='.$searchModel->time_zone.'">quality</a></li>
              <li><a data-view="0" data-url="/deliver/view?channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">View</a></li>
              <li><a data-view="0" data-url="/campaign-sts-update/pause?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Paused</a></li>
              <li><a data-view="0" data-url="/campaign-sts-update/sub-pause?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Sub Paused</a></li>
              <li><a data-view="0" data-url="/campaign-sts-update/update-cap?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Update Cap</a></li>
              <li><a data-view="0" data-url="/campaign-sts-update/update-discount?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Update Discount</a></li>
              <li><a data-view="0" data-url="/campaign-sts-update/update-payout?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Update Payout</a></li>
              <li><a data-view="0" data-url="/redirect-log/create?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Redirect</a></li>
              <li><a data-view="0" data-url="/redirect-log/detail?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">View Redirect</a></li>
              <li><a data-view="0" data-url="/campaign-sub-channel-log-redirect/create?channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Sub Redirect</a></li>
              <li><a data-view="0" data-url="/deliver/send-email?channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Send Email</a></li>
              <li><a data-view="0" href="/deliver/view-email?channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">View Email</a></li>
              <li><a data-view="0" data-url="/my-cart/add-my-cart?campaign_id=' . $model->campaign_id . '">Add to Cart</a></li>
              </ul>
            </div>';
            },
        ],
    ],
    [
        'label' => 'Channel',
        'attribute' => 'channel_name',
        'value' => 'channel_name',
        'filter' => false,
        'contentOptions'=>['style'=>'max-width: 160px;'], // <-- right here
    ],
//    'campaign.advertiser0.username',
    [
        'attribute' => 'adv',
        'value' => 'adv',
        'filter' => false,
        'contentOptions'=>['style'=>'max-width: 140px;'], // <-- right here
    ],
    [
        'label' => 'Campaign ID',
        'attribute' => 'campaign_id',
        'value' => 'campaign_id',
        'filter' => false,
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'campaign_name',
        'value' => function ($data) {
            $data = (object)$data;
            if (isset($data->campaign_name)) {
                return Html::tag('div', Campaign::findById($data->campaign_id)->getName(), ['data-toggle' => 'tooltip', 'data-placement' => 'left', 'title' => $data->campaign_name, 'style' => 'cursor:default;']);
            } else {
                return '';
            }
        },
        'width' => '60px',
        'format' => 'raw',
        'filter' => false,
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
        'label' => 'Installs /Cap',
        'attribute' => 'installs',
        'value' => function ($model) {
            $model = (object)$model;
            return $model->installs . '/' . $model->daily_cap;
        },
        'filter' => false,
        'pageSummary' => true,
    ],
    [
        'attribute' => 'redirect_installs',
        'filter' => false,
        'pageSummary' => true,
    ],
//    [
//        'label' => 'Remaining Cap',
//        'attribute' => 'cap',
//        'value' => function ($model) {
//            $model = (object)$model;
//            if ($model->cap == 'open') {
//                return $model->cap;
//            } else {
//                return $model->cap - $model->match_installs;
//            }
//        },
//        'filter' => false,
//        'contentOptions' => function ($model) {
//            $model = (object)$model;
//            if ($model->daily_cap != 'open') {
//                if ($model->daily_cap - $model->installs < 10) {
//                    return ['class' => 'bg-danger'];
//                }
//            }
//        }
//    ],
    [
        'attribute' => 'cvr',
        'value' => function ($model) {
            $model = (object)$model;
            if ($model->clicks > 0) {
                return round(($model->installs / $model->clicks) * 100, 2) . '%';
            }
            return "0%";
        },
        'filter' => false,
        'contentOptions' => function ($model) {
            $model = (object)$model;
            $cvr = 0;
            if ($model->clicks > 0) {
                $cvr = round(($model->installs / $model->clicks) * 100, 2);
            }
            if ($cvr > 2) {
                return ['class' => 'bg-danger'];
            }
        }
    ],

    [
        'label' => 'Payout (avg)',
        'attribute' => 'pay_out',
        'value' => function ($model) {
            $model = (object)$model;
            return round($model->pay_out, 2);
        },
        'filter' => false,
    ],
    [
        'attribute' => 'cost',
        'filter' => false,
        'pageSummary' => true,
    ],
    [
        'attribute' => 'redirect_cost',
        'filter' => false,
        'pageSummary' => true,
    ],
    [
        'label' => 'Match Installs /Cap',
        'attribute' => 'match_installs',
        'value' => function ($model) {
            $model = (object)$model;
            return $model->match_installs . '/' . $model->cap;
        },
        'filter' => false,
        'pageSummary' => true,
    ],
    [
        'attribute' => 'redirect_match_installs',
        'filter' => false,
        'pageSummary' => true,
    ],
    [
        'attribute' => 'match_cvr',
        'value' => function ($model) {
            $model = (object)$model;
            if ($model->clicks > 0) {
                return round(($model->match_installs / $model->clicks) * 100, 2) . '%';

            }
            return 0;
        },
        'filter' => false,
        'contentOptions' => function ($model) {
            $model = (object)$model;
            if ($model->clicks > 0) {
                $match_cvr = round(($model->match_installs / $model->clicks) * 100, 2) . '%';
                if ($match_cvr > 2) {
                    return ['class' => 'bg-danger'];
                }
            }
        }
    ],
    [
        'label' => 'ADV Price (avg)',
        'attribute' => 'adv_price',
        'value' => function ($model) {
            $model = (object)$model;
            return round($model->adv_price, 2);
        },
        'filter' => false,
    ],

    [
        'attribute' => 'revenue',
//        'value' => 'revenue',
        'filter' => false,
        'pageSummary' => true,
    ],

    [
        'attribute' => 'redirect_revenue',
//        'value' => 'revenue',
        'filter' => false,
        'pageSummary' => true,
    ],
    [
        'attribute' => 'def',
        'value' => function ($model) {
            $model = (object)$model;
            return $model->match_installs - $model->installs;
        },
        'filter' => false,
        'pageSummary' => true,
    ],

    [
        'attribute' => 'deduction_percent',
        'value' => function ($model) {
            $model = (object)$model;
            if ($model->match_installs > 0) {
                return round((($model->match_installs - $model->installs) / $model->match_installs) * 100, 2) . '%';
            }
            return 0;
        },
        'filter' => false,
    ],

    [
        'attribute' => 'profit',
        'value' => function ($model) {
            $model = (object)$model;
            return $model->revenue - $model->cost;
        },
        'filter' => false,
        'pageSummary' => true,
    ],
    [ //低于30%
        'attribute' => 'margin',
        'value' => function ($model) {
            $model = (object)$model;
            $profit = $model->revenue - $model->cost;
            $margin = $model->revenue > 0 ? round(($profit / $model->revenue) * 100, 2) . '%' : 0;
            return $margin;
        },
        'filter' => false,
        'contentOptions' => function ($model) {
            $model = (object)$model;
            $profit = $model->revenue - $model->cost;
            $margin = $model->revenue > 0 ? round(($profit / $model->revenue), 2) : 0;
            if ($margin < 0.3) {
                return ['class' => 'bg-danger'];
            }
        }
    ],
    [
        'label' => 'EPC',
        'value' => function ($model) {
            $model = (object)$model;
            $epc=   $model->clicks > 0 ? round(($model->revenue / $model->clicks) * 1000 ,3): 0;
            return $epc;
        },
        'filter' => false,
    ],
    [
        'label' => 'OM',
        'attribute' => 'om',
        'value' => 'om',
    ],
];

if (!empty($searchModel->type)) {
    array_unshift($columns, $time_row);
}

if (!empty($dataProvider)) {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <div class="campaign-log-hourly-index">
                        <?php echo GridView::widget([
                            'dataProvider' => $summary,
                            'layout' => '{items}',
                            'columns' => [
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
                                    'attribute' => 'redirect_installs',
                                    'filter' => false,
                                    'pageSummary' => true,
                                ],
                                [
                                    'attribute' => 'cvr',
                                    'value' => function ($model) {
                                        $model = (object)$model;
                                        if ($model->clicks > 0) {
                                            return round(($model->installs / $model->clicks) * 100, 2) . '%';
                                        }
                                        return 0;
                                    },
                                    'filter' => false,
                                ],
                                [
                                    'attribute' => 'cost',
                                    'filter' => false,
                                    'pageSummary' => true,
                                ],
                                [
                                    'attribute' => 'redirect_cost',
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
                                    'attribute' => 'redirect_match_installs',
                                    'filter' => false,
                                    'pageSummary' => true,
                                ],
                                [
                                    'attribute' => 'match_cvr',
                                    'value' => function ($model) {
                                        $model = (object)$model;
                                        if ($model->clicks > 0) {
                                            return round(($model->match_installs / $model->clicks) * 100, 2) . '%';
                                        }
                                        return 0;
                                    },
                                    'filter' => false,
                                ],
                                [
                                    'attribute' => 'revenue',
                                    'filter' => false,
                                    'pageSummary' => true,
                                ],
                                [
                                    'attribute' => 'redirect_revenue',
                                    'filter' => false,
                                    'pageSummary' => true,
                                ],
                                [
                                    'attribute' => 'def',
                                    'value' => function ($model) {
                                        $model = (object)$model;
                                        return $model->match_installs - $model->installs;
                                    },
                                    'filter' => false,
                                    'pageSummary' => true,
                                ],

                                [
                                    'attribute' => 'deduction_percent',
                                    'value' => function ($model) {
                                        $model = (object)$model;
                                        if ($model->match_installs > 0) {
                                            return round((($model->match_installs - $model->installs) / $model->match_installs) * 100, 2) . '%';
                                        }
                                        return 0;
                                    },
                                    'filter' => false,
                                ],

                                [
                                    'attribute' => 'profit',
                                    'value' => function ($model) {
                                        $model = (object)$model;

                                        return $model->revenue - $model->cost;
                                    },
                                    'filter' => false,
                                    'pageSummary' => true,
                                ],
                                [ //低于30%
                                    'attribute' => 'margin',
                                    'value' => function ($model) {
                                        $model = (object)$model;
                                        $profit = $model->revenue - $model->cost;
                                        $margin = $model->revenue > 0 ? round(($profit / $model->revenue) * 100, 2) . '%' : 0;
                                        return $margin;
                                    },
                                    'filter' => false,
                                    'contentOptions' => function ($model) {
                                        $model = (object)$model;
                                        $profit = $model->revenue - $model->cost;
                                        $margin = $model->revenue > 0 ? round(($profit / $model->revenue), 2) : 0;
                                        if ($margin < 0.3) {
                                            return ['class' => 'bg-danger'];
                                        }
                                    }
                                ],
                                [
                                    'label' => 'EPC',
                                    'value' => function ($model) {
                                        $model = (object)$model;
                                        $epc=   $model->clicks > 0 ? round(($model->revenue / $model->clicks) * 1000 ,3): 0;
                                        return $epc;
                                    },
                                    'filter' => false,
                                ],
                            ],
                        ]);

                        $export_columns = [
                            [
                                'label' => 'Channel',
                                'attribute' => 'channel_name',
                                'value' => 'channel_name',
                                'filter' => false,
                                'contentOptions'=>['style'=>'max-width: 160px;'], // <-- right here
                            ],
                            [
                                'attribute' => 'adv',
                                'value' => 'adv',
                                'filter' => false,
                                'contentOptions'=>['style'=>'max-width: 140px;'], // <-- right here
                            ],
                            [
                                'label' => 'Campaign ID',
                                'attribute' => 'campaign_id',
                                'value' => 'campaign_id',
                                'filter' => false,
                            ],
                            'campaign_name',
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
                                'label' => 'Installs /Cap',
                                'attribute' => 'installs',
                                'value' => function ($model) {
                                    $model = (object)$model;
                                    return $model->installs . '/' . $model->daily_cap;
                                },
                                'filter' => false,
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'redirect_installs',
                                'filter' => false,
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'cvr',
                                'value' => function ($model) {
                                    $model = (object)$model;
                                    if ($model->clicks > 0) {
                                        return round(($model->installs / $model->clicks) * 100, 2) . '%';
                                    }
                                    return "0%";
                                },
                                'filter' => false,
                                'contentOptions' => function ($model) {
                                    $model = (object)$model;
                                    $cvr = 0;
                                    if ($model->clicks > 0) {
                                        $cvr = round(($model->installs / $model->clicks) * 100, 2);
                                    }
                                    if ($cvr > 2) {
                                        return ['class' => 'bg-danger'];
                                    }
                                }
                            ],

                            [
                                'label' => 'Payout (avg)',
                                'attribute' => 'pay_out',
                                'value' => function ($model) {
                                    $model = (object)$model;
                                    return round($model->pay_out, 2);
                                },
                                'filter' => false,
                            ],
                            [
                                'attribute' => 'cost',
                                'filter' => false,
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'redirect_cost',
                                'filter' => false,
                                'pageSummary' => true,
                            ],
                            [
                                'label' => 'Match Installs /Cap',
                                'attribute' => 'match_installs',
                                'value' => function ($model) {
                                    $model = (object)$model;
                                    return $model->match_installs . '/' . $model->cap;
                                },
                                'filter' => false,
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'redirect_match_installs',
                                'filter' => false,
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'match_cvr',
                                'value' => function ($model) {
                                    $model = (object)$model;
                                    if ($model->clicks > 0) {
                                        return round(($model->match_installs / $model->clicks) * 100, 2) . '%';

                                    }
                                    return 0;
                                },
                                'filter' => false,
                                'contentOptions' => function ($model) {
                                    $model = (object)$model;
                                    if ($model->clicks > 0) {
                                        $match_cvr = round(($model->match_installs / $model->clicks) * 100, 2) . '%';
                                        if ($match_cvr > 2) {
                                            return ['class' => 'bg-danger'];
                                        }
                                    }
                                }
                            ],
                            [
                                'label' => 'ADV Price (avg)',
                                'attribute' => 'adv_price',
                                'value' => function ($model) {
                                    $model = (object)$model;
                                    return round($model->adv_price, 2);
                                },
                                'filter' => false,
                            ],
                            [
                                'attribute' => 'revenue',
                                'filter' => false,
                                'pageSummary' => true,
                            ],

                            [
                                'attribute' => 'redirect_revenue',
                                'filter' => false,
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'def',
                                'value' => function ($model) {
                                    $model = (object)$model;
                                    return $model->match_installs - $model->installs;
                                },
                                'filter' => false,
                                'pageSummary' => true,
                            ],

                            [
                                'attribute' => 'deduction_percent',
                                'value' => function ($model) {
                                    $model = (object)$model;
                                    if ($model->match_installs > 0) {
                                        return round((($model->match_installs - $model->installs) / $model->match_installs) * 100, 2) . '%';
                                    }
                                    return 0;
                                },
                                'filter' => false,
                            ],

                            [
                                'attribute' => 'profit',
                                'value' => function ($model) {
                                    $model = (object)$model;
                                    return $model->revenue - $model->cost;
                                },
                                'filter' => false,
                                'pageSummary' => true,
                            ],
                            [ //低于30%
                                'attribute' => 'margin',
                                'value' => function ($model) {
                                    $model = (object)$model;
                                    $profit = $model->revenue - $model->cost;
                                    $margin = $model->revenue > 0 ? round(($profit / $model->revenue) * 100, 2) . '%' : 0;
                                    return $margin;
                                },
                                'filter' => false,
                                'contentOptions' => function ($model) {
                                    $model = (object)$model;
                                    $profit = $model->revenue - $model->cost;
                                    $margin = $model->revenue > 0 ? round(($profit / $model->revenue), 2) : 0;
                                    if ($margin < 0.3) {
                                        return ['class' => 'bg-danger'];
                                    }
                                }
                            ],
                            [
                                'label' => 'EPC',
                                'value' => function ($model) {
                                    $model = (object)$model;
                                    $epc=   $model->clicks > 0 ? round(($model->revenue / $model->clicks) * 1000 ,3): 0;
                                    return $epc;
                                },
                                'filter' => false,
                            ],
                            [
                                'label' => 'OM',
                                'attribute' => 'om',
                                'value' => 'om',
                            ],
                        ];
                        ?>

                        <?php echo ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $export_columns,
                            'fontAwesome' => true,
                            'showConfirmAlert' => false,
                            'target' => GridView::TARGET_BLANK,
                            'dropdownOptions' => [
                                'label' => 'Export All',
                                'class' => 'btn btn-default'
                            ],
                            'exportConfig' => [
                                ExportMenu::FORMAT_TEXT => false,
                                ExportMenu::FORMAT_PDF => false,
                                ExportMenu::FORMAT_EXCEL_X => false,
                                ExportMenu::FORMAT_HTML => false,
                            ],
                        ]);
                        ?>
                        <?php echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'showPageSummary' => true,
                            'layout' => $layout,
                            'pjax' => true,
                            'pjaxSettings' => [
                                'options'=>[
                                    'id' => 'kv-unique-id-report'
                                ]
                            ],
                            'toolbar' => [
                                '{toggleData}',
                            ],
                            'columns' => $columns,
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php
$this->registerJsFile(
    '@web/js/deliver.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
<?php Modal::begin([
    'id' => 'deliver-modal',
    'size' => 'modal-md',
//    'header' =>'00',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
    ],
]);

echo '<div id="deliver-detail-content"></div>';

Modal::end(); ?>