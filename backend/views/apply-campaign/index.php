<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ApplyCampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Applying Offers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div class="apply-campaign-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <div class="col-lg-12">
            <div class="box box-info table-responsive">
                <div class="box-body">
                    <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'campaign.campaign_name',
                            'channel.username',
                            [
                                'attribute' => 'status',
                                'value' => function ($data) {
                                    return ModelsUtil::getApplyStatus($data->status);
                                },
                                'filter' => ModelsUtil::apply_status,
                            ],
                            [
                                'attribute' => 'create_time',
                                'value' => function ($data) {
                                    return $data->create_time;
                                },
                                'filter' => false,
                                'format' => 'datetime',
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{approve}',
                                'header' => 'Action',
                                'buttons' => [
                                    'approve' => function ($url, $model) {
                                        if ($model->status !== 1) {
                                            $class = 'btn btn-primary btn-xs';
                                            $title = Yii::t('yii', 'Applying');
                                            switch ($model->status) {
//                                            case 1:
//                                                $class = 'btn btn-warning disabled btn-xs';
//                                                $title = Yii::t('yii', 'Applying');
//                                                break;
                                                case 2:
                                                    $class = 'btn btn-success disabled btn-xs';
                                                    $title = Yii::t('yii', 'Approved');
                                                    break;
                                                case 3:
                                                    $class = 'btn btn-danger disabled btn-xs';
                                                    $title = Yii::t('yii', 'Reject');
                                                    break;
                                            }
                                            return Html::a($title, '#', [
                                                'class' => $class,
                                                'title' => $title,
                                            ]);
                                        } else {
                                            return Html::a('applying', $url, [
                                                'class' => 'btn btn-primary btn-xs',
                                                'title' => Yii::t('yii', 'Applying'),
                                                'data-method' => 'post',
                                                'data-pjax' => 'w0',

                                            ]);
                                        }
                                    }
                                ],
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
